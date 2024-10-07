CREATE TABLE diaries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    title VARCHAR(255),
    content TEXT,
    date_written DATE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);


ALTER TABLE diaries ADD COLUMN emotion_state VARCHAR(255);
// 위의 컬럼을 추가하여 emotion_state 스크립트를 생성 실행 가능하게함
