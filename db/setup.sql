CREATE DATABASE IF NOT EXISTS meditrust_db;
USE meditrust_db;

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50),
    password VARCHAR(255),
    role ENUM('admin', 'dokter')
);

CREATE TABLE patients (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    nik VARCHAR(255),
    diagnosis TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed data untuk testing mahasiswa
INSERT INTO users (username, password, role) VALUES ('dr_ade', '$2y$12$WUz1nQcaRfZms.yqYQGB0OayAlqpswva9TFgJMUtnvlMgltO4SC1y', 'dokter');
INSERT INTO patients (name, nik, diagnosis) VALUES ('Budi Santoso', 'enc:v1:itoazdNZyCLKRDhYFmtVlQGdwRBxcShYRkGpmhlkc3POvToOZNPwzUnXdks=', 'Flu Burung');
