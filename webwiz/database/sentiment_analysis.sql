CREATE TABLE `sentiment_analysis` (
    `analysis_id` int(11) NOT NULL AUTO_INCREMENT,
    `diary_id` int(11) NOT NULL,
    `emotion_state` VARCHAR(255) NOT NULL,
    `result` ENUM('화창', '맑음', '흐림', '비', '번개') NOT NULL,
    `analyzed_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`analysis_id`),
    FOREIGN KEY (`diary_id`) REFERENCES `diaries`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 이미 존재하는 sentiment_analysis 테이블의 데이터를 업데이트
UPDATE `sentiment_analysis` AS sa
JOIN `diaries` AS d ON sa.`diary_id` = d.`diary_id`
SET sa.`result` = CASE
    WHEN d.`emotion_state` = '매우 긍정적' THEN '화창'
    WHEN d.`emotion_state` = '긍정적' THEN '맑음'
    WHEN d.`emotion_state` = '중립' THEN '흐림'
    WHEN d.`emotion_state` = '부정적' THEN '비'
    WHEN d.`emotion_state` = '매우 부정적' THEN '번개'
    ELSE sa.`result`
END
WHERE d.`emotion_state` IS NOT NULL;

-- diaries 테이블에서 데이터를 가져와 result 값을 계산, sentiment_analysis에 입력
INSERT INTO `sentiment_analysis` (`diary_id`, `emotion_state`, `result`, `analyzed_at`)
SELECT `id`, `emotion_state`,
    CASE
        WHEN `emotion_state` = '매우 긍정적' THEN '화창'
        WHEN `emotion_state` = '긍정적' THEN '맑음'
        WHEN `emotion_state` = '중립' THEN '흐림'
        WHEN `emotion_state` = '부정적' THEN '비'
        WHEN `emotion_state` = '매우 부정적' THEN '번개'
        ELSE '흐림' -- 기본 값 설정
    END AS `result`,
    NOW() AS `analyzed_at`
FROM `diaries`
WHERE `emotion_state` IS NOT NULL;
