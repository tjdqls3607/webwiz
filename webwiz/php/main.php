<?php
session_start();

// 세션이 존재하지 않으면 로그인 페이지로 리다이렉트
if (!isset($_SESSION['user_nickname'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>메인 페이지 - FeelFlow</title>
    <link rel="stylesheet" href="/webwiz/webwiz/css/mainstyle.css">
</head>

<body>
    <header>
        <h2>FeelFlow</h2>
        <div class="user-info">
            <?php echo "안녕하세요, " . $_SESSION['user_nickname'] . "님!"; ?>
            <a href="feel_mypage.php">마이페이지</a>
            <a href="../html/diary_write.html">일기 작성하러 가기</a>
        </div>
    </header>
    <div class="content">
        <h1>메인 페이지</h1>
        <p>환영합니다, FeelFlow에 오신 것을 환영합니다.</p>
    </div>
</body>

</html>
