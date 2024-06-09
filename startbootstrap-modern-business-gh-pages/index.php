<!DOCTYPE html>
<?php session_start(); ?>
<?php require 'config.php'; ?>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>股票管理系統</title>
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
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-5">
                <div class="row gx-5 align-items-center justify-content-center">
                    <div class="col-lg-8 col-xl-7 col-xxl-6">
                        <div class="my-5 text-center text-xl-start">
                            <h1 class="display-5 fw-bolder text-white mb-2">股票管理系統</h1>
                            <p class="lead fw-normal text-white-50 mb-4">輕鬆管理您的股票投資，提供最新的市場資訊與投資分析工具。</p>
                            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                                <a class="btn btn-outline-light btn-lg px-4" href="#features">Get Started</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center"><img class="img-fluid rounded-3 my-5" src="assets/MainPage_figure.png" alt="..." /></div>
                </div>
            </div>
        </header>
        <!-- Page Content-->
        <section class="py-5">
            <div class="container px-5">
                <div class="card border-0 shadow rounded-3 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="row gx-0">
                            <div class="col-lg-6 col-xl-5 py-lg-5">
                                <div class="p-4 p-md-5">
                                    <div class="badge bg-primary bg-gradient rounded-pill mb-2">最新</div>
                                    <div class="h2 fw-bolder">管理員公告</div>
                                    <?php
                                    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
                                    $sql = "SELECT content FROM board";
                                    $result = $conn->query($sql);
                
                                    if ($result->num_rows > 0) {
                                        // 輸出每一行的數據
                                        while($row = $result->fetch_assoc()) {
                                            echo "" . $row["content"]. "<br>";
                                        }
                                    } else {
                                        echo "0 results";
                                    }
                                    $conn->close();
                                    ?>
                                    <?php if(isset($_SESSION['permission']) && $_SESSION['permission']): ?>
                                        <a class="stretched-link text-decoration-none" href="#!">
                                            修改
                                            <i class="bi bi-arrow-right"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center"><img class="img-fluid rounded-3 my-5" src="assets/board.jpg" alt="..." /></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Features section-->
        <section class="py-5" id="features">
            <div class="container px-5 my-5">
                <div class="row gx-5">
                    <div class="col-lg-4 mb-5 mb-lg-0"><h2 class="fw-bolder mb-0">開始使用我們的功能.</h2></div>
                    <div class="col-lg-8">
                        <div class="row gx-5 row-cols-1 row-cols-md-2">
                            <div class="col mb-5 h-100">
                                <a class="navbar-brand" href="MainPage.html" >
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-search"></i></div>
                                    <h2 class="fw-bolder mb-0">搜尋股票</h2>
                                    <p class="mb-0">使用我們的系統快速找尋到您想要股票資料</p>
                                </a>
                            </div>
                            <div class="col mb-5 h-100">
                                <a class="navbar-brand" href="MainPage.html" >
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-collection"></i></div>
                                    <h2 class="fw-bolder mb-0">個人追蹤清單</h2>
                                    <p class="mb-0">使用我們的系統關注您追蹤的股票</p>
                                </a>
                            </div>
                            <div class="col mb-5 mb-md-0 h-100">
                                <a class="navbar-brand" href="MainPage.html" >
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-gear"></i></div>
                                    <h2 class="fw-bolder mb-0">修改個人資料</h2>
                                    <p class="mb-0">修改您個人資料，方便我們了解您的資訊</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Testimonial section-->
        <div class="py-5 bg-light">
            <div class="container px-5 my-5">
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-10 col-xl-7">
                        <div class="text-center">
                            <div class="fs-4 mb-4 fst-italic">"使用我們的查詢股票系統讓我在管理自己股票資產時節省大量時間！從這個系統開始，讓股票管理變得更加簡單高效！"</div>
                            <div class="d-flex align-items-center justify-content-center">
                                <img class="rounded-circle me-3" src="https://dummyimage.com/40x40/ced4da/6c757d" alt="..." /> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
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
