<?php
session_start();
if (!isset($_SESSION['user_nickname'])) {
    header("Location: login.php");
    exit();
}
// 프로필 이미지가 세션에 저장되어 있는 경우 해당 이미지를 가져옴
$profile_picture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : 'noprofile.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feel Flow My Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Script&family=Pacifico&display=swap" rel="stylesheet">
    <link href="./bootstrap4/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom, #FFFEF1, #D9EEDB);
            height: 100vh;
            display: flex;
            justify-content: flex-start;
            flex-direction: column;
            align-items: flex-start;
            padding: 30px;
        }
        .logo {
            color: #000000;
            font-size: 36px;
            font-family: 'Noto Sans KR', sans-serif;
        }
        .navigation {
            padding: 10px 0; /* 네비게이션 바 내부 간격 */
            display: flex;
            justify-content: flex-end; /* 네비게이션 바를 오른쪽으로 이동 */
            width: 100%; /* 네비게이션 바 전체 너비를 차지하도록 설정 */
            box-sizing: border-box; /* 패딩 및 보더 포함하여 전체 너비 계산 */
        }
        .navigation a {
            color: #5BE67E; /* 링크 텍스트 색상 */
            margin-right: 15px; /* 링크 간격 */
            font-size: 18px; /* 링크 텍스트 크기 */
            text-decoration: none; /* 링크 텍스트에 밑줄 제거 */
        }
        .navigation a:hover {
            color: #B3FFB3; /* 호버 시 링크 텍스트 색상 */
        }
        .container {
            width: 1380px;
            height: 300px;
            background-color: rgb(255, 255, 255);
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start; /* 변경: 중앙에서 왼쪽 정렬로 */
            align-items: flex-start;
            position: relative;
        }
        .my-page {
            color: #000000;
            font-size: 40px;
            font-family: 'Script', cursive;
            position: absolute;
            top: 8%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .container-parent {
            display: flex;
            margin-top: 20px;
        }
        .container1, .container2 {
            height: 300px;
            background-color: rgb(255, 255, 255);
        }
        .container1 {
            width: 630px;
            margin-right: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container2 {
            width: 730px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .profile-picture-container {
            display: flex;
            flex-direction: column;
            align-items: center; /* 변경: 왼쪽에서 중앙으로 정렬 */
            position: relative;
            cursor: pointer;
            margin-top: 40px; /* 변경: 상단 마진 설정 */
            margin-left: 15px;
        }
        .profile-icon {
            font-size: 150px;
            color: #555;
            cursor: pointer;
        }
        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }
        #file-input {
            display: none;
        }
        .nickname {
            margin-top: 10px;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        }
        .edit-info-btn {
            position: absolute;
            bottom: 20px;
            right: 20px;
        }
    </style>
</head>
<body>
    <div class="my-page">마이 페이지</div>
    <div class="logo"><a href="main.php">FeelFlow</a></div>
    <div class="navigation">
        <a href="diary_write.html">일기 작성하러 가기</a>
        <a href="#">공지사항</a>
        <a href="#">컨텐츠</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="container">
        <div class="profile-picture-container">
            <input id="file-input" type="file" accept="image/*" onchange="uploadProfilePicture(event)">
            <label for="file-input" class="profile-icon" title="프로필 사진 바꾸기">
                <img class="profile-picture" id="profile-image" src="webwiz/webwiz/imgsrc/noprofile.png">
            </label>
            <div class="nickname">닉네임: <?php echo $_SESSION['nickname']; ?></div>
            <div class="comment">한마디: <?php echo $comment; ?></div>
        </div>
        <a href="../php/edit_info.php" class="edit-info-btn">내 정보 수정하기</a>
    </div>
    <div class="container-parent">
        <div class="container1"></div>
        <div class="container2"></div>
    </div>
    <script>

        function uploadProfilePicture(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function () {
                var image = document.getElementById('profile-image');
                image.src = reader.result;

                // 업로드된 프로필 사진을 서버에 저장
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'upload_profile_picture.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.status === 'success') {
                            alert('프로필 사진이 변경되었습니다.');
                        } else {
                            alert('프로필 사진 변경 실패: ' + response.message);
                        }
                    } else {
                        alert('서버 오류: ' + xhr.status);
                    }
                };
                xhr.send('profile_picture=' + encodeURIComponent(reader.result));
            };
            reader.readAsDataURL(input.files[0]);
        }
        function openEditInfoModal() {
            document.getElementById('editInfoModal').style.display = "block";
        }

        function closeEditInfoModal() {
            document.getElementById('editInfoModal').style.display = "none";
        }

        function saveInfo() {
            var nickname = document.getElementById('nickname').value;
            var comment = document.getElementById('comment').value;

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'save_info.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    alert('정보가 저장되었습니다.');
                    closeEditInfoModal();
                    location.reload();
                } else {
                    alert('정보 저장 실패: ' + response.message);
                }
            } else {
                alert('서버 오류: ' + xhr.status);
            }
        };
        xhr.send('nickname=' + encodeURIComponent(nickname) + '&comment=' + encodeURIComponent(comment));
    }

    </script>
</body>
</html>
