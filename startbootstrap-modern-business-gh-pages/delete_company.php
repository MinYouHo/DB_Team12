<?php
require 'config.php';

session_start();

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['companyID'])) {
    $companyID = $_POST['companyID'];

    // 檢查用戶是否已登入
    if (isset($_SESSION['userID'])) {
        $user_id = $_SESSION['userID'];

        // 刪除追蹤的公司記錄
        $stmt = $conn->prepare("DELETE FROM follow WHERE UserID = ? AND CompanyID = ?");
        if ($stmt === false) {
            die("準備語句失敗: " . $conn->error);
        }
        $stmt->bind_param("ss", $user_id, $companyID);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "公司已刪除";
        } else {
            echo "刪除失敗或公司不存在";
        }
        $stmt->close();
    } else {
        echo "用戶未登入";
    }
} else {
    echo "無效的請求";
}

$conn->close();
header('Location: follow_company.php');
?>
