<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/menu_bar.css">
    <link rel="stylesheet" href="../css/emotion_calendar.css">

    <!-- FullCalendar의 CSS 파일 불러오기 -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">
</head>

<body>
<!-- 네비게이션바 -->
<div class="menu-top">
    <div class="menu-bar2 menu-bar-item2">
        <a href="../php/feelflow_home.php" class="menu-bar1 menu-button menu-bar-item1"><b>FeelFlow</b></a>
        <div class="menu-bar2">
            <a href="../html/diary_write.html" class="menu-button menu-bar-item2">새로운 일기</a>
            <a href="../php/emotion_calendar.php" class="menu-button menu-bar-item2">감정 캘린더</a>
            <a href="#emotion_dash_board" class="menu-button menu-bar-item2">감정분석 대시보드</a>
            <a href="#content" class="menu-button menu-bar-item2">콘텐츠 추천</a>
            <a href="#matching" class="menu-button menu-bar-item2">사용자 매칭</a>
            <a href="../php/feel_mypage.php" class="menu-button menu-bar2 menu-bar-item2">마이페이지</a>
        </div>
    </div>
</div>

<!-- PHP에서 이벤트 데이터를 가져와서 JSON 형식으로 JavaScript에 전달 -->
<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // 세션에서 사용자 ID 가져오기

    // 데이터베이스 연결
    $conn = new mysqli("localhost", "root", "", "feelcontent");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // 사용자에 따라 일기 데이터 가져오기
    $sql = "SELECT id, title, created_at FROM diaries WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // 데이터를 배열로 저장
    $events = [];
    while ($row = $result->fetch_assoc()) {
        $events[] = [
            'title' => htmlspecialchars($row['title']),
            'start' => $row['created_at'],
            'url' => "../php/view_diary.php?diaries_id=" . $row['id']
        ];
    }

    $stmt->close();
    $conn->close();

    // JSON 형식으로 출력
    echo "<script>var eventsData = " . json_encode($events) . ";</script>";
} else {
    echo "<script>console.error('로그인된 사용자 정보가 없습니다.');</script>";
}
?>

<!-- FullCalendar 자바스크립트 라이브러리 -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales/ko.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 캘린더가 들어갈 HTML 요소 확인
        var calendarEl = document.getElementById('calendar');

        // FullCalendar 인스턴스 생성
        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'ko',
            initialView: 'dayGridMonth',
            eventDisplay: 'list-item',
            dayMaxEventRows: true,
            events: eventsData, // PHP에서 가져온 JSON 데이터를 사용

            eventClick: function(info) {
                info.jsEvent.preventDefault();
                var url = info.event.url;
                if (url) {
                    window.open(url, 'diaryPopup', 'width=600,height=400'); // 새 창 열기
                }
            }
        });

        // 캘린더 렌더링
        calendar.render();
    });
</script>

<div class="content">
    <!-- 감정 캘린더 -->
    <div class="calendar-box">
        <div id="calendar"></div> <!-- 캘린더가 렌더링될 div -->
    </div>

    <!-- 감정 이모지 설명 -->
    <div class="right-section">
        <div class="chart-section">
            <h2>감정 캘린더 날씨 이모지</h2>
            <div class="chart" id="overall-trend">
                <div class="emotion-set">
                    <img src="../imgsrc/sunny.png" alt="이모지">
                    <h1>sunny: 감정 긍정 점수 60점 이상 </h1>
                </div>
                <div class="emotion-set">
                    <img src="../imgsrc/rainy.png" alt="이모지">
                    <h1>rainy: 감정 부정 점수 40점 이상 </h1>
                </div>
                <div class="emotion-set">
                    <img src="../imgsrc/normal.png" alt="이모지">
                    <h1>normal: 감정 중립 점수 50점 이상 </h1>
                </div>
                <div class="emotion-set">
                    <img src="../imgsrc/lightning.png" alt="이모지">
                    <h1>lightning: 감정 부정 점수 80점 이상 </h1>
                </div>
                <div class="emotion-set">
                    <img src="../imgsrc/cloudrainy.png" alt="이모지">
                    <h1>cloudrainy: 감정 부정 점수 60점 이상 80점 미만 </h1>
                </div>
                <div class="emotion-set">
                    <img src="../imgsrc/snow.png" alt="이모지">
                    <h1>snow: 감정 긍정 점수 40점 이상, 감정 중립 점수 30점 이상 </h1>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
