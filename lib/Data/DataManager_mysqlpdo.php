<?php

namespace Data;

use NChat\User;
use NChat\Channel;
use NChat\Post;
include 'IDataManager.php';

class DataManager implements IDataManager {

	private static $__connection;

	private static function getConnection() {
		if (!isset(self::$__connection)) {
			$type = 'mysql';
			$host = 'localhost';
			$name = 'fh_2018_scm4_S1610307026';
			$user = 'fh_2018_scm4';
			$pass = 'fh_2018_scm4';

			self::$__connection = new \PDO(
				$type . ':host=' . $host . ';dbname=' . $name . ';charset=utf8',  $user, $pass
			);
		}

		return self::$__connection;
	}

	public static function exposeConnection() {
		return self::getConnection();
	}

	private static function query($connection, $query, $parameters = array()) {

		$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

		try {
			$statement = $connection->prepare($query);
			$i = 1;

			foreach ($parameters AS $param) {

				if (is_int($param)) {
					$statement->bindValue($i, $param, \PDO::PARAM_INT);
				}
				if (is_string($param)) {
					$statement->bindValue($i, $param, \PDO::PARAM_STR);
				}

				$i++;
			}

			$result = $statement->execute();
		}
		catch (\Exception $e) {
			die($e->getMessage());
		}

		return $statement;
	}

	private static function lastInsertId($connection) {
		return $connection->lastInsertId();
	}

	private static function fetchObject($cursor) {
		return $cursor->fetchObject();
	}

	private static function close($cursor) {
		$cursor->closeCursor();
	}

	private static function closeConnection($connection) {
		self::$__connection = null;
	}

