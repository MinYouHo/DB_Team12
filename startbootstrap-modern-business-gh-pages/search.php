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
                    <h1 class="fw-bolder">Search Your Stock</h1>
                    <div class="container">
                        <form id="stock-search-form" method="POST">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="stockCode" name="stockCode" placeholder="股票代號">
                                <label for="stockCode">股票代號</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="companyName" name="companyName" placeholder="公司名稱或產業">
                                <label for="companyName">公司名稱或產業</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="quarter" name="quarter" placeholder="季度">
                                <label for="quarter">季度</label>
                            </div>
                            <button type="submit" class="btn btn-primary">搜尋</button>
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
                    $quarter = $_POST['quarter'];

                    $query = '';

                    if ($stockCode && $quarter) {
                        $query = "SELECT Quarter.CompanyID, Quarter.Quarter, Quarter.MarketValue, Quarter.Dividend, Quarter.EPS, Quarter.BVPS, Quarter.Sale FROM Quarter WHERE Quarter.CompanyID = '$stockCode' AND Quarter.Quarter = '$quarter'";
                    } elseif ($stockCode) {
                        $query = "SELECT Quarter.CompanyID, Quarter.Quarter, Quarter.MarketValue, Quarter.Dividend, Quarter.EPS, Quarter.BVPS, Quarter.Sale FROM Quarter WHERE Quarter.CompanyID = '$stockCode'";
                    } elseif ($companyName) {
                        $query = "SELECT Company.CompanyID, Company.CompanyName, Company.Industry, Quarter.Quarter, Quarter.MarketValue, Quarter.Dividend, Quarter.EPS, Quarter.BVPS, Quarter.Sale FROM Company LEFT JOIN Quarter ON Company.CompanyID = Quarter.CompanyID WHERE Company.CompanyName = '$companyName' OR Company.Industry = '$companyName'";
                    } else {
                        echo '<p>請輸入搜尋條件</p>';
                        return;
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
