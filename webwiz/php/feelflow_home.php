<?php
session_start();

// 로그인 상태 확인
$isLoggedIn = isset($_SESSION['user_id']);

// 네비게이션 바 HTML 시작
echo '<div class="menu-bar2 menu-bar-item2">';
echo '<a href="../php/feelflow_home.php" class="menu-bar1 menu-button menu-bar-item1">FeelFlow</a>';

echo '<div class="menu-bar2">';

if ($isLoggedIn) {
    // 로그인 된 경우
    echo '<a href="../php/feel_mypage.php" class="welcome-message menu-button menu-bar-item2">' . htmlspecialchars($_SESSION['user_nickname']) . '님 환영합니다.</a>';
    echo '<a href="../php/logout.php" class="menu-button menu-bar-item2">로그아웃</a>';
    echo '<a href="../html/diary_write.html" class="menu-button menu-bar-item2">새로운 일기</a>';
    echo '<a href="../php/emotion_calender.php" class="menu-button menu-bar-item2">감정 캘린더</a>';
    echo '<a href="dashboard.php" class="menu-button menu-bar-item2">감정분석 대시보드</a>';
    echo '<a href="content_recommend.php" class="menu-button menu-bar-item2">콘텐츠 추천</a>';
    echo '<a href="../html/matching.html" class="menu-button menu-bar-item2">사용자 매칭</a>';
} else {
    // 로그인 되지 않은 경우
    echo '<a href="../html/login.html" class="menu-button menu-bar-item2">로그인</a>';
    echo '<a href="../php/join_member.php" class="menu-button menu-bar-item2">회원가입</a>';
}

echo '</div>';
echo '</div>';

// HTML 시작 전에 JavaScript 변수 설정
echo '<script>';
echo 'var isLoggedIn = ' . ($isLoggedIn ? 'true' : 'false') . ';';
echo '</script>';
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/menu_bar.css">
    <link rel="stylesheet" href="../css/feelflow_home.css">
</head>

<body>

<!-- 홈페이지 첫번째 부분 -->
<section class="main-section">
    <br>
    <h1>모든 순간을 기억하세요.<br> 감정을 담은 일기로 새로운 당신을 발견하세요.</h1>
    <p>하루의 끝에, 감정을 기록하고 더 나은 내일을 상상해보세요.<br> 오늘 당신의 기분과 하루는 어땠나요? 내일은 어떨까요?</p>
    <button id="startButton">시작하기</button>
</section>

<script>
    document.getElementById('startButton').addEventListener('click', function() {
        if (isLoggedIn) {
            window.location.href = '../php/feel_mypage.php';
        } else {
            window.location.href = '../html/login.html';
        }
    });
</script>

<!-- 홈페이지 두번째 부분 -->
<section class="service-overview">
    <div>
        <img src="../imgsrc/400x400(1).gif" alt="서비스 이미지">
    </div>
    <div>
        <h4>FeelFlow 소개</h4>
        <p>텍스트 감정분석 AI를 활용한 <b>다이어리 및 콘텐츠 추천</b> 서비스</p><br>
        <h2>FeelFlow는 사용자의 감정 분석을 통해 맞춤형 콘텐츠 서비스를 제공하는 것을 목표로 합니다.</h2>
        <button>콘텐츠 추천받기</button>
    </div>
</section>

<!-- 홈페이지 세번째 부분 -->
<section class="features">
    <div>
        <img src="../imgsrc/100x100(1).png" alt="Feature 1">
        <p>사용자의 감정을 일기예보처럼 기록하고 분석해, 각 날짜에 해당하는 감정을 날씨 이모지로 시각화 합니다. 자신의 감정 변화를 한 눈에 파악해보세요.</p>
    </div>
    <div>
        <img src="../imgsrc/100x100(3).png" alt="Feature 2">
        <p>감정 기록을 통해 다양한 통계 그래프와 분석 결과를 제공합니다. 실시간 감정 변화와 패턴을 확인해보세요.</p>
    </div>
    <div>
        <img src="../imgsrc/100x100(2).png" alt="Feature 3">
        <p>텍스트 감정분석을 기반으로, 사용자 맞춤형 콘텐츠를 추천합니다. 나만의 콘텐츠를 만나보세요.</p>
    </div>
    <div>
        <img src="../imgsrc/100x100(4).png" alt="Feature 4">
        <p>비슷한 감정을 가진 사람들과 그룹 매칭을 제공합니다. 감정을 나누고 친구를 만나보세요.</p>
    </div>
</section>

<footer>
    <p>FeelFlow &copy; 2024 | 개발자: 김유진, 임미지, 정성빈</p>
    <p>이용약관 | 개인정보처리방침</p>
</footer>
</body>
</html>

