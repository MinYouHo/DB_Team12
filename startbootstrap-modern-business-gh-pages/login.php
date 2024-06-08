<?php
session_start();

// ******** 更新你的個人設置 ******** 
$servername = "140.122.184.129:3310";
$username = "team12";
$password = "SM(tFcLC*Ma0(N(E";
$dbname = "team12";

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT UserID FROM users WHERE UserID = ? AND Password = ?");
    $stmt->bind_param("ss", $user_id, $password);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $_SESSION['user_id'] = $user_id;
        header("Location: MainPage.html");
        exit();
    } else {
        echo "Invalid User ID or Password";
    }
    
    $stmt->close();
}

$conn->close();
?>
