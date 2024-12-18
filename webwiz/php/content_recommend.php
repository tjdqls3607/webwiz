<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/menu_bar.css">
    <link rel="stylesheet" href="../css/content_recommend.css">
</head>

<body>
<!-- 네비게이션바 : 머리말 부분-->
<div class="menu-top">
    <div class="menu-bar2 menu-bar-item2">
        <!-- 네비게이션바 메인페이지 -->
        <a href="../php/feelflow_home.php" class="menu-bar1 menu-button menu-bar-item1"><b>FeelFlow</b></a>
        <!-- 네비게이션바 기타페이지 -->
        <div class="menu-bar2">
            <a href="../html/diary_write.html" class="menu-button menu-bar-item2">새로운 일기</a>
            <a href="../php/emotion_calendar.php" class="menu-button menu-bar-item2">감정 캘린더</a>
            <a href="../php/dashboard.php" class="menu-button menu-bar-item2">감정분석 대시보드</a>
            <a href="../php/content_recommend.php" class="menu-button menu-bar-item2">콘텐츠 추천</a>
            <a href="../html/matching.html" class="menu-button menu-bar-item2">사용자 매칭</a>
            <!--마이메이지, 사용자 이미지로 변경하기-->
            <a href="../php/feel_mypage.php" class="menu-button menu-bar2 menu-bar-item2">마이페이지</a>
        </div>
    </div>
</div>

<!-- 오늘의 감정분석 결과 및 전체 이용자 감정 정보 -->
<section class="red-section">
    <div class="left-content">
        <img src="../imgsrc/snow.png" alt="Weather Icon" class="weather-icon">
        <h1 class="today-emotion">감정</h1>
    </div>
    <div class="right-content">
        <h5>오늘 전체이용자 800명</h5>
        <h3>오늘 FeelFlow 이용자의 기분은 대체적으로 맑아요.</h3>
    </div>
</section>

