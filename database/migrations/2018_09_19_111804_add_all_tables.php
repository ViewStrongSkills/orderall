<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(
          "
          CREATE DATABASE  IF NOT EXISTS `ebdb` /*!40100 DEFAULT CHARACTER SET latin1 */;
          USE `ebdb`;
          -- MySQL dump 10.16  Distrib 10.1.35-MariaDB, for Win32 (AMD64)
          --
          -- Host: localhost    Database: ebdb
          -- ------------------------------------------------------
          -- Server version	10.1.35-MariaDB

          /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
          /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
          /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
          /*!40101 SET NAMES utf8 */;
          /*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
          /*!40103 SET TIME_ZONE='+00:00' */;
          /*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
          /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
          /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
          /*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

          --
          -- Table structure for table `business_tag`
          --

          DROP TABLE IF EXISTS `business_tag`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `business_tag` (
            `business_id` int(10) unsigned NOT NULL,
            `tag_id` int(10) unsigned NOT NULL,
            PRIMARY KEY (`business_id`,`tag_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
          /*!40101 SET character_set_client = @saved_cs_client */;

          --
          -- Table structure for table `businesses`
          --

          DROP TABLE IF EXISTS `businesses`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `businesses` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(100) NOT NULL,
            `phone_country_code` varchar(5) NOT NULL DEFAULT '+61',
            `phone` varchar(50) NOT NULL,
            `email` varchar(100) DEFAULT NULL,
            `website` varchar(100) DEFAULT NULL,
            `addressLine1` varchar(100) DEFAULT NULL,
            `addressLine2` varchar(100) NOT NULL,
            `locality` varchar(50) NOT NULL,
            `postcode` char(4) NOT NULL,
            `latitude` decimal(10,6) NOT NULL DEFAULT '0.000000',
            `longitude` decimal(10,6) NOT NULL DEFAULT '0.000000',
            `supports_payment` tinyint(1) NOT NULL DEFAULT '0',
            `image_path` varchar(260) DEFAULT NULL COMMENT 'Max length 260 due to Windows path limits',
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          /*!40101 SET character_set_client = @saved_cs_client */;

          --
          -- Table structure for table `cart_extras`
          --

          DROP TABLE IF EXISTS `cart_extras`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `cart_extras` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `menu_extra_id` int(11) NOT NULL,
            `cart_item_id` int(11) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT 0,
            PRIMARY KEY (`id`),
            UNIQUE KEY `cart_extras_menu_extra_id_cart_item_id_unique` (`menu_extra_id`,`cart_item_id`),
            KEY `cart_item_id` (`cart_item_id`),
            CONSTRAINT `cart_extras_ibfk_1` FOREIGN KEY (`menu_extra_id`) REFERENCES `menu_extras` (`id`),
            CONSTRAINT `cart_extras_ibfk_2` FOREIGN KEY (`cart_item_id`) REFERENCES `cart_items` (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          /*!40101 SET character_set_client = @saved_cs_client */;

          --
          -- Table structure for table `cart_items`
          --

          DROP TABLE IF EXISTS `cart_items`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `cart_items` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `menu_item_id` int(11) NOT NULL,
            `cart_id` int(11) NOT NULL,
            `comments` varchar(127) DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT 0,
            PRIMARY KEY (`id`),
            KEY `menu_item_id` (`menu_item_id`),
            KEY `cart_id` (`cart_id`),
            CONSTRAINT `cart_id` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`),
            CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          /*!40101 SET character_set_client = @saved_cs_client */;

          --
          -- Table structure for table `carts`
          --

          DROP TABLE IF EXISTS `carts`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `carts` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `business_id` int(11) NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `carts_user_id_business_id_unique` (`user_id`,`business_id`),
            KEY `business_id` (`business_id`),
            CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
            CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          /*!40101 SET character_set_client = @saved_cs_client */;

          --
          -- Table structure for table `jobs`
          --

          DROP TABLE IF EXISTS `jobs`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `jobs` (
            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
            `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
            `attempts` tinyint(3) unsigned NOT NULL,
            `reserved_at` int(10) unsigned DEFAULT NULL,
            `available_at` int(10) unsigned NOT NULL,
            `created_at` int(10) unsigned NOT NULL,
            PRIMARY KEY (`id`),
            KEY `jobs_queue_index` (`queue`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
          /*!40101 SET character_set_client = @saved_cs_client */;

          --
          -- Table structure for table `menu_extra_categories`
          --

          DROP TABLE IF EXISTS `menu_extra_categories`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `menu_extra_categories` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `menu_item_id` int(11) NOT NULL,
            `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
            `required` tinyint(1) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `menu_extra_categories_menu_item_id_index` (`menu_item_id`),
            CONSTRAINT `menu_extra_categories_menu_item_id_foreign` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
          /*!40101 SET character_set_client = @saved_cs_client */;

          --
          -- Table structure for table `menu_extras`
          --

          DROP TABLE IF EXISTS `menu_extras`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `menu_extras` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(50) NOT NULL,
            `price` decimal(5,2) NOT NULL,
            `menu_item_id` int(11) NOT NULL,
            `menu_extra_category_id` int(10) unsigned NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT 0,
            PRIMARY KEY (`id`),
            KEY `menu_item_id` (`menu_item_id`),
            KEY `menu_extras_menu_extra_category_id_index` (`menu_extra_category_id`),
            CONSTRAINT `menu_extras_ibfk_1` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          /*!40101 SET character_set_client = @saved_cs_client */;

          --
          -- Table structure for table `menu_items`
          --

          DROP TABLE IF EXISTS `menu_items`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `menu_items` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `price` decimal(5,2) unsigned NOT NULL,
            `discount` decimal(5,2) unsigned DEFAULT NULL,
            `name` varchar(50) NOT NULL,
            `image_path` varchar(260) DEFAULT NULL COMMENT 'Length 260 due to Windows max path length',
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT 0,
            `description` varchar(100) DEFAULT NULL,
            `category` varchar(25) NOT NULL DEFAULT 'Other',
            `menu_id` int(11) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `menu_id` (`menu_id`),
            CONSTRAINT `menu_items_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          /*!40101 SET character_set_client = @saved_cs_client */;

          --
          -- Table structure for table `menus`
          --

          DROP TABLE IF EXISTS `menus`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `menus` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `business_id` int(11) NOT NULL,
            `main` tinyint(1) NOT NULL DEFAULT '0',
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
            PRIMARY KEY (`id`),
            KEY `business_id` (`business_id`),
            KEY `menus_main_business_id_index` (`main`,`business_id`),
            CONSTRAINT `business_id` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
          /*!40101 SET character_set_client = @saved_cs_client */;

          --
          -- Table structure for table `migrations`
          --

          DROP TABLE IF EXISTS `migrations`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `migrations` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
            `batch` int(11) NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
          /*!40101 SET character_set_client = @saved_cs_client */;

          --
          -- Table structure for table `modules`
          --

          DROP TABLE IF EXISTS `modules`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `modules` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `route` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
            `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
          /*!40101 SET character_set_client = @saved_cs_client */;

          --
          -- Table structure for table `notifications`
          --

          DROP TABLE IF EXISTS `notifications`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `notifications` (
            `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `notifiable_id` int(11) NOT NULL,
            `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
            `read_at` datetime DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
          /*!40101 SET character_set_client = @saved_cs_client */;

          --
          -- Table structure for table `operating_hours`
          --

          DROP TABLE IF EXISTS `operating_hours`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `operating_hours` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `entry_id` int(10) unsigned NOT NULL,
            `entry_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
            `opening_time` time NOT NULL,
            `closing_time` time NOT NULL,
            `day` tinyint(3) unsigned NOT NULL COMMENT 'The day of the week, from 0 = Monday to 6 = Sunday',
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `operating_hours_business_id_day_index` (`day`),
            KEY `operating_hours_entry_id_entry_type_index` (`entry_id`,`entry_type`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
          /*!40101 SET character_set_client = @saved_cs_client */;

          --
          -- Table structure for table `password_resets`
          --

          DROP TABLE IF EXISTS `password_resets`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `password_resets` (
            `id` int(11) NOT NULL,
            `email` varchar(255) NOT NULL,
            `token` varchar(255) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          /*!40101 SET character_set_client = @saved_cs_client */;

          --
          -- Table structure for table `permission_role`
          --

          DROP TABLE IF EXISTS `permission_role`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `permission_role` (
            `permission_id` int(10) unsigned NOT NULL,
            `role_id` int(10) unsigned NOT NULL,
            PRIMARY KEY (`permission_id`,`role_id`),
            KEY `permission_role_role_id_foreign` (`role_id`),
            CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
            CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
          /*!40101 SET character_set_client = @saved_cs_client */;

          --
          -- Table structure for table `permission_user`
          --

          DROP TABLE IF EXISTS `permission_user`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `permission_user` (
            `permission_id` int(10) unsigned NOT NULL,
            `user_id` int(10) unsigned NOT NULL,
            `user_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
            PRIMARY KEY (`user_id`,`permission_id`,`user_type`),
            KEY `permission_user_permission_id_foreign` (`permission_id`),
            CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
          /*!40101 SET character_set_client = @saved_cs_client */;

          --
          -- Table structure for table `permissions`
          --

          DROP TABLE IF EXISTS `permissions`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `permissions` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
            `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `permissions_name_unique` (`name`)
          ) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
          /*!40101 SET character_set_client = @saved_cs_client */;

          --
          -- Table structure for table `phone_verifications`
          --

          DROP TABLE IF EXISTS `phone_verifications`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `phone_verifications` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `code` char(4) COLLATE utf8mb4_unicode_ci NOT NULL,
            `phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
            `user_id` int(11) NOT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `phone_verifications_user_id_foreign` (`user_id`),
            CONSTRAINT `phone_verifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
          /*!40101 SET character_set_client = @saved_cs_client */;

          --
          -- Table structure for table `push_subscriptions`
          --

          DROP TABLE IF EXISTS `push_subscriptions`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `push_subscriptions` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `endpoint` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
            `public_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `auth_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `push_subscriptions_endpoint_unique` (`endpoint`),
            KEY `push_subscriptions_user_id_index` (`user_id`),
            CONSTRAINT `push_subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
          /*!40101 SET character_set_client = @saved_cs_client */;

          --
          -- Table structure for table `reviews`
          --

          DROP TABLE IF EXISTS `reviews`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `reviews` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `rating` tinyint(3) unsigned NOT NULL,
            `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `user_id` int(11) NOT NULL,
            `menu_item_id` int(11) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT 0,
            PRIMARY KEY (`id`),
            KEY `reviews_user_id_foreign` (`user_id`),
            KEY `reviews_menu_item_id_foreign` (`menu_item_id`),
            CONSTRAINT `reviews_menu_item_id_foreign` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE,
            CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
          /*!40101 SET character_set_client = @saved_cs_client */;

          --
          -- Table structure for table `role_user`
          --

          DROP TABLE IF EXISTS `role_user`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `role_user` (
            `role_id` int(10) unsigned NOT NULL,
            `user_id` int(10) unsigned NOT NULL,
            `user_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
            PRIMARY KEY (`user_id`,`role_id`,`user_type`),
            KEY `role_user_role_id_foreign` (`role_id`),
            CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
          /*!40101 SET character_set_client = @saved_cs_client */;

          --
          -- Table structure for table `roles`
          --

          DROP TABLE IF EXISTS `roles`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `roles` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
            `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `roles_name_unique` (`name`)
          ) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
          /*!40101 SET character_set_client = @saved_cs_client */;

          --
          -- Table structure for table `tags`
          --

          DROP TABLE IF EXISTS `tags`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `tags` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
          /*!40101 SET character_set_client = @saved_cs_client */;

          --
          -- Table structure for table `transaction_extras`
          --

          DROP TABLE IF EXISTS `transaction_extras`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `transaction_extras` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `menu_extra_id` int(11) DEFAULT NULL,
            `transaction_item_id` int(11) NOT NULL,
            `name` varchar(50) NOT NULL,
            `price` decimal(5,2) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `transaction_item_id` (`transaction_item_id`),
            KEY `menu_extra_id` (`menu_extra_id`),
            CONSTRAINT `menu_extra_id` FOREIGN KEY (`menu_extra_id`) REFERENCES `menu_extras` (`id`) ON DELETE SET NULL,
            CONSTRAINT `transaction_item_id` FOREIGN KEY (`transaction_item_id`) REFERENCES `transaction_items` (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          /*!40101 SET character_set_client = @saved_cs_client */;

          --
          -- Table structure for table `transaction_items`
          --

          DROP TABLE IF EXISTS `transaction_items`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `transaction_items` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `transaction_id` int(11) NOT NULL,
            `menu_item_id` int(11) DEFAULT NULL,
            `comments` varchar(512) DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT 0,
            `name` varchar(50) NOT NULL,
            `price` decimal(5,2) NOT NULL,
            `discount` decimal(5,2) DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `transaction_id` (`transaction_id`),
            KEY `menu_item_id` (`menu_item_id`),
            CONSTRAINT `menu_item_id` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`) ON DELETE SET NULL,
            CONSTRAINT `transaction_id` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          /*!40101 SET character_set_client = @saved_cs_client */;

          --
          -- Table structure for table `transactions`
          --

          DROP TABLE IF EXISTS `transactions`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `transactions` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `price` decimal(5,2) unsigned NOT NULL,
            `business_id` int(11) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT 0,
            `status` enum('pending','declined','accepted') NOT NULL DEFAULT 'pending',
            `declined_reason` varchar(191) DEFAULT NULL,
            `notification_seen` tinyint(1) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`),
            KEY `user_id` (`user_id`),
            KEY `transactions_business_id_index` (`business_id`),
            CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          /*!40101 SET character_set_client = @saved_cs_client */;

          --
          -- Table structure for table `users`
          --

          DROP TABLE IF EXISTS `users`;
          /*!40101 SET @saved_cs_client     = @@character_set_client */;
          /*!40101 SET character_set_client = utf8 */;
          CREATE TABLE `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `first_name` varchar(50) NOT NULL,
            `last_name` varchar(50) NOT NULL,
            `email` varchar(100) NOT NULL,
            `password` varchar(255) NOT NULL,
            `subscribed` tinyint(1) NOT NULL DEFAULT '1',
            `phone_country_code` varchar(5) NOT NULL DEFAULT '+61',
            `phone` varchar(50) DEFAULT NULL,
            `developer` tinyint(1) NOT NULL DEFAULT '0',
            `acc_balance` decimal(5,2) unsigned NOT NULL DEFAULT '0.00',
            `remember_token` varchar(100) DEFAULT NULL,
            `business_id` int(11) DEFAULT NULL,
            `email_token` varchar(64) DEFAULT NULL,
            `updated_at` timestamp NOT NULL DEFAULT 0,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `unsub_token` varchar(64) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `business_id` (`business_id`),
            KEY `users_developer_index` (`developer`),
            CONSTRAINT `users_ibfk_1` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
          /*!40101 SET character_set_client = @saved_cs_client */;
          /*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

          /*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
          /*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
          /*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
          /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
          /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
          /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
          /*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

          -- Dump completed on 2018-10-01 13:58:02
          "
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared(
          "
          SET FOREIGN_KEY_CHECKS = 0;
          SET GROUP_CONCAT_MAX_LEN=32768;
          SET @tables = NULL;
          SELECT GROUP_CONCAT('`', table_name, '`') INTO @tables
            FROM information_schema.tables
            WHERE table_schema = (SELECT DATABASE());
          SELECT IFNULL(@tables,'dummy') INTO @tables;

          SET @tables = CONCAT('DROP TABLE IF EXISTS ', @tables);
          PREPARE stmt FROM @tables;
          EXECUTE stmt;
          DEALLOCATE PREPARE stmt;
          SET FOREIGN_KEY_CHECKS = 1;
          "
        );
    }
}
