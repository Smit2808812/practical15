CREATE DATABASE IF NOT EXISTS practical15 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE practical15;
CREATE TABLE IF NOT EXISTS users (
id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(120) NOT NULL, email VARCHAR(190) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL, role ENUM('admin','student') NOT NULL DEFAULT 'student',
status ENUM('active','inactive') NOT NULL DEFAULT 'active', last_login DATETIME NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS students (
id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NULL UNIQUE, student_id VARCHAR(50) NULL UNIQUE,
name VARCHAR(120) NOT NULL, email VARCHAR(190) NOT NULL UNIQUE, course VARCHAR(120) DEFAULT 'Computer Science',
semester TINYINT DEFAULT 3, status ENUM('active','inactive') NOT NULL DEFAULT 'active',
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
CREATE TABLE IF NOT EXISTS events (
id INT AUTO_INCREMENT PRIMARY KEY, title VARCHAR(180) NOT NULL, event_date DATE NOT NULL,
venue VARCHAR(180) NOT NULL, category VARCHAR(60) DEFAULT 'Workshop', description TEXT NULL,
status ENUM('open','closed') NOT NULL DEFAULT 'open', created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS registrations (
id INT AUTO_INCREMENT PRIMARY KEY, event_id INT NOT NULL, student_id INT NULL,
student_name VARCHAR(120) NOT NULL, student_email VARCHAR(190) NOT NULL,
status VARCHAR(40) DEFAULT 'registered', registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
UNIQUE KEY unique_registration(event_id,student_email),
FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS attendance (
id INT AUTO_INCREMENT PRIMARY KEY, student_email VARCHAR(190) NOT NULL,
subject VARCHAR(120) NOT NULL, attended_classes INT NOT NULL DEFAULT 0,
total_classes INT NOT NULL DEFAULT 0, CHECK(attended_classes <= total_classes)
);
CREATE TABLE IF NOT EXISTS contact_messages (
id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(120) NOT NULL, email VARCHAR(190) NOT NULL,
subject VARCHAR(180) NOT NULL, message TEXT NOT NULL, status ENUM('new','read','resolved') DEFAULT 'new',
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Create an admin account by registering normally, then run:
-- UPDATE users SET role='admin' WHERE email='your-admin-email@example.com';
