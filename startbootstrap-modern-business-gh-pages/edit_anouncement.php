<?php

session_start();
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || !isset($_SESSION['permission']) || !$_SESSION['permission']) {
    die("Access denied");
}

require 'config.php';

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];
$sql = "SELECT content FROM board WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($content);
$stmt->fetch();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_content = $_POST['content'];

    $stmt = $conn->prepare("UPDATE board SET content = ? WHERE id = ?");
    $stmt->bind_param("si", $new_content, $id);

    if ($stmt->execute()) {
        header("Location: main_page.php"); // 重定向到主頁面
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>修改公告</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>修改公告</h1>
    <form method="POST">
        <div class="mb-3">
            <label for="content" class="form-label">公告內容</label>
            <textarea class="form-control" id="content" name="content" rows="3"><?php echo htmlspecialchars($content); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">保存修改</button>
    </form>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
