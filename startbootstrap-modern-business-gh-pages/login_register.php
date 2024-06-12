<?php
session_start();
require 'config.php';

$message = '';

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
        $stmt = $conn->prepare("SELECT UserID, Password, UserName, Email, Permission FROM User WHERE UserID = ?");
        $stmt->bind_param("s", $userID);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($fetchedUserID, $storedPassword, $fetchedUserName, $fetchedEmail, $permission);
            $stmt->fetch();

            if ($password === $storedPassword) { // 密碼驗證
                $_SESSION['loggedin'] = true;
                $_SESSION['userID'] = $fetchedUserID;
                $_SESSION['username'] = $fetchedUserName;
                $_SESSION['email'] = $fetchedEmail;
                $_SESSION['permission'] = $permission;

        //         header("Location: " . $_SERVER['HTTP_REFERER']);
        //         exit;
        //     } else {
        //         echo "Invalid password.";
        //     }
        // } else {
        //     echo "No user found with that UserID.";
        // }
                $message = "Login successful"; // 設置成功訊息
                echo "<script>setTimeout(function() { window.location.href = '".$_SERVER['HTTP_REFERER']."'; }, 5000);</script>";
            } else {
                $message = "Invalid password"; // 設置失敗訊息
            }
        } else {
            $message = "No user found with that UserID"; // 設置失敗訊息
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

    //         if ($stmt->execute()) {
    //             echo "Registration successful. Please login.";
    //         } else {
    //             echo "Error: " . $stmt->error;
    //         }
    //         $stmt->close();
    //     } else {
    //         echo "UserID already taken.";
    //     }
    // }
            if ($stmt->execute()) {
                $message = "Registration successful. Please login."; // 註冊成功訊息
            } 
            else {
                $message = "Error: " . $stmt->error; // 註冊失敗訊息
            }
            $stmt->close();
        } 
        else {
            $message = "UserID already taken."; // 用戶名已被使用
        }
    }

        $stmt->close();
} 
else {
    $message = "UserID already taken."; // 用戶名已被使用
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        .message-box { /* @ 新增CSS樣式 */
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 10px 20px; /* @ 調整訊息框大小 */
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            color: #721c24;
            text-align: center;
            z-index: 1000;
            width: 200px; /* @ 調整寬度 */
        }

        .message-box.success { /* @ 成功訊息樣式 */
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
    </style>
</head>
<body>
    <?php if (!empty($message)): ?>
        <div id="messageBox" class="message-box <?php echo ($message === 'Login successful' || $message === 'Registration successful. Please login.') ? 'success' : ''; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
        <script>
            document.getElementById('messageBox').style.display = 'block';
            setTimeout(function() {
                document.getElementById('messageBox').style.display = 'none';
                <?php if ($message === 'Login successful' || $message === 'Registration successful. Please login.'): ?>
                window.location.href = "<?php echo $_SERVER['HTTP_REFERER']; ?>"; /* @ 重定向用戶 */
                <?php endif; ?>
            }, 5000); /* @ 調整時間為5秒 */
        </script>

    <?php endif; ?>
</body>
</html>