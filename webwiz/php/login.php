<?php
session_start();

// 데이터베이스 연결 설정
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feel_flow_member";

// 데이터베이스 연결 생성
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 양식에서 제출된 데이터 가져오기
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 사용자 이메일과 비밀번호가 일치하는지 확인하는 SQL 쿼리
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // 사용자가 존재하는 경우
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // 비밀번호가 일치하는 경우
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_nickname'] = $row['nickname'];
            header("Location: login.php");
            exit();
        } else {
            // 비밀번호가 일치하지 않는 경우
            $error = "비밀번호가 잘못되었습니다.";
        }
    } else {
        // 사용자가 존재하지 않는 경우
        $error = "해당 사용자가 없습니다.";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인 확인 - FeelFlow</title>
    <link rel="stylesheet" href="/webwiz/webwiz/css/mainstyle.css">
</head>

<body>
    <header>
        <h2>FeelFlow</h2>
    </header>
    <div class="content">
        <?php
        if (!empty($error)) {
            echo '<p style="color: red;">' . $error . '</p>';
        } else {
            echo '<h1>안녕하세요, ' . $_SESSION['user_nickname'] . '님!</h1>';
            echo '<p>로그인이 완료되었습니다.</p>';
            echo '<p><a href="../php/main.php">메인페이지로 이동하기</a></p>';
            echo '<p><a href="../html/diary_write.html">일기 작성하러 가기</a></p>';
        }
        ?>
    </div>
</body>

</html>
