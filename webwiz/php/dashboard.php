<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>대시보드</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/menu_bar.css">
    <link rel="stylesheet" href="../css/dashboard_style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
</head>

<body>
<!-- 네비게이션바 : 머리말 부분-->
<div class="menu-top">
    <div class="menu-bar2 menu-bar-item2">
        <a href="../php/feelflow_home.php" class="menu-bar1 menu-button menu-bar-item1"><b>FeelFlow</b></a>
        <!-- 네비게이션바 -->
        <div class="menu-bar2">
            <a href="../php/emotion_calender.php" class="menu-button menu-bar-item2">감정 캘린더</a>
            <a href="../php/dashboard.php" class="menu-button menu-bar-item2">감정분석 대시보드</a>
            <a href="../php/content_recommend.php" class="menu-button menu-bar-item2">콘텐츠 추천</a>
            <a href="#matching" class="menu-button menu-bar-item2">사용자 매칭</a>
            <!--마이메이지, 사용자 이미지로 변경하기-->
            <a href="../php/feel_mypage.php" class="menu-button menu-bar2 menu-bar-item2">마이페이지</a>
        </div>
    </div>
</div>

<div class="main-container">
    <!-- Red Section: 전체 이용자 감정 정보 -->
    <section class="red-section">
        <div class="left-content">
            <img src="../imgsrc/snow.png" alt="User Profile Image" class="weather-icon">
            <h1 class="today-emotion">감정</h1>
        </div>
        <div class="right-content">
            <h5>오늘 전체이용자 800명</h5>
            <h3>오늘 FeelFlow 이용자의 기분은 대체적으로 맑아요.</h3>
        </div>
    </section>

    <div class="bottom-section">
        <!-- Blue Section: 유저 감정 추이 -->
        <section class="blue-section">
            <div class="chart">
                <div class="chart-title-period">
                    <div class="chart-title">
                        <h2>기간별 전체 이용자의 감정 추이</h2>
                    </div>
                    <div>
                        <input type="date" id="date-start">
                        <input type="date" id="date-end">
                    </div>
                </div>
                <canvas id="overall-chart"></canvas>
            </div>
            <div class="chart">
                <div class="chart-title-period">
                    <div class="chart-title">
                        <h2>기간별 {이용자}님의 감정 그래프</h2>
                    </div>
                    <div>
                        <input type="date" id="user-date-start">
                        <input type="date" id="user-date-end">
                    </div>
                </div>
                <canvas id="user-chart"></canvas>
            </div>
        </section>

        <!-- Green Section: 실시간 누적 감정분포 및 음악콘텐츠 -->
        <div class="green-pink-container">
            <section class="green-section">
                <div class="donut-chart">
                    <h2>실시간 누적 감정분포</h2>
                    <canvas id="emotion-pie-chart"></canvas>
                </div>
                <div class="music-content">
                    <h2 id="emotion-title" style="margin-bottom: 40px;">감정 노래 1위</h2>
                    <div class="emotion-music-box">
                        <button id="prev-song">⬅</button>
                        <div class="box">
                            <img src="../imgsrc/album-art.png" alt="Album Art" class="album-art">
                            <p class="title-solid">Love Lee</p>
                            <p class="song-title">AKMU</p>
                        </div>
                        <button id="next-song">➡</button>
                    </div>
                </div>
            </section>

            <!-- Pink Section: 성별 및 연령별 감정통계 및 음악콘텐츠 -->
            <section class="pink-section">
                <div class="gender-age-chart">
                    <h2>성별 및 연령별 감정통계</h2>
                    <canvas height="200px" id="age-gender-chart"></canvas>
                </div>
                <div class="song-rankings">
                    <h2>성별 및 연령별 노래 순위</h2>
                    <div class="song-list">
                        <div class="gender-album">
                            <div class="male-album">
                                <p>남성</p>
                                <img class="gender-album-art" src="../imgsrc/male-album.png" alt="Male Album Art">
                                <p class="song-title">Smoke (Prod. by Dynamicduo & Padi)</p>
                            </div>
                            <div class="female-album">
                                <p>여성</p>
                                <img class="gender-album-art" src="../imgsrc/female-album.png"
                                     alt="Female Album Art">
                                <p class="song-title">Small girl (Feat. 도경수 (D.O.))</p>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<script src="../html/dashboard_scripts.js"></script>

</html>