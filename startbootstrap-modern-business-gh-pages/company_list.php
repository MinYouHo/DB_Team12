<!DOCTYPE html>
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
<body class="d-flex flex-column">
    <main class="flex-shrink-0">
        <!-- Navigation-->
        <?php require 'navigation.php'; ?>
        <!-- Page Content-->
        <section class="py-5">
            <div class="container px-5 my-5">
                <div class="row gx-5">
                    <!-- Contact form-->
                    <div class="bg-light rounded-3 py-5 px-4 px-md-5 mb-5">
                        <div class="text-center mb-5">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-heart"></i></div>
                            <h1 class="fw-bolder">您追蹤的公司</h1>
                            <p class="lead fw-normal text-muted mb-0">點擊公司圖片可以得到更多資訊</p>
                        </div>
                    <!-- Comments section-->
                    <section>
                        <div class="card bg-light">
                            <div class="card-body">
                               <!-- Single comment-->
                                <?php if (isset($_SESSION['followed_companies']) && !empty($_SESSION['followed_companies'])): ?>
                                    <?php foreach ($_SESSION['followed_companies'] as $company): ?>
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <?php $myindustries = ['wood', 'Technology', 'Healthcare', 'Finance', 'Education', 'Agriculture']; ?>
                                                <?php if (in_array($company['Industry'], $myindustries)): ?>
                                                    <img class="rounded-circle" src="assets/<?php echo htmlspecialchars($company['Industry']); ?>.jpg" alt="..." style="width: 50px; height: 50px;" />
                                                <?php else:?>
                                                    <img class="rounded-circle" src="assets/company.jpg" alt="..." style="width: 50px; height: 50px;" />
                                                <?php endif;?>
                                            </div>
                                            <div class="ms-3">
                                                <li>
                                                    <span style="font-weight: bold; font-family: Arial, Helvetica, sans-serif;">公司名稱: <?php echo htmlspecialchars($company['CompanyName']); ?> </span>
                                                    <span style="font-weight: bold; font-family: Arial, Helvetica, sans-serif;">公司ID: <?php echo htmlspecialchars($company['CompanyID']); ?> </span>
                                                    <span style="font-weight: bold; font-family: Arial, Helvetica, sans-serif;">行業: <?php echo htmlspecialchars($company['Industry']); ?> </span>
                                                <button type="button" class="btn btn-danger btn-sm ms-2" onclick="deleteCompany('<?php echo htmlspecialchars($company['CompanyID']); ?>')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                                <br>
                                                </br>
                                                <br>
                                                </br>
                                                
                                                </li>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>無追蹤名單</p>
                                <?php endif; ?>

                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
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
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
<script>
function deleteCompany(companyID) {
    if (confirm('確定要刪除這個公司嗎？')) {

         console.log('刪除公司ID:', companyID);
    }
}
</script>