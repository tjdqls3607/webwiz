<?php
session_start();
include 'db_connection.php'; // 데이터베이스 연결 파일

// 로그인된 사용자만 접근 가능
if (!isset($_SESSION['user_nickname'])) {
    header("Location: login.php");
    exit();
}

// 파일이 업로드되었는지 확인
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = '../uploads/'; // 파일 저장 경로
    $file_name = uniqid() . '_' . basename($_FILES['profile_picture']['name']);
    $target_path = $upload_dir . $file_name;

    // 파일을 서버에 저장
    if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_path)) {
        // 데이터베이스에 파일 경로 저장
        $user_nickname = $_SESSION['user_nickname'];
        $sql = "UPDATE users SET profile_image = ? WHERE nickname = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $target_path, $user_nickname);

        if ($stmt->execute()) {
            $_SESSION['profile_picture'] = $target_path; // 세션에 업데이트된 프로필 이미지 경로 저장
            echo json_encode(['status' => 'success', 'message' => '프로필 사진이 업데이트되었습니다.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => '데이터베이스 업데이트 실패']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => '파일 업로드 실패']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => '올바른 파일을 업로드하세요']);
}

$conn->close();
?>
