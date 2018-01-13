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
