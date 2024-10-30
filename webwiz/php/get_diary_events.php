<?php
session_start();
$user_id = $_SESSION['user_id'] ?? 0;

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'feelcontent';
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 저장된 일기 데이터를 JSON 형식으로 가져오기
$sql = "SELECT title, created_at, content FROM diaries WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = [
        'title' => $row['emotion_state'],  // 감정 결과를 제목으로
        'start' => date('Y-m-d', strtotime($row['created_at'])),  // 날짜 형식 변환
        'description' => $row['content']  // 일기 내용
    ];
}

header('Content-Type: application/json');
echo json_encode($events);
$conn->close();
?>
