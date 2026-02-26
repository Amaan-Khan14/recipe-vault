-- Recipe Vault Database Schema
-- Run this in phpMyAdmin or MySQL CLI to create the database and table

-- Create database
CREATE DATABASE IF NOT EXISTS recipe_vault 
    CHARACTER SET utf8mb4 
    COLLATE utf8mb4_unicode_ci;

USE recipe_vault;

-- Create recipes table
CREATE TABLE IF NOT EXISTS recipes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    ingredients JSON NOT NULL,
    instructions JSON NOT NULL,
    prepTimeMinutes INT DEFAULT 15,
    cookTimeMinutes INT DEFAULT 15,
    servings INT DEFAULT 2,
    difficulty VARCHAR(20) DEFAULT 'Medium',
    cuisine VARCHAR(50) DEFAULT 'Other',
    caloriesPerServing INT DEFAULT 300,
    rating DECIMAL(2,1) DEFAULT 0.0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
