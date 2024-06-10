<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_POST['userID'];
    $password = $_POST['password'];
    $action = $_POST['action'];
    $username = isset($_POST['username']) ? $_POST['username'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;

    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($action == 'login') {
        // 處理登入邏輯
        $stmt = $conn->prepare("SELECT UserID, Password, UserName, Permission FROM User WHERE UserID = ?");
        $stmt->bind_param("s", $userID);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($fetchedUserID, $storedPassword, $fetchedUserName, $permission);
            $stmt->fetch();

            if ($password === $storedPassword) { // 密碼驗證
                $_SESSION['loggedin'] = true;
                $_SESSION['userID'] = $fetchedUserID;
                $_SESSION['username'] = $fetchedUserName;
                $_SESSION['permission'] = $permission;
                $_SESSION['message'] = "Login successful."; // 添加成功消息

                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit;
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No user found with that UserID.";
        }

        $stmt->close();
    } elseif ($action == 'register') {
        // 處理註冊邏輯
        $stmt = $conn->prepare("SELECT UserID FROM User WHERE UserID = ?");
        $stmt->bind_param("s", $userID);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO User (UserID, UserName, Password, Email, Permission) VALUES (?, ?, ?, ?, ?)");
            $permission = 0; // 默認權限
            $stmt->bind_param("ssssi", $userID, $username, $password, $email, $permission);

            if ($stmt->execute()) {
                echo "Registration successful. Please login.";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "UserID already taken.";
        }
    }

    $conn->close();
}
?>
