<?php
// 开启会话
session_start();

// 数据库连接信息
define('DB_SERVER', "140.122.184.129:3310");
define('DB_USERNAME', 'team12');
define('DB_PASSWORD', 'SM(tFcLC*Ma0(N(E');
define('DB_DATABASE', 'team12');

// 建立数据库连接
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// 检查连接是否成功
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 处理提交的表单数据
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 使用会话中的 userID
    if (!isset($_SESSION['userID'])) {
        die("用户未登录");
    }
    $userid = $_SESSION['userID'];
    $companyid = $_POST['stockCode']; // 这里获取从表单传来的公司代码
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $action = $_POST['action']; // 'buy' 或 'sell'

    // 检查 userid 是否在 user 表中存在
    $sql_check_user = "SELECT COUNT(*) as count FROM User WHERE UserID = ?";
    $stmt_check_user = $conn->prepare($sql_check_user);
    if ($stmt_check_user === false) {
        die("准备语句失败: " . $conn->error);
    }
    $stmt_check_user->bind_param("s", $userid);
    $stmt_check_user->execute();
    $result_check_user = $stmt_check_user->get_result();
    $user_exists = $result_check_user->fetch_assoc()['count'] > 0;
    $stmt_check_user->close();

    if (!$user_exists) {
        die("交易失败: 用户ID不存在.");
    }

    // 检查 companyid 是否在 company 表中存在
    $sql_check_company = "SELECT COUNT(*) as count FROM company WHERE CompanyID = ?";
    $stmt_check_company = $conn->prepare($sql_check_company);
    if ($stmt_check_company === false) {
        die("准备语句失败: " . $conn->error);
    }
    $stmt_check_company->bind_param("s", $companyid);
    $stmt_check_company->execute();
    $result_check_company = $stmt_check_company->get_result();
    $company_exists = $result_check_company->fetch_assoc()['count'] > 0;
    $stmt_check_company->close();

    if (!$company_exists) {
        die("交易失败: 公司ID不存在.");
    }

    // 开始事务
    $conn->begin_transaction();

    try {
        // 根据交易类型计算总成本，并更新 bankroll
        $total_cost = $price * $quantity;

        // 获取用户当前的 bankroll
        $sql_get_bankroll = "SELECT bankroll FROM buystock WHERE UserID = ?";
        $stmt_get_bankroll = $conn->prepare($sql_get_bankroll);
        if ($stmt_get_bankroll === false) {
            throw new Exception("准备语句失败: " . $conn->error);
        }
        $stmt_get_bankroll->bind_param("s", $userid);
        $stmt_get_bankroll->execute();
        $result_get_bankroll = $stmt_get_bankroll->get_result();
        if ($result_get_bankroll->num_rows == 0) {
            throw new Exception("交易失败: 找不到用户的 bankroll 记录.");
        }
        $row = $result_get_bankroll->fetch_assoc();
        $current_bankroll = $row['bankroll'];
        $stmt_get_bankroll->close();

        // 根据交易类型更新 bankroll
        if ($action == 'buy') {
            // 购买操作，扣除用户资金
            $new_bankroll = $current_bankroll - $total_cost;
        } elseif ($action == 'sell') {
            // 出售操作，增加用户资金
            $new_bankroll = $current_bankroll + $total_cost;
        } else {
            throw new Exception("未知的交易操作: " . $action);
        }

        // 更新用户的 bankroll
        $sql_update_bankroll = "UPDATE buystock SET bankroll = ? WHERE UserID = ?";
        $stmt_update_bankroll = $conn->prepare($sql_update_bankroll);
        if ($stmt_update_bankroll === false) {
            throw new Exception("准备语句失败: " . $conn->error);
        }
        $stmt_update_bankroll->bind_param("ds", $new_bankroll, $userid);
        if (!$stmt_update_bankroll->execute()) {
            throw new Exception("执行语句失败: " . $stmt_update_bankroll->error);
        }
        $stmt_update_bankroll->close();

        // 插入新的交易记录，transtype 默认为 1（未交易）
        $sql_insert = "INSERT INTO buystock (userid, companyid, price, quantity, transtype, bankroll)
                       VALUES (?, ?, ?, ?, 1, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        if ($stmt_insert === false) {
            throw new Exception("准备语句失败: " . $conn->error);
        }
        $stmt_insert->bind_param("ssdid", $userid, $companyid, $price, $quantity, $new_bankroll);
        if (!$stmt_insert->execute()) {
            throw new Exception("执行语句失败: " . $stmt_insert->error);
        }
        $stmt_insert->close();

        // 提交事务
        $conn->commit();

        // 输出成功消息并重定向到原来的页面
        echo "<script>alert('交易提交成功！'); window.location.href = 'http://localhost/DB_Team12/startbootstrap-modern-business-gh-pages/index.php';</script>";
        exit; // 确保在重定向后停止执行后续代码

    } catch (Exception $e) {
        // 回滚事务并输出错误信息
        $conn->rollback();
        echo "交易失败: " . $e->getMessage();
    }
}

// 关闭数据库连接
$conn->close();
?>
