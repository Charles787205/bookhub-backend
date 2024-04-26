
DROP DATABASE `bookhub_db`;
CREATE DATABASE `bookhub_db`;

USE `bookhub_db`;

CREATE TABLE `users` (
  `id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `first_name` VARCHAR(255) NOT NULL,
  `last_name` VARCHAR(255) NOT NULL,
  `middle_name` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP

);


CREATE TABLE `admin` (
  `id` INT(11) NOT NULL PRIMARY KEY
);

CREATE TABLE `books` (
  `id` VARCHAR(255) PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `image` VARCHAR(255) NOT NULL
);

CREATE TABLE `borrow_request` (
  `id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT ,
  `book_id` VARCHAR(255) NOT NULL,
  `user_id` INT(11) NOT NULL,
  `duration_no` INT(11) NOT NULL,
  `duration_unit` ENUM('DAY', 'WEEK', 'MONTH') NOT NULL DEFAULT 'DAY',
  `requested_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
  Foreign Key (`book_id`) REFERENCES `books`(`id`),
  Foreign Key (`user_id`) REFERENCES `users`(`id`)
  
);
CREATE TABLE `borrowed_books` (
  `id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `request_id` INT(11) NOT NULL,
  `borrowed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `due_date` DATE NOT NULL,
  `returned_at` TIMESTAMP NULL DEFAULT NULL,
  Foreign Key (`request_id`) REFERENCES `borrow_request`(`id`)
);


