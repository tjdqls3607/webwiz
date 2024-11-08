<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// 데이터베이스 연결
$servername = "localhost"; // 서버 이름
$username = "root"; // 데이터베이스 사용자 이름
$password = ""; // 데이터베이스 비밀번호
$dbname = "feelcontent"; // 데이터베이스 이름

$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("데이터베이스 연결 실패: " . $conn->connect_error);
}

// diaries_id 가져오기
$diaries_id = isset($_GET['diaries_id']) ? intval($_GET['diaries_id']) : 0;

// 데이터베이스에서 일기 가져오기
$sql = "SELECT title, content, created_at FROM diaries WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $diaries_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $diaries = $result->fetch_assoc();
} else {
    echo "일기를 찾을 수 없습니다.";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($diaries['title']); ?></title>
    <style>
        /* 작은 창의 CSS 스타일 */
        body { font-family: 'Noto Sans KR', sans-serif; margin: 20px; }
        h2 { color: #126b54; }
        p { line-height: 1.5; }
    </style>
</head>
<body>
<h2><?php echo htmlspecialchars($diaries['title']); ?></h2>
<p><em><?php echo htmlspecialchars($diaries['created_at']); ?></em></p>
<p><?php echo nl2br(htmlspecialchars($diaries['content'])); ?></p>
</body>
</html>
