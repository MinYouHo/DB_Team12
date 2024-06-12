<?php

// 假设您已经设置了数据库连接

// 检查表单提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取表单数据
    $userId = $_POST['userId'];
    $stockCode = $_POST['stockCode'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $action = $_POST['action'];

    // 检查股票代码是否有效（假设为有效）
    // 在实际应用中，您可能需要检查股票代码是否存在于您的股票数据库中
    $validStockCode = true;

    // 根据操作类型执行相应的逻辑
    if ($action === 'buy') {
        // 检查股票代码是否有效
        if (!$validStockCode) {
            echo "错误：无效的股票代码！";
            exit;
        }

        // 计算交易总金额
        $totalPrice = $price * $quantity;

        // 检查用户余额是否足够
        $sql = "SELECT Balance FROM User WHERE UserID = '$userId'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $balance = $row['Balance'];
            if ($balance < $totalPrice) {
                echo "错误：账户余额不足！";
                exit;
            }
        } else {
            echo "错误：用户不存在！";
            exit;
        }

        // 扣除用户余额
        $newBalance = $balance - $totalPrice;
        $sql = "UPDATE User SET Balance = $newBalance WHERE UserID = '$userId'";
        if ($conn->query($sql) !== TRUE) {
            echo "错误更新用户余额：" . $conn->error;
            exit;
        }

        // 更新交易状态为成功
        $status = 'success';
    } elseif ($action === 'sell') {
        // 添加卖出股票的逻辑
    }

    // 记录交易历史记录，包括交易状态
    $sql = "INSERT INTO Trade (UserID, StockCode, Price, Quantity, ActionType, Status) VALUES ('$userId', '$stockCode', $price, $quantity, '$action', '$status')";
    if ($conn->query($sql) !== TRUE) {
        echo "错误插入交易记录：" . $conn->error;
        exit;
    }

    // 显示成功消息
    echo "交易成功！";
} else {
    // 如果不是通过 POST 请求提交的，显示错误消息
    echo "错误：无效的请求！";
}

?>
