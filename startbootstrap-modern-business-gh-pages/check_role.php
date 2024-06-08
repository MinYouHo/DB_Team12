<?php
session_start();

// ******** 更新你的個人設置 ******** 
$servername = "140.122.184.129:3310";
$username = "team12";
$password = "SM(tFcLC*Ma0(N(E";
$dbname = "team12";

// 顯示錯誤訊息
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connecting to and selecting a MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 設置字符集為UTF-8
if (!$conn->set_charset("utf8mb4")) {
    printf("Error loading character set utf8mb4: %s\n", $conn->error);
    exit();
}

// 檢查用戶角色
$user_permission = 0; // 默認角色為普通用戶
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT Permission FROM users WHERE UserID = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->bind_result($permission);
    if ($stmt->fetch()) {
        $user_permission = $permission;
    }
    $stmt->close();
}

$conn->close();

// 將用戶權限傳遞給HTML模板
include 'MainPage.html';
?>
