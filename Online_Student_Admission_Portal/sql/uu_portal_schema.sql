-- Database: uu_portal
CREATE DATABASE IF NOT EXISTS uu_portal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE uu_portal;

-- Students table (applicants / registered students)
CREATE TABLE students (
   id INT AUTO_INCREMENT PRIMARY KEY,
   name VARCHAR(255),
   email VARCHAR(255),
   phone VARCHAR(50),
   dob DATE,
   ssc_gpa VARCHAR(10),
   hsc_gpa VARCHAR(10),
   department VARCHAR(100),
   address TEXT,
   photo VARCHAR(255)
);

-- Teachers/Admins table
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(150) NULL,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('teacher','admin','superadmin') DEFAULT 'teacher',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Notices table
CREATE TABLE notices (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  body TEXT NOT NULL,
  department VARCHAR(80) DEFAULT 'Global',
  created_by INT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  status ENUM('active','inactive') DEFAULT 'active',
  FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Approvals log (who approved what)
CREATE TABLE approvals (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT NOT NULL,
  approved_by INT NOT NULL,
  action ENUM('approved','rejected') NOT NULL,
  comment TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
  FOREIGN KEY (approved_by) REFERENCES users(id) ON DELETE CASCADE
);

-- create a sample admin (password = 'Admin@123' -> hashed in PHP later)
INSERT INTO users (username, name, email, password_hash, role) VALUES
('admin', 'Site Admin', 'admin@uu.edu.bd', '$2y$10$replace_this_hash', 'superadmin');
