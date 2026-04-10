-- Run this on your Lightsail MySQL database (e.g., using mysql client or phpMyAdmin)
CREATE TABLE IF NOT EXISTS messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  text VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO messages (text) VALUES
('I am exploring the use of AWS Lightsail'),
('This is a sample message');