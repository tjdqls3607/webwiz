<?php
session_start();

// 데이터베이스 연결
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feelcontent";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 사용자의 모든 일기 항목을 가져옴
$user_id = $_SESSION['user_id'] ?? 0;
$sql = "SELECT id, title, content, emotion_state, DATE(created_at) as diary_date FROM diaries WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$diaryEntries = [];
while ($row = $result->fetch_assoc()) {
    $diaryEntries[$row['diary_date']] = [
        'id' => $row['id'],
        'title' => $row['title'],
        'content' => $row['content'],
        'emotion_state' => $row['emotion_state']
    ];
}

$stmt->close();
$conn->close();

// 감정 상태에 따른 색상 정의
$emotionColors = [
    '매우 긍정적' => '#4CAF50',
    '긍정적' => '#8BC34A',
    '약간 긍정적' => '#CDDC39',
    '중립적' => '#FFC107',
    '약간 부정적' => '#FF9800',
    '부정적' => '#FF5722',
    '매우 부정적' => '#F44336',
    '복합적' => '#9C27B0'
];
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>감정 캘린더</title>
    <link rel="stylesheet" href="../css/menu_bar.css">
    <style>
        .calendar-box {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        #calendar {
            width: 100%;
            border-collapse: collapse;
        }

        #calendar th {
            background: #f5f5f5;
            padding: 10px;
            text-align: center;
        }

        #calendar td {
            border: 1px solid #ddd;
            padding: 10px;
            height: 100px;
            vertical-align: top;
        }

        .diary-entry {
            margin-top: 5px;
            padding: 5px;
            border-radius: 5px;
            font-size: 0.9em;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .diary-entry:hover {
            background-color: rgba(0,0,0,0.05);
        }

        .emotion-dot {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
        }

        /* 모달 스타일 */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            position: relative;
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            width: 70%;
            max-width: 700px;
            border-radius: 10px;
        }

        .close {
            position: absolute;
            right: 20px;
            top: 10px;
            font-size: 28px;
            cursor: pointer;
        }

        .date-number {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>
    <script>
        function showDiaryEntry(id) {
            // AJAX로 일기 내용 가져오기
            fetch(`get_diary.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('diaryTitle').textContent = data.title;
                    document.getElementById('diaryContent').textContent = data.content;
                    document.getElementById('diaryEmotion').textContent = data.emotion_state;
                    document.getElementById('diaryModal').style.display = 'block';
                });
        }

        function closeModal() {
            document.getElementById('diaryModal').style.display = 'none';
        }

        // 캘린더 생성 함수
        function generateCalendar(year, month) {
            const firstDay = new Date(year, month - 1, 1);
            const lastDay = new Date(year, month, 0);
            const daysInMonth = lastDay.getDate();
            const startingDay = firstDay.getDay();

            let calendarHtml = `
                <table id="calendar">
                    <tr>
                        <th>일</th><th>월</th><th>화</th><th>수</th><th>목</th><th>금</th><th>토</th>
                    </tr>
                    <tr>`;

            // 첫 주의 빈 칸
            for (let i = 0; i < startingDay; i++) {
                calendarHtml += '<td></td>';
            }

            // 달력 채우기
            let currentDay = 1;
            while (currentDay <= daysInMonth) {
                if ((startingDay + currentDay - 1) % 7 === 0) {
                    calendarHtml += '</tr><tr>';
                }

                const currentDate = `${year}-${String(month).padStart(2, '0')}-${String(currentDay).padStart(2, '0')}`;
                calendarHtml += `<td>
                    <div class="date-number">${currentDay}</div>`;

                if (typeof diaryEntries !== 'undefined' && diaryEntries[currentDate]) {
                    const entry = diaryEntries[currentDate];
                    const emotionColor = emotionColors[entry.emotion_state] || '#9E9E9E';
                    calendarHtml += `
                        <div class="diary-entry" onclick="showDiaryEntry(${entry.id})">
                            <span class="emotion-dot" style="background-color: ${emotionColor}"></span>
                            ${entry.title}
                        </div>`;
                }

                calendarHtml += '</td>';
                currentDay++;
            }

            calendarHtml += '</tr></table>';
            document.getElementById('calendar').innerHTML = calendarHtml;
        }

        // 페이지 로드 시 현재 월의 캘린더 생성
        window.onload = function() {
            const today = new Date();
            generateCalendar(today.getFullYear(), today.getMonth() + 1);
        }
    </script>
</head>
<body>
<div class="menu-top">
    <div class="menu-bar2 menu-bar-item2">
        <a href="feelflow_home.php" class="menu-bar1 menu-button menu-bar-item1"><b>FeelFlow</b></a>
        <div class="menu-bar2">
            <a href="../html/diary_write.html" class="menu-button menu-bar-item2">새로운 일기</a>
            <a href="emotion_calender.php" class="menu-button menu-bar-item2">감정 캘린더</a>
            <a href="#emotion_dash_board" class="menu-button menu-bar-item2">감정분석 대시보드</a>
            <a href="content_recommend.html" class="menu-button menu-bar-item2">콘텐츠 추천</a>
            <a href="chatroom.css" class="menu-button menu-bar-item2">사용자 매칭</a>
            <a href="feel_mypage.php" class="menu-button menu-bar2 menu-bar-item2">마이페이지</a>
        </div>
    </div>
</div>

<div class="calendar-box">
    <div id="calendar">
        <!-- 캘린더가 여기에 생성됩니다 -->
    </div>
</div>

<!-- 일기 내용을 보여주는 모달 -->
<div id="diaryModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2 id="diaryTitle"></h2>
        <p><strong>감정 상태:</strong> <span id="diaryEmotion"></span></p>
        <p id="diaryContent"></p>
    </div>
</div>
</body>
</html>