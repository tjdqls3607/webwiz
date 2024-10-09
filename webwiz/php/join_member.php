<?php
// PHP 에러 디버깅 설정 활성화
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 데이터베이스 연결 정보
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

// 폼이 제출되었는지 확인
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 입력된 데이터 받기
    $username = $_POST['username'];
    $email1 = $_POST['email1'];
    $email2 = $_POST['email2'];
    $email = $email1 . '@' . $email2;
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // 비밀번호 해시화
    $nickname = $_POST['nickname'];
    $name = $_POST['name'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];

    // SQL 쿼리 준비 및 실행
    $sql = "INSERT INTO users (username,email, password, nickname, name, birthdate, gender) 
            VALUES ('$username', '$email', '$password', '$nickname', '$name', '$birthdate', '$gender')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('회원가입이 완료되었습니다.'); window.location.href='../html/login.html';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();


}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>FeelFlow 회원 가입</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/joinmemstyle.css" />
</head>

<body>
    <header style="height: 100px; display: flex; justify-content: space-between; align-items: center;">
        <h2>FeelFlow</h2>
    </header>
    <div class="form-container">
        <form class="join_member" method="POST">
            <div class="form-header">
                <h1>회원가입</h1>
                <hr style="border-top: 3px solid #074635;"><br>
            </div>
            <div class="form-body">
                <span class="mini-title">*아이디</span>
                <div class="textbox">
                    <span class="icon"><img class="icon" src="../imgsrc/user.png"></span>
                    <input type="text" name="username" placeholder="아이디를 입력해주세요">
                </div>
                <span class="mini-title">*비밀번호</span>
                <div class="textbox">
                    <span class="icon"><img class="icon" src="../imgsrc/lock.png"></span>
                    <input type="password" name="password" placeholder="비밀번호 입력 (문자, 숫자, 특수문자 포함 8~20자)">
                </div>
                <span class="mini-title">*이메일</span>
                <div class="textbox">
                    <span class="icon"><img class="icon" src="../imgsrc/message.png"></span>
                    <input style="width: 40%" type="text" name="email1" placeholder="이메일 주소">
                    <span style="padding-left: 5px; padding-right: 5px;">@</span>
                    <input style="width: 40%" type="text" name="email2" id="email2">
                </div>
                <script>
                    function updateEmailDomain() {
                        const email2Input = document.getElementById('email2');
                        const email2Select = document.getElementById('email2_select');

                        if (email2Select.value === "") {
                            email2Input.disabled = false;
                            email2Input.value = "";
                        } else {
                            email2Input.disabled = true;
                            email2Input.value = email2Select.value;
                        }
                    }
                </script>
                <span class="mini-title">*닉네임</span>
                <div class="textbox">
                    <span class="icon"><img class="icon" src="../imgsrc/user.png"></span>
                    <input type="text" name="nickname" placeholder="닉네임을 입력해주세요">
                </div><br>
                <hr style="border: 1px solid #5fa37a; opacity: 0.5;"><br>
                <div class="horizon_align">
                    <div class="horizon_child">
                        <span class="mini-title">이름</span>
                        <div class="textbox"><input type="text" name="name" placeholder="이름을 입력해주세요"></div>
                    </div>
                    <div class="horizon_child">
                        <span class="mini-title">생년월일</span>
                        <div class="textbox">
                            <input type="text" name="birthdate" placeholder="생년월일 8자리를 입력하세요">
                        </div>
                    </div>
                </div>
                <span class="mini-title">성별</span>
                <ul class="gender_list" id="listIdentifyGender">
                    <li>
                        <input type="radio" name="gender" id="none" value="none">
                        <label for="none">선택안함</label>
                    </li>
                    <li>
                        <input type="radio" name="gender" id="male" value="male">
                        <label for="male">남성</label>
                    </li>
                    <li>
                        <input type="radio" name="gender" id="female" value="female">
                        <label for="female">여성</label>
                    </li>
                </ul>
                <br><hr style="border: 1px solid #5fa37a; opacity: 0.5;">
                <button type="submit">회원가입</button>
            </div>
        </form>
    </div>
</body>

</html>
