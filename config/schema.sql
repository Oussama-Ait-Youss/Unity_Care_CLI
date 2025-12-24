
-- creer la Base De Donne
CREATE DATABASE IF NOT EXISTS UnityClinic_CLI;

-- Utiliser la Base De Donne
USE UnityClinic_CLI; 

-- 1. Table Departments
CREATE TABLE departments (
     id INT AUTO_INCREMENT PRIMARY KEY,
     name VARCHAR(100) NOT NULL UNIQUE,
     description TEXT,
     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- 2. Table Doctors
CREATE TABLE  doctors (
     id INT AUTO_INCREMENT PRIMARY KEY,
     first_name VARCHAR(100) NOT NULL,
     last_name VARCHAR(100) NOT NULL,
     email VARCHAR(150) NOT NULL UNIQUE,
     phone VARCHAR(20),
     matricule VARCHAR(50) NOT NULL UNIQUE,
     speciality VARCHAR(100) NOT NULL,
     department_id INT,
     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL
);

-- 3. Table Patients
CREATE TABLE patients (
     id INT AUTO_INCREMENT PRIMARY KEY,
     first_name VARCHAR(100) NOT NULL,
     last_name VARCHAR(100) NOT NULL,
     email VARCHAR(150) NOT NULL UNIQUE,
     phone VARCHAR(20),
     birth_date DATE NOT NULL,
     address TEXT,
     department_id INT,
     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL
);
