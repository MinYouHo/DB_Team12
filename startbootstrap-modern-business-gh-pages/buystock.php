<?php
session_start();

// 資料庫連接
define('DB_SERVER', "140.122.184.129:3310");
define('DB_USERNAME', 'team12');
define('DB_PASSWORD', 'SM(tFcLC*Ma0(N(E');
define('DB_DATABASE', 'team12');

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// 連接成功
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 交表單數據
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['userID'])) {
        die("用戶未登入");
    }
    $userid = $_SESSION['userID'];
    $companyid = $_POST['stockCode']; 
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $action = $_POST['action']; 
    // 'buy' 或 'sell'

    $sql_check_user = "SELECT COUNT(*) as count FROM User WHERE UserID = ?";
    $stmt_check_user = $conn->prepare($sql_check_user);
    if ($stmt_check_user === false) {
        die("準備語句失敗: " . $conn->error);
    }
    $stmt_check_user->bind_param("s", $userid);
    $stmt_check_user->execute();
    $result_check_user = $stmt_check_user->get_result();
    $user_exists = $result_check_user->fetch_assoc()['count'] > 0;
    $stmt_check_user->close();

    if (!$user_exists) {
        die("交易失敗: 用戶id不存在.");
    }

    // 檢查 companyid 是否在 company 表中存在
    $sql_check_company = "SELECT COUNT(*) as count FROM company WHERE CompanyID = ?";
    $stmt_check_company = $conn->prepare($sql_check_company);
    if ($stmt_check_company === false) {
        die("準備語句失敗: " . $conn->error);
    }
    $stmt_check_company->bind_param("s", $companyid);
    $stmt_check_company->execute();
    $result_check_company = $stmt_check_company->get_result();
    $company_exists = $result_check_company->fetch_assoc()['count'] > 0;
    $stmt_check_company->close();

    if (!$company_exists) {
        die("交易失敗: 公司id不存在.");
    }
    /////////////////////////////////////
    $conn->begin_transaction();

    try {
        $total_cost = $price * $quantity;

        // 用戶當前 bankroll
        $sql_get_bankroll = "SELECT bankroll FROM buystock WHERE UserID = ?";
        $stmt_get_bankroll = $conn->prepare($sql_get_bankroll);
        if ($stmt_get_bankroll === false) {
            throw new Exception("準備語句失敗: " . $conn->error);
        }
        $stmt_get_bankroll->bind_param("s", $userid);
        $stmt_get_bankroll->execute();
        $result_get_bankroll = $stmt_get_bankroll->get_result();
        if ($result_get_bankroll->num_rows == 0) {
            throw new Exception("交易失敗: 找不到用戶的 bankroll 紀錄.");
        }
        $row = $result_get_bankroll->fetch_assoc();
        $current_bankroll = $row['bankroll'];
        $stmt_get_bankroll->close();

        /////////////////////////
        if ($action == 'buy') {
            $new_bankroll = $current_bankroll - $total_cost;
        } elseif ($action == 'sell') {
            $new_bankroll = $current_bankroll + $total_cost;
        } else {
            throw new Exception("未知的交易操作: " . $action);
        }

        // 更新用戶 bankroll
        $sql_update_bankroll = "UPDATE buystock SET bankroll = ? WHERE UserID = ?";
        $stmt_update_bankroll = $conn->prepare($sql_update_bankroll);
        if ($stmt_update_bankroll === false) {
            throw new Exception("準備語句失敗: " . $conn->error);
        }
        $stmt_update_bankroll->bind_param("ds", $new_bankroll, $userid);
        if (!$stmt_update_bankroll->execute()) {
            throw new Exception("準備語句失敗: " . $stmt_update_bankroll->error);
        }
        $stmt_update_bankroll->close();

        // transtype 為 1（未交易）
        $sql_insert = "INSERT INTO buystock (userid, companyid, price, quantity, transtype, bankroll)
                       VALUES (?, ?, ?, ?, 1, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        if ($stmt_insert === false) {
            throw new Exception("準備語句失敗: " . $conn->error);
        }
        $stmt_insert->bind_param("ssdid", $userid, $companyid, $price, $quantity, $new_bankroll);
        if (!$stmt_insert->execute()) {
            throw new Exception("準備語句失敗: " . $stmt_insert->error);
        }
        $stmt_insert->close();

        $conn->commit();

        echo "<script>alert('交易提交成功'); window.location.href = 'http://localhost/DB_Team12/startbootstrap-modern-business-gh-pages/index.php';</script>";
        exit; 

    } catch (Exception $e) {
        $conn->rollback();
        echo "交易失敗: " . $e->getMessage();
    }
}

$conn->close();
?>
