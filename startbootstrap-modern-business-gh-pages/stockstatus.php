<?php
session_start();

define('DB_SERVER', "140.122.184.129:3310");
define('DB_USERNAME', 'team12');
define('DB_PASSWORD', 'SM(tFcLC*Ma0(N(E');
define('DB_DATABASE', 'team12');

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 開始查詢用戶的交易記錄
if (!isset($_SESSION['userID'])) {
    die("用戶未登入");
}
$userid = $_SESSION['userID'];

$sql = "SELECT companyid, price, transaction_time, 
               CASE 
                   WHEN transtype = 1 THEN '尚未成交' 
                   WHEN transtype = 100 THEN '交易成功'
                   ELSE '未知狀態' 
               END AS transaction_status
        FROM buystock
        WHERE userid = ?
        ORDER BY transaction_time DESC";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("準備語句失敗: " . $conn->error);
}

$stmt->bind_param("s", $userid);
$stmt->execute();
$result = $stmt->get_result();

// 輸出表格
echo '<table class="table">';

while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['companyid']) . '</td>';
    echo '<td>' . htmlspecialchars($row['price']) . '</td>';
    echo '<td>' . htmlspecialchars($row['transaction_time']) . '</td>';
    echo '<td>' . htmlspecialchars($row['transaction_status']) . '</td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';

$stmt->close();
$conn->close();
?>
