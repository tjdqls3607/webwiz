<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../php/edit_info.php");
    exit();
}
// 폼이 제출되면 이전 페이지로 돌아가도록 설정
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header("Location: feel_mypage.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Information</title>
    <!-- 필요한 CSS 파일을 추가합니다. -->
</head>
<body>
    <h2>회원 정보 수정</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="nickname">닉네임:</label>
        <input type="text" id="nickname" name="nickname" value="<?php echo $_SESSION['Nname']; ?>"><br><br>
        <label for="comment">한마디:</label>
        <textarea id="comment" name="comment"><?php echo isset($_SESSION['comment']) ? $_SESSION['comment'] : ''; ?></textarea><br><br>
        <button type="submit">저장하기</button>
    </form>
</body>
</html>
