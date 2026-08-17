DROP DATABASE IF EXISTS student_analytics;
CREATE DATABASE student_analytics;
USE student_analytics;

CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
fullname VARCHAR(100) NOT NULL,
username VARCHAR(50) UNIQUE NOT NULL,
password VARCHAR(255) NOT NULL,
role ENUM('Admin','Teacher') DEFAULT 'Admin',
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users(fullname,username,password,role)
VALUES
('Administrator','admin','admin123','Admin');

CREATE TABLE students(
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100) NOT NULL,
roll_no VARCHAR(20) UNIQUE NOT NULL,
class VARCHAR(30) NOT NULL,
gender VARCHAR(10),
phone VARCHAR(15),
email VARCHAR(100),
address TEXT,
photo VARCHAR(255),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE teachers(
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100),
subject VARCHAR(100),
phone VARCHAR(20),
email VARCHAR(100)
);

CREATE TABLE attendance(
id INT AUTO_INCREMENT PRIMARY KEY,
student_id INT,
attendance_date DATE,
status ENUM('Present','Absent') DEFAULT 'Present',
FOREIGN KEY(student_id) REFERENCES students(id) ON DELETE CASCADE
);

CREATE TABLE subjects(
id INT AUTO_INCREMENT PRIMARY KEY,
subject_name VARCHAR(100)
);

CREATE TABLE marks(
id INT AUTO_INCREMENT PRIMARY KEY,
student_id INT,
subject_id INT,
marks DECIMAL(5,2),
FOREIGN KEY(student_id) REFERENCES students(id) ON DELETE CASCADE,
FOREIGN KEY(subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);