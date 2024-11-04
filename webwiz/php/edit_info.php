<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION['user_nickname'])) {
    echo "<script>alert('로그인이 필요합니다. 로그인 페이지로 이동합니다.');</script>";
    header("Location: login.php");
    exit();
}

// 데이터베이스 연결 설정 (필요한 정보로 수정하세요)
$servername = "localhost";
$username = "root"; // 데이터베이스 사용자 이름
$password = ""; // 데이터베이스 비밀번호
$dbname = "feel_flow_member"; // 데이터베이스 이름

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("데이터베이스 연결 실패: " . $conn->connect_error);
}

// 폼이 제출되면 데이터베이스를 업데이트
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 입력값 가져오기
    $new_nickname = $_POST['nickname'];
    $new_comment = $_POST['comment'];
    $user_id = $_SESSION['user_id']; // 사용자의 고유 ID (세션에 저장된 사용자 ID가 필요)

    // 데이터베이스 업데이트 쿼리
    $sql = "UPDATE users SET nickname = ?, comment = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $new_nickname, $new_comment, $user_id);

    if ($stmt->execute()) {
        // 세션 정보 업데이트
        $_SESSION['user_nickname'] = $new_nickname;
        $_SESSION['user_comment'] = $new_comment;

        // 마이 페이지로 이동
        header("Location: feel_mypage.php");
        exit();
    } else {
        echo "정보 수정 중 오류가 발생했습니다.";
    }
    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Information</title>
</head>
<body>
<h2>회원 정보 수정</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="nickname">닉네임:</label>
    <input type="text" id="nickname" name="nickname" value="<?php echo $_SESSION['user_nickname']; ?>">
    <label for="comment">한마디:</label>
    <textarea id="comment" name="comment"><?php echo $_SESSION['user_comment']; ?></textarea>
    <button type="submit"> 저장하기</button>
</form>
</body>
</html>