<!-- 감정별 콘텐츠 통계 및 추천 콘텐츠 정보 -->
<div class="content">
    <!-- 왼쪽 섹션 -->
    <div class="left-section">
        <div class="chart-section">
            <canvas id="music-statistics" width="30" height="30"></canvas>
            <canvas id="movie-statistics" width="30" height="10"></canvas>
        </div>
    </div>

    <!-- Chart.js 라이브러리 로드 -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // 감정 비율 데이터 (임의의 비율)
        const emotionLabels = ['Sunny', 'Goodnight', 'Snow', 'Normal', 'Cloudrainy', 'Rainy', 'Lightning'];
        const musicData = [17.8, 16.3, 16.3, 14.3, 14.3, 16.3, 17.6]; // 음악 콘텐츠의 감정 비율
        const movieData = [15.5, 14.0, 14.5, 13.5, 15.0, 15.5, 12.0]; // 영화 콘텐츠의 감정 비율

        // 차트 생성 함수
        function createChart(chartId, data, label) {
            new Chart(document.getElementById(chartId), {
                type: 'pie', // 원형 차트
                data: {
                    labels: emotionLabels,
                    datasets: [{
                        data: data,
                        backgroundColor: ['#FFD700', '#1E90FF', '#8080802', '#FF4500', '#708090', '#B0E0E6', '#A3E1D3'],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        title: {
                            display: true,
                            text: label
                        }
                    }
                }
            });
        }
        // 음악 통계 차트 생성
        createChart('music-statistics', musicData, '음악 콘텐츠의 감정 분포');

        // 영화 통계 차트 생성
        createChart('movie-statistics', movieData, '영화 콘텐츠의 감정 분포');
    </script>

    <!-- 오른쪽 섹션 -->
    <div class="right-section">
        <div class="top-content">
            <!-- 왼쪽 화살표 버튼 -->
            <button class="arrow-btn left" onclick="showPreviousContent()">&#9664;</button>
            <!-- 섹션 제목과 콘텐츠 -->
            <div class="content-display">
                <h2>화창한 기분 일 때 추천하는 콘텐츠</h2>
                <!-- 음악 콘텐츠와 영화 콘텐츠를 반반 나누어 배치 -->
                <div class="content-wrapper">
                    <!-- 감정별 추천 음악 콘텐츠 정보 -->
                    <div class="song-info">
                        <a href="https://www.youtube.com/watch?v=EIz09kLzN9k" target="_blank">
                            <img src="../imgsrc/top-song-cover.jpg" alt="Top Song Cover">
                        </a>
                        <div class="song-details">
                            <p><strong>Love Lee</strong></p>
                            <p>AKMU</p>
                        </div>
                    </div>
                    <!-- 감정별 추천 영화 콘텐츠 정보 -->
                    <div class="movie-info">
                        <a href="https://serieson.naver.com/v2/movie/72559" target="_blank">
                            <img src="../imgsrc/top-movie-cover.jpg" alt="Top Movie Cover">
                        </a>
                        <div class="movie-details">
                            <p><strong>나 홀로 집에</strong></p>
                            <p>연출.Chris Columbus</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 오른쪽 화살표 버튼 -->
            <button class="arrow-btn right" onclick="showNextContent()">&#9654;</button>
        </div>
    </div>
</div>

<script>
    let currentContentIndex = 0;

    const contentList = [
        {
            title: "행복한 기분 일 때 추천하는 콘텐츠",
            song: {
                cover: "../imgsrc/top-song-cover.jpg",
                title: "Love Lee",
                artist: "AKMU",
                link: "https://www.youtube.com/watch?v=EIz09kLzN9k"
            },
            movie: {
                cover: "../imgsrc/top-movie-cover.jpg",
                title: "나 홀로 집에",
                director: "연출.Chris Columbus",
                link: "https://serieson.naver.com/v2/movie/72559"
            }
        },
        {
            title: "우울한 기분 일 때 추천하는 콘텐츠",
            song: {
                cover: "../imgsrc/sad-song-cover.jpg",
                title: "Blue Rain",
                artist: "Fin.K.L",
                link: "https://www.youtube.com/watch?v=PZ-rMQtWoTc"
            },
            movie: {
                cover: "../imgsrc/sad-movie-cover.jpg",
                title: "인생은 아름다워",
                director: "연출.최국희",
                link: "https://serieson.naver.com/v2/movie/536243"
            }
        },
        {
            title: "화난 기분 일 때 추천하는 콘텐츠",
            song: {
                cover: "../imgsrc/angry-song-cover.jpg",
                title: "Weightless",
                artist: "Marconi Union",
                link: "https://www.youtube.com/watch?v=UfcAVejslrU"
            },
            movie: {
                cover: "../imgsrc/angry-movie-cover.jpg",
                title: "인사이드 아웃",
                director: "연출.Pete Docter",
                link: "https://serieson.naver.com/v2/movie/107360"
            }
        }
        // 추가 콘텐츠는 이곳에 추가 가능
        // DB에서 콘텐츠 정보 불러오기 (업데이트 필요)
    ];

    function showPreviousContent() {
        currentContentIndex = (currentContentIndex - 1 + contentList.length) % contentList.length;
        updateContent();
    }

    function showNextContent() {
        currentContentIndex = (currentContentIndex + 1) % contentList.length;
        updateContent();
    }

    function updateContent() {
        const content = contentList[currentContentIndex];
        // 콘텐츠 제목 업데이트
        document.querySelector('.content-display h2').textContent = content.title;
        // 음악 정보 업데이트
        document.querySelector('.song-info img').src = content.song.cover;
        document.querySelector('.song-details strong').textContent = content.song.title;
        document.querySelector('.song-details p:nth-child(2)').textContent = content.song.artist;
        // 영화 정보 업데이트
        document.querySelector('.movie-info img').src = content.movie.cover;
        document.querySelector('.movie-details strong').textContent = content.movie.title;
        document.querySelector('.movie-details p:nth-child(2)').textContent = content.movie.director;
    }
</script>

<!-- 콘텐츠 선택 및 서치 -->
<div class="content-recommendation">
    <!--SELECT 옵션 선택 -->
    <div class="left-content2">
        <div class="content-selectBox">
            <select class="content_select" id="contentTypeSelect">
                <option value="music">음악🎧</option>
                <option value="movie">영화🎬</option>
            </select>
            <!--SELECT 옵션 - 줄 나눔-->
            <span class="icoArrow">
                    <img src="https://freepikpsd.com/media/2019/10/down-arrow-icon-png-7-Transparent-Images.png" alt="">
                </span>
        </div>
        <div class="selectBox">
            <select class="select" id="sentimentSelect">
                <option value="sentiment">감정분류🌈</option>
                <option value="sunny">행복</option>
                <option value="goodnight">기쁨</option>
                <option value="snow">편안함</option>
                <option value="normal">평온함</option>
                <option value="cloudrainy">우울함</option>
                <option value="rainy">슬픔</option>
                <option value="lightning">화남</option>
            </select>
            <!--SELECT 옵션 - 줄 나눔-->
            <span class="icoArrow">
                    <img src="https://freepikpsd.com/media/2019/10/down-arrow-icon-png-7-Transparent-Images.png" alt="">
                </span>
        </div>
    </div>

    <!-- 콘텐츠 검색창 -->
    <div class="right-content2">
        <form action="" method="GET" class="search-form">
            <div class="search">
                <!-- required 속성이 추가된 입력 필드는 반드시 사용자가 값을 입력해야 하며, 그렇지 않으면 브라우저가 폼을 제출하지 않고 경고 메시지를 표시 -->
                <input type="text" id="searchWord" name="searchWord" placeholder="검색어를 입력해주세요." required>
                <button type="submit" class="searchButton">
                    <img src="https://s3.ap-northeast-2.amazonaws.com/cdn.wecode.co.kr/icon/search.png" alt="검색">
                </button>
            </div>
        </form>
    </div>
</div>

<!--

    <?php
// 데이터베이스 연결
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feelcontent";

// 검색어가 제출되었는지 확인
if (isset($_GET['searchWord']) && !empty($_GET['searchWord'])) {
    $searchWord = $_GET['searchWord'];

    // 데이터베이스 연결 생성
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 연결 체크
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL 쿼리 실행 (Prepared Statement 사용)
    $stmt = $conn->prepare("SELECT * FROM content WHERE title LIKE ? OR description LIKE ?");
    $searchTerm = "%" . $searchWord . "%";  // 검색어에 %를 추가하여 LIKE 검색
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // 검색 결과 출력
        $contentInfo = ""; // 콘텐츠 정보를 담을 변수 (팝업용)

        while ($row = $result->fetch_assoc()) {
            // 콘텐츠 정보를 저장하여 팝업에서 사용
            $contentInfo .= "제목: " . htmlspecialchars($row['title']) . "\n";
            $contentInfo .= "설명: " . htmlspecialchars($row['description']) . "\n";
            $contentInfo .= "추천 감정: " . htmlspecialchars($row['emotion']) . "\n\n";
        }

        // 하나의 팝업창에 제목, 설명, 감정 정보가 표시
        echo "<script>alert('{$contentInfo}');</script>";

    } else {
        // 검색 결과 없음
        echo "<script>alert('해당 콘텐츠는 없습니다.');</script>";  // 알림창으로 출력
    }

    // 연결 종료
    $stmt->close();
    $conn->close();
}
?>

