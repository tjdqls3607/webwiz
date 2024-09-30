CREATE TABLE diaries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    title VARCHAR(255),
    content TEXT,
    date_written DATE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
