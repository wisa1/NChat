<?php


namespace Data;
use NChat\User;
use NChat\Post;

interface IDataManager {
	public static function getCategories() : array;
	public static function getUserById(int $userId);
	public static function getUserByUserName(string $userName);
	public static function getPostsByChannelId(int $channelId, int $userId);
	public static function getPostByPostId(int $postId, int $userId) : ?Post;
	public static function editPost(int $postId, string $text);
	public static function createUser(string $userName, string $email, string $password) : User;
	public static function createNewPost(int $channelId, int $userId, string $title, string $text);
	public static function getEditablePostId(int $channelId, int $userId): int;
	public static function toggleImportant(int $postId, int $userId);
	public static function deletePost(int $postId);
	public static function getLastChecked(int $channelId, int $userId): int;
}
