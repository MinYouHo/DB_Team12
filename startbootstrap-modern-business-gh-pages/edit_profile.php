<?php
session_start();
require 'config.php';

// 檢查用戶是否登入
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    echo "更改無效！請先登入~ 3秒後自動回到主頁";
    echo "<script>
        setTimeout(function() {
            window.location.href = 'index.php';
        }, 3000);
        </script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $_SESSION['userID'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 更新資料庫
    if (!empty($password)) {
        $sql = "UPDATE User SET UserName = ?, email = ?, password = ? WHERE UserID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $username, $email, $password, $userID);
    } else {
        $sql = "UPDATE User SET UserName = ?, email = ? WHERE UserID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $username, $email, $userID);
    }

    if ($stmt->execute()) {
        // 更新 session 中的用戶信息
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;

        echo "<div style='text-align: center; margin-top: 20px;'>
                <h2>個人資料更新成功！</h2>
                <p>3秒後重定向到首頁...</p>
              </div>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 3000);
              </script>";
    } else {
        echo "<div style='text-align: center; margin-top: 20px;'>
                <h2>更新失敗: " . $stmt->error . "</h2>
              </div>";
    }

    $stmt->close();
}

$conn->close();
?>
