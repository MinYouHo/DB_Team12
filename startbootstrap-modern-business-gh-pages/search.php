<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Modern Business - Start Bootstrap Template</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body class="d-flex flex-column h-100">
    <main class="flex-shrink-0">
        <!-- Navigation-->
        <?php require 'navigation.php'; ?>
        <?php require 'config.php'; ?>

        <!-- Page Content-->
        <section class="py-5">
            <div class="container px-5 my-5">
                <div class="text-center mb-5">
                    <h1 class="fw-bolder">訂定篩選條件，我們會為您找出符合的公司</h1>
                    <div class="container">
                    <form id="stock-search-form" method="POST">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="stockCode" name="stockCode" placeholder="股票代號" value="<?php echo isset($_POST['stockCode']) ? $_POST['stockCode'] : ''; ?>">
                                    <label for="stockCode">股票代號 ID</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="companyName" name="companyName" placeholder="公司名稱" value="<?php echo isset($_POST['companyName']) ? $_POST['companyName'] : ''; ?>">
                                    <label for="companyName">公司名稱 Name</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="industry" name="industry" placeholder="產業" value="<?php echo isset($_POST['industry']) ? $_POST['industry'] : ''; ?>">
                                    <label for="industry">產業 Industry</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="quarter" name="quarter" placeholder="季度" value="<?php echo isset($_POST['quarter']) ? $_POST['quarter'] : ''; ?>">
                                    <label for="quarter">季度 Quarter</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="marketValueMin" name="marketValueMin" placeholder="最低市場價值" value="<?php echo isset($_POST['marketValueMin']) ? $_POST['marketValueMin'] : ''; ?>">
                                    <label for="marketValueMin">最低市值 Min MarketValue</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="marketValueMax" name="marketValueMax" placeholder="最高市場價值" value="<?php echo isset($_POST['marketValueMax']) ? $_POST['marketValueMax'] : ''; ?>">
                                    <label for="marketValueMax">最高市值 Max MarketValue</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="number" step="0.01" class="form-control" id="dividendMin" name="dividendMin" placeholder="最低股息" value="<?php echo isset($_POST['dividendMin']) ? $_POST['dividendMin'] : ''; ?>">
                                    <label for="dividendMin">最低股息 Min Dividend</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="number" step="0.01" class="form-control" id="dividendMax" name="dividendMax" placeholder="最高股息" value="<?php echo isset($_POST['dividendMax']) ? $_POST['dividendMax'] : ''; ?>">
                                    <label for="dividendMax">最高股息 Max Dividend</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="number" step="0.01" class="form-control" id="epsMin" name="epsMin" placeholder="最低每股盈餘" value="<?php echo isset($_POST['epsMin']) ? $_POST['epsMin'] : ''; ?>">
                                    <label for="epsMin">最低每股盈餘 Min EPS</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="number" step="0.01" class="form-control" id="epsMax" name="epsMax" placeholder="最高每股盈餘" value="<?php echo isset($_POST['epsMax']) ? $_POST['epsMax'] : ''; ?>">
                                    <label for="epsMax">最高每股盈餘 Max EPS</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="number" step="0.01" class="form-control" id="bvpsMin" name="bvpsMin" placeholder="最低每股淨值" value="<?php echo isset($_POST['bvpsMin']) ? $_POST['bvpsMin'] : ''; ?>">
                                    <label for="bvpsMin">最低每股淨值 Min BVPS</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="number" step="0.01" class="form-control" id="bvpsMax" name="bvpsMax" placeholder="最高每股淨值" value="<?php echo isset($_POST['bvpsMax']) ? $_POST['bvpsMax'] : ''; ?>">
                                    <label for="bvpsMax">最高每股淨值 Max BVPS</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="saleMin" name="saleMin" placeholder="最低銷售額" value="<?php echo isset($_POST['saleMin']) ? $_POST['saleMin'] : ''; ?>">
                                    <label for="saleMin">最低銷售額 Min Sale</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="saleMax" name="saleMax" placeholder="最高銷售額" value="<?php echo isset($_POST['saleMax']) ? $_POST['saleMax'] : ''; ?>">
                                    <label for="saleMax">最高銷售額 Max Sale</label>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="justify-content-center">
                                <button type="submit" class="btn btn-primary" style="height: 60px; font-size: 32px; width: 400px;">點 此 進 行 搜 尋</button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </section>

        <div class="container px-5 my-5">
            <div id="result">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $stockCode = $_POST['stockCode'];
                    $companyName = $_POST['companyName'];
                    $industry = $_POST['industry'];
                    $quarter = $_POST['quarter'];
                    $marketValueMin = $_POST['marketValueMin'];
                    $marketValueMax = $_POST['marketValueMax'];
                    $dividendMin = $_POST['dividendMin'];
                    $dividendMax = $_POST['dividendMax'];
                    $epsMin = $_POST['epsMin'];
                    $epsMax = $_POST['epsMax'];
                    $bvpsMin = $_POST['bvpsMin'];
                    $bvpsMax = $_POST['bvpsMax'];
                    $saleMin = $_POST['saleMin'];
                    $saleMax = $_POST['saleMax'];

                    $query = "
                        SELECT 
                            Company.CompanyID, 
                            Company.CompanyName, 
                            Company.Industry, 
                            Quarter.Quarter, 
                            Quarter.MarketValue, 
                            Quarter.Dividend, 
                            Quarter.EPS, 
                            Quarter.BVPS, 
                            Quarter.Sale 
                        FROM 
                            Company 
                        LEFT JOIN 
                            Quarter 
                        ON 
                            Company.CompanyID = Quarter.CompanyID 
                        WHERE 1=1";

                    if ($stockCode) {
                        $query .= " AND Company.CompanyID = '$stockCode'";
                    }
                    if ($quarter) {
                        $query .= " AND Quarter.Quarter = '$quarter'";
                    }
                    if ($companyName) {
                        $query .= " AND Company.CompanyName LIKE '%$companyName%'";
                    }
                    if ($industry) {
                        $query .= " AND Company.Industry LIKE '%$industry%'";
                    }
                    if ($marketValueMin) {
                        $query .= " AND Quarter.MarketValue >= $marketValueMin";
                    }
                    if ($marketValueMax) {
                        $query .= " AND Quarter.MarketValue <= $marketValueMax";
                    }
                    if ($dividendMin) {
                        $query .= " AND Quarter.Dividend >= $dividendMin";
                    }
                    if ($dividendMax) {
                        $query .= " AND Quarter.Dividend <= $dividendMax";
                    }
                    if ($epsMin) {
                        $query .= " AND Quarter.EPS >= $epsMin";
                    }
                    if ($epsMax) {
                        $query .= " AND Quarter.EPS <= $epsMax";
                    }
                    if ($bvpsMin) {
                        $query .= " AND Quarter.BVPS >= $bvpsMin";
                    }
                    if ($bvpsMax) {
                        $query .= " AND Quarter.BVPS <= $bvpsMax";
                    }
                    if ($saleMin) {
                        $query .= " AND Quarter.Sale >= $saleMin";
                    }
                    if ($saleMax) {
                        $query .= " AND Quarter.Sale <= $saleMax";
                    }

                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        echo '<table class="table table-striped">';
                        echo '<thead><tr>';
                        $fields = $result->fetch_fields();
                        foreach ($fields as $field) {
                            echo '<th>' . $field->name . '</th>';
                        }
                        echo '</tr></thead>';
                        echo '<tbody>';
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            foreach ($row as $value) {
                                echo '<td>' . $value . '</td>';
                            }
                            echo '</tr>';
                        }
                        echo '</tbody></table>';
                    } else {
                        echo '<p>沒有找到符合的資料</p>';
                    }
                }
                ?>
            </div>
        </div>
    </main>

    <!-- Footer-->
    <footer class="bg-dark py-4 mt-auto">
        <div class="container px-5">
            <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                <div class="col-auto"><div class="small m-0 text-white">Copyright &copy; Your Website 2023</div></div>
                <div class="col-auto">
                    <a class="link-light small" href="#!">Privacy</a>
                    <span class="text-white mx-1">&middot;</span>
                    <a class="link-light small" href="#!">Terms</a>
                    <span class="text-white mx-1">&middot;</span>
                    <a class="link-light small" href="#!">Contact</a>
                </div>
            </div>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>
</html>
