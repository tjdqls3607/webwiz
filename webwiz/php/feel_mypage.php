<?php
session_start();
if (!isset($_SESSION['user_nickname'])) {
    header("Location: login.php");
    exit();
}

echo '<div class="menu-bar2 menu-bar-item2">';
echo '<a href="../php/feelflow_home.php" class="menu-bar1 menu-button menu-bar-item1">FeelFlow</a>';

echo '<div class="menu-bar2">';
echo '<a href="../php/logout.php" class="menu-button menu-bar-item2">로그아웃</a>';
echo '<a href="../html/diary_write.html" class="menu-button menu-bar-item2">새로운 일기</a>';
echo '<a href="../html/emotion_calender.html" class="menu-button menu-bar-item2">감정 캘린더</a>';
echo '<a href="#emotion_dash_board" class="menu-button menu-bar-item2">감정분석 대시보드</a>';
echo '<a href="#content" class="menu-button menu-bar-item2">콘텐츠 추천</a>';
echo '<a href="#matching" class="menu-button menu-bar-item2">사용자 매칭</a>';
echo '</div>';
echo '</div>';

// 세션에서 프로필 사진이 있는 경우 가져오기
$profile_picture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : 'noprofile.png';
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feel Flow 마이 페이지</title>
    <link rel="stylesheet" href="../css/menu_bar.css">
    <link rel="stylesheet" href="../css/feel_mypage.css">
</head>
<body>
<!-- 페이지 제목 -->
<h1 class="page-title">MY PAGE</h1>

<!-- 프로필 컨테이너 -->
<section class="main-section">
    <div class="profile-image-container">
        <input id="file-input" type="file" accept="image/*" onchange="uploadProfilePicture(event)">
        <label for="file-input" class="profile-image-label" title="프로필 사진 변경">
            <img class="profile-image" id="profile-img" src="webwiz/webwiz/imgsrc/<?php echo $profile_picture; ?>">
        </label>
        <div class="user-nickname">닉네임: <?php echo $_SESSION['user_nickname']; ?></div>
        <div class="user-comment">한마디: <?php echo isset($_SESSION['user_comment']) ? $_SESSION['user_comment'] : ''; ?></div>
    </div>
    <a href="../php/edit_info.php" class="edit-info-button">내 정보 수정하기</a>
</section>

<!-- 추가 컨테이너 -->
<section class="content-container">
    <div class="content-box content-box-1"></div>
    <div class="content-box content-box-2"></div>
</section>

<!-- 스크립트 -->
<script>
    // 프로필 사진 업로드 함수
    function uploadProfilePicture(event) {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function () {
            var image = document.getElementById('profile-img');
            image.src = reader.result;

            // 서버에 프로필 사진 업로드
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

    // 정보 수정 모달 열기
    function openEditInfoModal() {
        document.getElementById('editInfoModal').style.display = "block";
    }

    // 정보 수정 모달 닫기
    function closeEditInfoModal() {
        document.getElementById('editInfoModal').style.display = "none";
    }

    // 정보 저장 함수
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
