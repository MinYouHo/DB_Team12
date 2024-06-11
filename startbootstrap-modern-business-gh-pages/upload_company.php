<?php
require 'config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $companyID = $_POST['CompanyID'];
    $companyName = $_POST['CompanyName'];
    $industry = $_POST['Industry'];
    $quarter = $_POST['Quarter'];
    $marketValue = $_POST['MarketValue'];
    $dividend = $_POST['Dividend'];
    $eps = $_POST['EPS'];
    $bvps = $_POST['BVPS'];
    $sale = $_POST['Sale'];

    // Validate quarter format
    if (!preg_match('/^\d{4}-Q[1-4]$/', $quarter)) {
        die("Invalid quarter format. Please use 'YYYY-QN', e.g., '2023-Q2'.");
    }

    $companyInserted = true;
    $quarterInserted = true;

    // If CompanyName and Industry are not empty, insert into company table
    if (!empty($companyName) && !empty($industry)) {
        $sql = "INSERT INTO company (CompanyID, CompanyName, Industry)
                VALUES ('$companyID', '$companyName', '$industry')";

        if ($conn->query($sql) === TRUE) {
            $companyInserted = true;
        } else {
            $companyInserted = false;
            $companyError = $conn->error;
        }
    }

    // Insert into quarter table
    $sql2 = "INSERT INTO quarter (CompanyID, Quarter, MarketValue, Dividend, EPS, BVPS, Sale)
             VALUES ('$companyID', '$quarter', '$marketValue', '$dividend', '$eps', '$bvps', '$sale')";

    if ($conn->query($sql2) === TRUE) {
        $quarterInserted = true;
    } else {
        $quarterInserted = false;
        $quarterError = $conn->error;
    }

    // Display the result and redirect
    if ($companyInserted && $quarterInserted) {
        echo "<div style='text-align: center; margin-top: 20px;'>
                <h2>新公司和季度資料創建成功！</h2>
                <p>3秒後重定向到首頁...</p>
              </div>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 3000);
              </script>";
    } elseif ($quarterInserted) {
        echo "<div style='text-align: center; margin-top: 20px;'>
                <h2>季度資料新增成功！</h2>
                <p>3秒後重定向到首頁...</p>
              </div>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 3000);
              </script>";
    } else {
        echo "<div style='text-align: center; margin-top: 20px;'>
                <h2>創建失敗</h2>";
        if (!$companyInserted && !empty($companyName) && !empty($industry)) {
            echo "<p>公司資料錯誤: " . $companyError . "</p>";
        }
        if (!$quarterInserted) {
            echo "<p>季度資料錯誤: " . $quarterError . "</p>";
        }
        echo "</div>";
    }

    $conn->close();
}
?>
