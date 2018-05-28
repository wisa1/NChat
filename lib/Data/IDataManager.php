<?php


namespace Data;
use NChat\User;

interface IDataManager {
	public static function getCategories() : array;
	public static function getBooksByCategory(int $categoryId) : array;
	public static function getUserById(int $userId);
	public static function getUserByUserName(string $userName);
	public static function createOrder(int $userId, array $bookIds, string $nameOnCard, string $cardNumber) : int;
	public static function createUser(string $userName, string $email, string $password) : User;
}