	public static function getCategories() : array {
		$categories = [];

		$con = self::getConnection();
		$res = self::query($con, "
			SELECT id, name
			FROM categories;
		");

		while ($cat = self::fetchObject($res)) {
			$categories[] = new Category($cat->id, $cat->name);
		}

		self::close($res);
		self::closeConnection($con);

		return $categories;
	}

	public static function getUserById(int $userId) {
		$user = null;

		$con = self::getConnection();
		$res = self::query($con, "
			SELECT id, userName, passwordHash
			FROM users
			WHERE id = ?;
		", [$userId]);

		if ($u = self::fetchObject($res)) {
			$user = new User($u->id, $u->userName, $u->passwordHash);
		}

		self::close($res);
		self::closeConnection($con);

		return $user;
	}

	public static function getUserByUserName(string $userName): ?User {
		$user = null;

		$con = self::getConnection();
		$res = self::query($con, "
			SELECT id, userName, passwordHash
			FROM users
			WHERE userName = ?;
		", [$userName]);

		if ($u = self::fetchObject($res)) {
			$user = new User($u->id, $u->userName, $u->passwordHash);
		}

		self::close($res);
		self::closeConnection($con);

		return $user;
	}

		public static function createUser(string $userName, string $email, string $password) : User{
			$con = self::getConnection();

			self::query($con, "
			INSERT INTO users 
			( 
				userName, 
				passwordHash,
				email
			) VALUES (?,?,?)", 
			[$userName, hash('sha1', $userName.'#'.$password), $email]);

			$usr = self::getUserByUserName($userName);

			self::query($con, "
			INSERT INTO channels_users 
			( 
				id_channel,
				id_user
			) (SELECT id, ? FROM channels);",
			[$usr->getId()]);

			self::closeConnection($con);
			return $usr;
		}

		public static function getAllChannels() : array {
			$con = self::getConnection();
			$res = self::query($con, "
				SELECT name, description
				FROM channels;
			");

			while ($chan = self::fetchObject($res)) {
				$channels[] = new Channel($chan->id, $chan->name, $chan->description, $chan->lastActivity);
			}
	
			self::close($res);
			self::closeConnection($con);
	
			return $channels;
		}

		public static function getChannelsForUser(int $userId) : ?array {
			$con = self::getConnection();
			$res = self::query($con, "
				SELECT id, name, description, lastActivity, id_user
				FROM channels c
				INNER JOIN channels_users cu
				ON c.id = cu.id_channel
				WHERE id_user = ?
				ORDER BY lastActivity DESC
			", [$userId]);

			$chan = null;
			while ($chan = self::fetchObject($res)) {
				$channels[] = new Channel($chan->id, $chan->name, $chan->description, $chan->lastActivity);
			}
	
			self::close($res);
			self::closeConnection($con);
	
			return $channels;
		}

		public static function getPostByPostId(int $postId, int $userId) : ?Post {
			$con = self::getConnection();
			$res = self::query($con, "
				SELECT id, p.id_user, id_channel, title, text, pu.important, timestamp
				FROM posts p
				LEFT OUTER JOIN posts_users_property pu
				ON p.id = pu.id_post AND pu.id_user = ?
				WHERE id = ? AND 
							deleted = 0;
			", [$userId, $postId]);

			if($res != null){
				$post = self::fetchObject($res);
				if($post){
					return new Post($post->id, $post->id_user, $post->id_channel, $post->title, $post->text, $post->important, $post->timestamp);
				}
			}
			return null;
		}

		public static function getPostsByChannelId(int $channelId, int $userId) : ?array {
			$con = self::getConnection();
			$res = self::query($con, "
				SELECT id, p.id_user, id_channel, title, text, pu.important, timestamp
				FROM posts p
				LEFT OUTER JOIN posts_users_property pu
				ON p.id = pu.id_post and pu.id_user = ?
				WHERE id_channel = ? AND 
							deleted = 0
				ORDER BY pu.important DESC;
			", [$userId, $channelId]);


			$posts = null;
			while ($pos = self::fetchObject($res)) {
				$posts[] = new Post($pos->id, $pos->id_user, $pos->id_channel, $pos->title, $pos->text, $pos->important, $pos->timestamp);
			}

			self::query($con, "
				UPDATE channels_users
				SET lastSeen = ?
				WHERE id_channel = ? AND 
				      id_user = ?;
			", [$_SERVER['REQUEST_TIME'], $channelId, $userId]);

			self::close($res);
			self::closeConnection($con);
	
			return $posts;
		}

		public static function createNewPost(int $channelId, int $userId, string $title, string $text){
			$con = self::getConnection();
			self::query($con, "
				INSERT INTO posts (id_user, id_channel, title, text, timestamp)
				VALUES (?, ?, ?, ?, ?)",
				[$userId, $channelId, $title, $text, $_SERVER['REQUEST_TIME']]	
			);
			self::closeConnection($con);
		}

		public static function getEditablePostId(int $channelId, int $userId): int {
			$con = self::getConnection();
			$res = self::query($con, "
				SELECT MAX(id) as id
				FROM posts 
				WHERE id_user = ? AND id_channel = ? AND deleted = 0",
				[$userId, $channelId]);
			
				if($res != null){
					$pos = self::fetchObject($res);
					
					$res = self::query($con, "
					SELECT MAX(id) as id
					FROM posts 
					WHERE id_channel = ? AND deleted=0",
					[$channelId]);
					
					$pos2 = self::fetchObject($res)->id;
					if($pos->id == $pos2 && $pos2 != null){
						self::closeConnection($con);
						return $pos2;
					}
				}
				self::closeConnection($con);
				return 0;
		}

		public static function deletePost(int $postId) {
			$con = self::getConnection();
			self::query($con, "
				UPDATE posts 
				SET deleted = 1
				WHERE id = ?",
				[$postId]);

				self::closeConnection($con);
				return 0;
		}

		public static function editPost(int $postId, string $text){
			$con = self::getConnection();
			self::query($con, "
				UPDATE posts 
				SET text = ?
				WHERE id = ?",
				[$text, $postId]);

				self::closeConnection($con);
				return 0;
		}

		public static function toggleImportant(int $postId, int $userId){
			$post = self::getPostByPostId($postId, $userId);
	
			$con = self::getConnection();

			//case 1 -> no value yet -> insert line
			$test = $post->getImportant();
			if($post->getImportant() === null){
				self::query($con,"
					INSERT INTO posts_users_property (id_post, id_user, important) 
					VALUES(?,?,?);
				", [$postId, $userId, 1]);
			} 
			//case 2 -> line exists, set value 1
			else if ($post->getImportant() === 0){
				self::query($con,"
					UPDATE posts_users_property 
					SET Important = 1 
					WHERE id_post = ? 
					  AND id_user = ?;
				", [$postId, $userId]);
			}
			//case 3 -> line exists, set value 0
			else if ($post->getImportant() === 1){
				self::query($con,"
					UPDATE posts_users_property 
					SET Important = 0 
					WHERE id_post = ? 
					  AND id_user = ?;
				", [$postId, $userId]);
			}
			self::closeConnection($con);
			return 0;
		}

		public static function getLastChecked(int $channelId, int $userId): int{
			$con = self::getConnection();
			$res = self::query($con,"
				SELECT lastSeen 
				FROM channels_users
				WHERE id_channel = ? AND
				      id_user = ?;
			", [$channelId, $userId]);

			$pos = self::fetchObject($res);
			if($pos != null){
				self::closeConnection($con);
				if($pos->lastSeen == null){
					return 0; 
				} else {
					return $pos->lastSeen;
				}
			}
			self::closeConnection($con);
			return 2147483647; //int max on 32 bit - big enough for this purpose
		}
}
