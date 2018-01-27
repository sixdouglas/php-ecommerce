-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le :  mar. 09 jan. 2018 à 19:47
-- Version du serveur :  10.2.8-MariaDB
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `php_ecommerce_db`
  CHARACTER SET = 'utf8'
  COLLATE = 'utf8_general_ci';

USE `php_ecommerce_db`;

--
-- Database :  `php_ecommerce_db`
--

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `country` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `alpha2` varchar(2) NOT NULL,
  `alpha3` varchar(3) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alpha2` (`alpha2`),
  UNIQUE KEY `alpha3` (`alpha3`)
) ENGINE=InnoDB;

--
-- `user` table structure
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `avatar` varchar(50) NOT NULL,
  CONSTRAINT `user_pk` PRIMARY KEY (`id`),
  CONSTRAINT `user_idx_1` UNIQUE INDEX (`login`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `user_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `address_line_1` varchar(40) NOT NULL,
  `address_line_2` varchar(40) NOT NULL,
  `address_line_3` varchar(40) NOT NULL,
  `address_line_4` varchar(40) NOT NULL,
  `address_line_5` varchar(40) NOT NULL,
  `postal_code` varchar(40) NOT NULL,
  `city_name` varchar(40) NOT NULL,
  `country_code` varchar(3) NOT NULL,
  CONSTRAINT `user__address_pk` PRIMARY KEY (`id`),
  INDEX `user_address_idx_1` (`user_id`),
  INDEX `user_address_idx_2` (`country_code`),
  CONSTRAINT `user_address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `user_address_ibfk_2` FOREIGN KEY (`country_code`) REFERENCES `country` (`alpha3`)
) ENGINE=InnoDB;

ALTER TABLE `user`
  ADD COLUMN IF NOT EXISTS `shipping_address` int(11) NULL,
  ADD COLUMN IF NOT EXISTS `billing_address` int(11) NULL,
  ADD CONSTRAINT IF NOT EXISTS `user_ibfk_2` FOREIGN KEY (`shipping_address`) REFERENCES `user_address` (`id`)
  ADD CONSTRAINT IF NOT EXISTS `user_ibfk_3` FOREIGN KEY (`billing_address`) REFERENCES `user_address` (`id`);

CREATE INDEX IF NOT EXISTS `user_idx_2` ON `user`(`shipping_address`);
CREATE INDEX IF NOT EXISTS `user_idx_3` ON `user`(`billing_address`);

CREATE TABLE IF NOT EXISTS `product_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `description` varchar(4000) DEFAULT NULL,
  CONSTRAINT `product_types_pk` PRIMARY KEY (`id`),
  CONSTRAINT `product_types_idx_1` UNIQUE INDEX (`type`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(15) NOT NULL,
  `name` varchar(70) NOT NULL,
  `type` int(11) NOT NULL,
  `scale` varchar(10) NOT NULL,
  `vendor` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `stock_level` smallint(6) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  CONSTRAINT `product_pk` PRIMARY KEY (`id`),
  INDEX `product_idx_2` (`type`),
  CONSTRAINT `product_idx_1` UNIQUE INDEX (`code`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`type`) REFERENCES `product_types` (`id`)
) ENGINE=InnoDB;

ALTER TABLE `products` ADD FULLTEXT(`description`);

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `shipped_date` timestamp DEFAULT NULL,
  `status` varchar(15) NOT NULL,
  `customer_id` int(11) NOT NULL,
  CONSTRAINT `order_pk` PRIMARY KEY (`id`),
  INDEX `order_idx_1` (`customer_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `order_lines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` smallint(6) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  CONSTRAINT `order_lines_pk` PRIMARY KEY (`id`),
  INDEX `order_lines_idx_1` (`order_id`),
  CONSTRAINT `order_lines_idx_2` UNIQUE INDEX (`product_id`),
  CONSTRAINT `order_lines_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `order_lines_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `order_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `type` ENUM ('SHIPPING', 'BILLING'),
  `address_line_1` varchar(40) NOT NULL,
  `address_line_2` varchar(40) NOT NULL,
  `address_line_3` varchar(40) NOT NULL,
  `address_line_4` varchar(40) NOT NULL,
  `address_line_5` varchar(40) NOT NULL,
  `postal_code` varchar(40) NOT NULL,
  `city_name` varchar(40) NOT NULL,
  `country_code` varchar(3) NOT NULL,
  CONSTRAINT `order_address_pk` PRIMARY KEY (`id`),
  INDEX `order_address_idx_1` (`user_id`),
  INDEX `order_address_idx_2` (`country_code`),
  CONSTRAINT `order_address_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `order_address_ibfk_2` FOREIGN KEY (`country_code`) REFERENCES `country` (`alpha3`)
) ENGINE=InnoDB;
