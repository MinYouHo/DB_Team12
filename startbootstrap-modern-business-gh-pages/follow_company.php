<?php
require 'config.php';

session_start();

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 檢查用戶角色
$user_permission = 0; // 默認角色為普通用戶
if (isset($_SESSION['userID'])) {
    $user_id = $_SESSION['userID'];
    
    echo "User ID: " . $user_id . "<br>"; // 調試信息

    // 獲取用戶追蹤的公司詳細信息
    $stmt = $conn->prepare("SELECT follow.CompanyID, company.CompanyName, company.Industry 
                            FROM follow 
                            NATURAL JOIN company 
                            WHERE follow.UserID = ?");
    if ($stmt === false) {
        die("準備語句失敗: " . $conn->error);
    }
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->bind_result($company_id, $company_name, $industry);
    $followed_companies = [];
    while ($stmt->fetch()) {
        $followed_companies[] = [
            'CompanyID' => $company_id,
            'CompanyName' => $company_name,
            'Industry' => $industry
        ];
    }
    $stmt->close();
    // 將追蹤的公司列表存儲在SESSION中
    $_SESSION['followed_companies'] = $followed_companies;

    // 印出 $followed_companies 以檢查結果
    echo "Followed Companies: <pre>";
    foreach ($followed_companies as $company) {
        echo "公司ID: " . htmlspecialchars($company['CompanyID']) . "<br>";
        echo "公司名稱: " . htmlspecialchars($company['CompanyName']) . "<br>";
        echo "行業: " . htmlspecialchars($company['Industry']) . "<br><br>";
    }
    echo "</pre>";
} else {
    echo "用戶ID未設置。";
}

$conn->close();
header('Location: company_list.php');
?>