-->

<!-- 콘텐츠의 감정별 플레이리스트 -->
<div class="playlist-content">
    <!-- 플레이리스트 섹션 -->
    <div class="playlist-section">
        <!-- 플레이리스트의 콘텐츠 정보 -->
        <div class="playlist-song-info">
            <a href="https://www.youtube.com/watch?v=EIz09kLzN9k" target="_blank">
                <img src="../imgsrc/top-song-cover.jpg" alt="sunny Song Cover">
            </a>
            <div class="playlist-song-details">
                <p><strong>Love Lee</strong></p>
                <p>AKMU</p>
            </div>
        </div>
        <!-- 플레이리스트의 콘텐츠 정보 -->
        <div class="playlist-song-info">
            <a href="https://www.youtube.com/watch?v=PZ-rMQtWoTc" target="_blank">
                <img src="../imgsrc/sad-song-cover.jpg" alt="cloudrany Song Cover">
            </a>
            <div class="playlist-song-details">
                <p><strong>Blue Rain</strong></p>
                <p>Fin.K.L</p>
            </div>
        </div>
        <!-- 플레이리스트의 콘텐츠 정보 -->
        <div class="playlist-song-info">
            <a href="https://www.youtube.com/watch?v=UfcAVejslrU" target="_blank">
                <img src="../imgsrc/angry-song-cover.jpg" alt="lightning Song Cover">
            </a>
            <div class="playlist-song-details">
                <p><strong>Weightless</strong></p>
                <p>Marconi Union</p>
            </div>
        </div>

    </div>
</div>

<script>
    // select의 값이 변경될 때마다 playlist-song-info의 img 요소의 alt 값을 검사하고, 조건에 맞는 콘텐츠만 표시
    document.getElementById("sentimentSelect").addEventListener("change", function() {
        var selectedSentiment = this.value; // 선택된 옵션의 값
        var songItems = document.querySelectorAll(".playlist-song-info");

        songItems.forEach(function(item) {
            var imgAlt = item.querySelector("img").alt; // img 요소의 alt 속성 값

            // 선택된 감정에 맞는 alt 값이 포함된 항목만 표시
            if (selectedSentiment === "sentiment" || imgAlt.toLowerCase().includes(selectedSentiment.toLowerCase())) {
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });
    });
</script>

<div class="bottom"></div>

</body>
