create database todolist; 

use todolist;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

use todolist;
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    task VARCHAR(255) NOT NULL,
    description TEXT,
    deadline DATE,
    status TINYINT(1) DEFAULT 0,
    CONSTRAINT fk_user_list
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
);

