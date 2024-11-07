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
    <link rel="stylesheet" href="../css/menu_bar.css">
    <link rel="stylesheet" href="../css/emotion_calendar.css">

    <!-- FullCalendar의 CSS 파일 불러오기, cdn.jsdelivr.net 경로 -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">
</head>

<body>
<!-- 네비게이션바 : 머리말 부분-->
<div class="menu-top">
    <div class="menu-bar2 menu-bar-item2">
        <a href="../php/feelflow_home.php" class="menu-bar1 menu-button menu-bar-item1"><b>FeelFlow</b></a>
        <!-- 네비게이션바 -->
        <div class="menu-bar2">
            <a href="diary_write.html" class="menu-button menu-bar-item2">새로운 일기</a>
            <a href="emotion_calendar.html" class="menu-button menu-bar-item2">감정 캘린더</a>
            <a href="#emotion_dash_board" class="menu-button menu-bar-item2">감정분석 대시보드</a>
            <a href="#content" class="menu-button menu-bar-item2">콘텐츠 추천</a>
            <a href="#matching" class="menu-button menu-bar-item2">사용자 매칭</a>
            <!--마이메이지, 사용자 이미지로 변경하기-->
            <a href="../php/feel_mypage.php" class="menu-button menu-bar2 menu-bar-item2">마이페이지</a>
        </div>
    </div>
</div>

<div class="calendar-box">
    <div id="calendar"></div>
</div>

<!-- FullCalendar 자바스크립트 라이브러리, 달력을 구현 -->
<!-- CDN으로 FullCalendar를 불러오고 있기 때문에 별도의 설치가 필요하지 않다, cdn.jsdelivr.net 경로 -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales/ko.js"></script>

<!-- Custom JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'ko',
            eventDisplay: 'list-item',
            dayMaxEventRows: true,

            // AJAX를 사용하여 이벤트 불러오기
            events: function(fetchInfo, successCallback, failureCallback) {
                fetch('../php/get_diary_events.php')
                    .then(response => response.json())
                    .then(data => {
                        console.log("Fetched Events:", data);  // 콘솔에 이벤트 데이터 출력
                        successCallback(data);
                    })
                    .catch(error => {
                        console.error("Error fetching events:", error);
                        failureCallback(error);
                    });
            },

            eventClick: function(info) {
                alert('제목: ' + info.event.title + '\n내용: ' + info.event.extendedProps.description);
            }
        });

        calendar.render();
    });
</script>
</body>
</html>
