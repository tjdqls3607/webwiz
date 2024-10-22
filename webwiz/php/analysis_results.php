<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// AWS SDK 로드
require '../vendor/autoload.php';

use Aws\Comprehend\ComprehendClient;
use Aws\Exception\AwsException;

// 세션 시작
session_start();

// 텍스트 가져오기 (감정 분석할 내용)
$content = $_POST['content'] ?? '';

// 텍스트가 비어있는 경우 처리
if (empty($content)) {
    die("Error: 분석할 텍스트가 없습니다.");
}

// AWS Comprehend 클라이언트 생성
$client = new ComprehendClient([
    'region' => 'ap-northeast-2', // 사용하고자 하는 AWS 리전
    'version' => 'latest',
    'credentials' => [
        'key'    => 'AKIAUZPNLS3O2ND5EVEN',  // AWS 액세스 키 (보안을 위해 직접 키 입력)
        'secret' => '/LaqSSN/KlVV9ujkudpwxHqAr26gKk/xCS4Ac4c/', // AWS 시크릿 키
    ]
]);

try {
    // 감정 분석 API 호출
    $result = $client->detectSentiment([
        'LanguageCode' => 'ko', // 언어 설정 (한국어인 경우 'ko')
        'Text' => $content, // 분석할 텍스트
    ]);

    // 결과 처리
    $positive_score = round($result['SentimentScore']['Positive'] * 100, 2);
    $neutral_score = round($result['SentimentScore']['Neutral'] * 100, 2);
    $negative_score = round($result['SentimentScore']['Negative'] * 100, 2);

    // 감정 상태 결정 함수
    function determineEmotionState($positive, $neutral, $negative) {
        if ($positive > 80) return ["매우 긍정적", "sunny.png"];
        if ($positive > 60) return ["긍정적", "goodnight.png"];
        if ($positive > 40 && $neutral > 30) return ["약간 긍정적", "snow.png"];
        if ($neutral > 50) return ["중립적", "normal.png"];
        if ($negative > 40 && $neutral > 30) return ["약간 부정적", "rainy.png"];
        if ($negative > 60) return ["부정적", "cloudrainy.png"];
        if ($negative > 80) return ["매우 부정적", "lightning.png"];
        return ["복합적", "normal.png"];
    }

    // 감정 상태 결정
    list($emotion_state, $image_filename) = determineEmotionState($positive_score, $neutral_score, $negative_score);
    $image_path = "/webwiz/webwiz/imgsrc/" . $image_filename;

    // 데이터베이스 연결
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "feelcontent";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // 연결 확인
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // 사용자의 일기 내용과 제목 데이터베이스에 저장
    $user_id = $_SESSION['user_id'] ?? 0; // 세션에서 사용자 ID 가져오기
    $title = $_POST['title1'] ?? ''; // 제목 가져오기

    if (empty($title)) {
        die("Error: 일기 제목이 없습니다.");
    }

    $sql_insert_diary = "INSERT INTO diaries (user_id, title, content, emotion_state) VALUES ('$user_id', '$title', '$content', '$emotion_state')";

    if ($conn->query($sql_insert_diary) === false) {
        die("Error: " . $sql_insert_diary . "<br>" . $conn->error);
    }

    // 감정에 따른 콘텐츠 가져오기
    $sql = "SELECT type, title, description, url FROM content WHERE emotion='$emotion_state'";
    $result = $conn->query($sql);

    $contents = [];
    if ($result === false) {
        die("Error in SQL query: " . $conn->error);
    } elseif ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $contents[] = $row;
        }
    }

    $conn->close();
} catch (AwsException $e) {
    // AWS 오류 처리
    die('Error: ' . $e->getAwsErrorMessage());
} catch (Exception $e) {
    // 일반 오류 처리
    die('General Error: ' . $e->getMessage());
}


?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/analysis_results.css">
    <link rel="stylesheet" href="../css/menu_bar.css">
    <style>
        .Y-M-D {
            margin-top: 200px;
        }
        .emotion_state {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.2em;
            color: #333;
        }
    </style>
</head>
<body>
<div class="menu-top">
    <div class="menu-bar2 menu-bar-item2">
        <a href="feelflow_home.php" class="menu-bar1 menu-button menu-bar-item1"><b>FeelFlow</b></a>
        <div class="menu-bar2">
            <a href="../html/diary_write.html" class="menu-button menu-bar-item2">새로운 일기</a>
            <a href="../html/emotion_calender.html" class="menu-button menu-bar-item2">감정 캘린더</a>
            <a href="#emotion_dash_board" class="menu-button menu-bar-item2">감정분석 대시보드</a>
            <a href="content_recommend.html" class="menu-button menu-bar-item2">콘텐츠 추천</a>
            <a href="chatroom.css" class="menu-button menu-bar-item2">사용자 매칭</a>
            <a href="../php/feel_mypage.php" class="menu-button menu-bar2 menu-bar-item2">마이페이지</a>
        </div>
    </div>
</div>

<div class="main_div">
    <div style="margin-right: 50px;">
        <div class="Y-M-D">
            <?php
            // 파일명에서 날짜 추출
            $filename = $_SESSION['file'] ?? '';
            $dateInfo = explode("-", $filename);
            $year = substr($dateInfo[0], 0, 4);
            $month = substr($dateInfo[0], 4, 2);
            $day = substr($dateInfo[0], 6, 2);
            echo "{$year}년 {$month}월 {$day}일<br>";

            // 유저 닉네임 출력
            $user_nickname = $_SESSION['user_nickname'] ?? '';
            echo "{$user_nickname}님의 분석결과";
            ?>
        </div>

        <div class="sentimental_image">
            <img src="<?php echo $image_path; ?>" alt="Sentimental Image">
        </div><br>

        <div class="emotion_state">
            <h2>현재 감정 상태: <?php echo $emotion_state; ?></h2>
        </div>

        <div class="progress_bar">
            <h2>긍정: <?php echo $positive_score; ?>%</h2>
            <progress value="<?php echo $positive_score; ?>" max="100"></progress>

            <h2>중립: <?php echo $neutral_score; ?>%</h2>
            <progress value="<?php echo $neutral_score; ?>" max="100"></progress>

            <h2>부정: <?php echo $negative_score; ?>%</h2>
            <progress value="<?php echo $negative_score; ?>" max="100"></progress>
        </div>

        <div class="content_recommendation">
            <h2>지금의 감정에 어울리는 콘텐츠는</h2>
            <?php foreach ($contents as $content): ?>
                <div class="content_item">
                    <h3><?php echo ucfirst($content['type']); ?>: <?php echo $content['title']; ?></h3>
                    <p><?php echo $content['description']; ?></p>
                    <a href="<?php echo $content['url']; ?>" target="_blank" class="button">감상하기</a>
                    <br>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</body>
</html>
