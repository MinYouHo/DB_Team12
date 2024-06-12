<!DOCTYPE html>
<?php session_start(); ?>
<?php require 'config.php'; ?>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Company information</title>
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
                                <h1 class="display-5 fw-bolder text-white mb-2">公司資訊</h1>
                                <?php $companyID = htmlspecialchars($_GET['CompanyID']);?>
                                <?php $companyName = htmlspecialchars($_GET['CompanyName']);?>
                                <?php $Industry = htmlspecialchars($_GET['Industry']);?>
                                <?php if(isset($companyID) &&$companyID): ?>
                                    <h1 class="display-5 fw-bolder text-white mb-2"><?php echo htmlspecialchars($companyName); ?></h1>
                                <?php else: ?>
                                <h1 class="display-5 fw-bolder text-white mb-2">查詢錯誤</h1>
                                <?php endif; ?>
                                <p class="lead fw-normal text-white-50 mb-4">讓您更快了解公司營運狀況</p>
                            </div>
                        </div>
                        <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center"><img class="img-fluid rounded-3 my-5" src="assets/<?php echo htmlspecialchars($Industry); ?>.jpg" alt="..." /></div>
                    </div>
                </div>
            </header>
            <!-- Page Content-->
            <section class="py-5">
                <div class="container px-5 my-5">
                            <!-- FAQ Accordion 1-->
                            <h2 class="fw-bolder mb-3">重要指標</h2>
                            <div class="accordion mb-5" id="accordionExample">
                                <div class="accordion-item">
                                    <h3 class="accordion-header" id="headingOne"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">EPS(每股盈餘)</button></h3>
                                    <div class="accordion-collapse collapse show" id="collapseOne" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        
                              <!-- 第一章圖 -->
                              <?php $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
                              $stmt = $conn->prepare("SELECT Quarter,EPS FROM quarter WHERE CompanyID = ?");
                              $stmt->bind_param("s", $companyID);   
                              $stmt->execute();
                              $stmt->bind_result($quarter, $EPS);
                              $companies_metrics = [];
                              while ($stmt->fetch()) {
                                $companies_metrics[] = [
                                    'Quarter' => $quarter,
                                    'EPS' => $EPS,
                                ];
                            }
                            $stmt->close();
                            $conn->close();
                            $metrics_json = json_encode($companies_metrics);
                              ?>
                            <!DOCTYPE html>
                            <html>
                            <head>
                                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                            </head>
                            <body>
                                <canvas id="quarterEPSChart1" width="400" height="200"></canvas> <!-- 修改這個 canvas 的 id -->
                                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
                                                                    
                                <script>
                                // 從 PHP 獲取數據
                                var metrics = <?php echo $metrics_json; ?>;
                                                                    
                                // 提取 Quarter 和 EPS 數據
                                var quarters = metrics.map(function(metric) { return metric.Quarter; });
                                var epsValues = metrics.map(function(metric) { return metric.EPS; });
                                                                    
                                // 配置 Chart.js 圖表
                                var ctx1 = document.getElementById('quarterEPSChart1').getContext('2d');
                                var quarterEPSChart1 = new Chart(ctx1, {
                                    type: 'line',
                                    data: {
                                        labels: quarters,
                                        datasets: [{
                                            label: 'EPS',
                                            data: epsValues,
                                            borderColor: 'rgba(255, 165, 0, 1)',  // 設置為橘色
                                            borderWidth: 3,  // 設置線條粗細
                                            fill: false,
                                            pointBackgroundColor: 'rgba(255, 165, 0, 1)' // 設置數據點顏色
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            x: {
                                                title: {
                                                    display: true,
                                                    text: 'Quarter',
                                                    font: {
                                                        size: 14,  // X軸標題字體大小
                                                        weight: 'bold'  // X軸標題字體設置為粗體
                                                    }
                                                },
                                                ticks: {
                                                    font: {
                                                        size: 12,  // X軸刻度字體大小
                                                        weight: 'bold'  // X軸刻度字體設置為粗體
                                                    }
                                                },
                                                offset: true  // 在X軸兩側增加空白
                                            },
                                            y: {
                                                title: {
                                                    display: true,
                                                    text: 'EPS',
                                                    font: {
                                                        size: 14,  // Y軸標題字體大小
                                                        weight: 'bold'  // Y軸標題字體設置為粗體
                                                    }
                                                },
                                                ticks: {
                                                    font: {
                                                        size: 12,  // Y軸刻度字體大小
                                                        weight: 'bold'  // Y軸刻度字體設置為粗體
                                                    }
                                                },
                                                beginAtZero: true,  // Y軸從0開始
                                                offset: true  // 在Y軸兩側增加空白
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                labels: {
                                                    font: {
                                                        size: 14,  // 圖例字體大小
                                                        weight: 'bold'  // 圖例字體設置為粗體
                                                    }
                                                }
                                            },
                                            datalabels: {
                                                align: 'end',
                                                anchor: 'end',
                                                backgroundColor: 'rgba(255, 255, 255, 0.8)', // 白色背景帶透明度
                                                borderColor: 'rgba(255, 165, 0, 1)',  // 邊框顏色設置為橘色
                                                borderRadius: 4,
                                                borderWidth: 1,
                                                font: {
                                                    size: 12,  // 數據標籤字體大小
                                                    weight: 'bold'
                                                },
                                                formatter: function(value, context) {
                                                    return 'Q: ' + context.chart.data.labels[context.dataIndex] + '\nEPS: ' + value;
                                                }
                                            }
                                        }
                                    },
                                    plugins: [ChartDataLabels]
                                });
                                </script>
                            </body>
                            </html>
                            </div>
                                </div>
                                <div class="accordion-item">
                                    <h3 class="accordion-header" id="headingTwo"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">MarketValue(市值)</button></h3>
                                    <div class="accordion-collapse collapse" id="collapseTwo" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <!-- 第二章圖 -->
                                    <?php $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
                                              $stmt = $conn->prepare("SELECT Quarter,MarketValue FROM quarter WHERE CompanyID = ?");
                                              $stmt->bind_param("s", $companyID);   
                                              $stmt->execute();
                                              $stmt->bind_result($quarter, $EPS);
                                              $companies_metrics = [];
                                              while ($stmt->fetch()) {
                                                $companies_metrics[] = [
                                                    'Quarter' => $quarter,
                                                    'EPS' => $EPS,
                                                ];
                                            }
                                            $stmt->close();
                                            $conn->close();
                                            $metrics_json_markey = json_encode($companies_metrics);
                                              ?>
                                    <!DOCTYPE html>
                                    <html>
                                    <head>
                                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                    </head>
                                    <body>
                                        
                                        <canvas id="quarterEPSChart2" width="400" height="200"></canvas> <!-- 這是新增的 canvas，用來顯示第二個圖表 -->
                                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
                                        
                                        <script>
                                        // 從 PHP 獲取數據
                                        var metrics = <?php echo $metrics_json_markey; ?>;
                                        
                                        // 提取 Quarter 和 EPS 數據
                                        var quarters = metrics.map(function(metric) { return metric.Quarter; });
                                        var epsValues = metrics.map(function(metric) { return metric.EPS; });
                                        var ctx2 = document.getElementById('quarterEPSChart2').getContext('2d');
                                        var quarterEPSChart2 = new Chart(ctx2, {
                                            type: 'line',
                                            data: {
                                                labels: quarters,
                                                datasets: [{
                                                    label: 'MarketValue',
                                                    data: epsValues,
                                                    borderColor: 'rgba(255, 0, 0, 1)',  // 設置為紅色
                                                    borderWidth: 3,  // 設置線條粗細
                                                    fill: false,
                                                    pointBackgroundColor: 'rgba(255, 0, 0, 1)' // 設置數據點顏色
                                                }]
                                            },
                                            options: {
                                                scales: {
                                                    x: {
                                                        title: {
                                                            display: true,
                                                            text: 'Quarter',
                                                            font: {
                                                                size: 14,  // X軸標題字體大小
                                                                weight: 'bold'  // X軸標題字體設置為粗體
                                                            }
                                                        },
                                                        ticks: {
                                                            font: {
                                                                size: 12,  // X軸刻度字體大小
                                                                weight: 'bold'  // X軸刻度字體設置為粗體
                                                            }
                                                        },
                                                        offset: true  // 在X軸兩側增加空白
                                                    },
                                                    y: {
                                                        title: {
                                                            display: true,
                                                            text: 'MarketValue',
                                                            font: {
                                                                size: 14,  // Y軸標題字體大小
                                                                weight: 'bold'  // Y軸標題字體設置為粗體
                                                            }
                                                        },
                                                        ticks: {
                                                            font: {
                                                                size: 12,  // Y軸刻度字體大小
                                                                weight: 'bold'  // Y軸刻度字體設置為粗體
                                                            }
                                                        },
                                                        beginAtZero: true,  // Y軸從0開始
                                                        offset: true  // 在Y軸兩側增加空白
                                                    }
                                                },
                                                plugins: {
                                                    legend: {
                                                        labels: {
                                                            font: {
                                                                size: 14,  // 圖例字體大小
                                                                weight: 'bold'  // 圖例字體設置為粗體
                                                            }
                                                        }
                                                    },
                                                    datalabels: {
                                                        align: 'end',
                                                        anchor: 'end',
                                                        backgroundColor: 'rgba(255, 255, 255, 0.8)', // 白色背景帶透明度
                                                        borderColor: 'rgba(255, 0, 0, 1)',  // 邊框顏色設置為紅色
                                                        borderRadius: 4,
                                                        borderWidth: 1,
                                                        font: {
                                                            size: 12,  // 數據標籤字體大小
                                                            weight: 'bold'
                                                        },
                                                        formatter: function(value, context) {
                                                            return 'Q: ' + context.chart.data.labels[context.dataIndex] + '\nMarketValue: ' + value;
                                                        }
                                                    }
                                                }
                                            },
                                            plugins: [ChartDataLabels]
                                        });
                                        </script>
                                    </body>
                                    </html>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h3 class="accordion-header" id="headingThree"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Dividend(股利)</button></h3>
                                    <div class="accordion-collapse collapse" id="collapseThree" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <!-- 第三張圖 -->
                                    <?php $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
                                              $stmt = $conn->prepare("SELECT Quarter,Dividend FROM quarter WHERE CompanyID = ?");
                                              $stmt->bind_param("s", $companyID);   
                                              $stmt->execute();
                                              $stmt->bind_result($quarter, $EPS);
                                              $companies_metrics = [];
                                              while ($stmt->fetch()) {
                                                $companies_metrics[] = [
                                                    'Quarter' => $quarter,
                                                    'EPS' => $EPS,
                                                ];
                                            }
                                            $stmt->close();
                                            $conn->close();
                                            $metrics_json_Dividend = json_encode($companies_metrics);
                                              ?>
                                    <!DOCTYPE html>
                            <html>
                            <head>
                                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                            </head>
                            <body>
                                <canvas id="quarterEPSChart3" width="400" height="200"></canvas> <!-- 修改這個 canvas 的 id -->
                                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
                                                                    
                                <script>
                                // 從 PHP 獲取數據
                                var metrics = <?php echo $metrics_json_Dividend; ?>;
                                                                    
                                // 提取 Quarter 和 EPS 數據
                                var quarters = metrics.map(function(metric) { return metric.Quarter; });
                                var epsValues = metrics.map(function(metric) { return metric.EPS; });
                                                                    
                                // 配置 Chart.js 圖表
                                var ctx1 = document.getElementById('quarterEPSChart3').getContext('2d');
                                var quarterEPSChart1 = new Chart(ctx1, {
                                    type: 'line',
                                    data: {
                                        labels: quarters,
                                        datasets: [{
                                            label: 'Dividend',
                                            data: epsValues,
                                            borderColor: 'rgba(0, 128, 0, 1)', 
                                            borderWidth: 3,  // 設置線條粗細
                                            fill: false,
                                            pointBackgroundColor: 'rgba(0, 128, 0, 1)' // 設置數據點顏色
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            x: {
                                                title: {
                                                    display: true,
                                                    text: 'Quarter',
                                                    font: {
                                                        size: 14,  // X軸標題字體大小
                                                        weight: 'bold'  // X軸標題字體設置為粗體
                                                    }
                                                },
                                                ticks: {
                                                    font: {
                                                        size: 12,  // X軸刻度字體大小
                                                        weight: 'bold'  // X軸刻度字體設置為粗體
                                                    }
                                                },
                                                offset: true  // 在X軸兩側增加空白
                                            },
                                            y: {
                                                title: {
                                                    display: true,
                                                    text: 'Dividend',
                                                    font: {
                                                        size: 14,  // Y軸標題字體大小
                                                        weight: 'bold'  // Y軸標題字體設置為粗體
                                                    }
                                                },
                                                ticks: {
                                                    font: {
                                                        size: 12,  // Y軸刻度字體大小
                                                        weight: 'bold'  // Y軸刻度字體設置為粗體
                                                    }
                                                },
                                                beginAtZero: true,  // Y軸從0開始
                                                offset: true  // 在Y軸兩側增加空白
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                labels: {
                                                    font: {
                                                        size: 14,  // 圖例字體大小
                                                        weight: 'bold'  // 圖例字體設置為粗體
                                                    }
                                                }
                                            },
                                            datalabels: {
                                                align: 'end',
                                                anchor: 'end',
                                                backgroundColor: 'rgba(255, 255, 255, 0.8)', // 白色背景帶透明度
                                                borderColor: 'rgba(255, 165, 0, 1)',  // 邊框顏色設置為橘色
                                                borderRadius: 4,
                                                borderWidth: 1,
                                                font: {
                                                    size: 12,  // 數據標籤字體大小
                                                    weight: 'bold'
                                                },
                                                formatter: function(value, context) {
                                                    return 'Q: ' + context.chart.data.labels[context.dataIndex] + '\nDividend: ' + value;
                                                }
                                            }
                                        }
                                    },
                                    plugins: [ChartDataLabels]
                                });
                                </script>
                            </body>
                            </html>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h3 class="accordion-header" id="headingFour"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">BVPS(每股淨值)</button></h3>
                                    <div class="accordion-collapse collapse" id="collapseFour" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                    <!-- 第四張圖 -->
                                    <?php $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
                                              $stmt = $conn->prepare("SELECT Quarter,BVPS FROM quarter WHERE CompanyID = ?");
                                              $stmt->bind_param("s", $companyID);   
                                              $stmt->execute();
                                              $stmt->bind_result($quarter, $EPS);
                                              $companies_metrics = [];
                                              while ($stmt->fetch()) {
                                                $companies_metrics[] = [
                                                    'Quarter' => $quarter,
                                                    'EPS' => $EPS,
                                                ];
                                            }
                                            $stmt->close();
                                            $conn->close();
                                            $metrics_json_BVPS = json_encode($companies_metrics);
                                              ?>
                                    <!DOCTYPE html>
                            <html>
                            <head>
                                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                            </head>
                            <body>
                                <canvas id="quarterEPSChart4" width="400" height="200"></canvas> <!-- 修改這個 canvas 的 id -->
                                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
                                                                    
                                <script>
                                // 從 PHP 獲取數據
                                var metrics = <?php echo $metrics_json_BVPS; ?>;
                                                                    
                                // 提取 Quarter 和 EPS 數據
                                var quarters = metrics.map(function(metric) { return metric.Quarter; });
                                var epsValues = metrics.map(function(metric) { return metric.EPS; });
                                                                    
                                // 配置 Chart.js 圖表
                                var ctx1 = document.getElementById('quarterEPSChart4').getContext('2d');
                                var quarterEPSChart1 = new Chart(ctx1, {
                                    type: 'line',
                                    data: {
                                        labels: quarters,
                                        datasets: [{
                                            label: 'BVPS',
                                            data: epsValues,
                                            borderColor: 'rgba(0,0, 128, 1)',  // 設置為橘色
                                            borderWidth: 3,  // 設置線條粗細
                                            fill: false,
                                            pointBackgroundColor: 'rgba(0,0, 128, 1)' // 設置數據點顏色
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            x: {
                                                title: {
                                                    display: true,
                                                    text: 'Quarter',
                                                    font: {
                                                        size: 14,  // X軸標題字體大小
                                                        weight: 'bold'  // X軸標題字體設置為粗體
                                                    }
                                                },
                                                ticks: {
                                                    font: {
                                                        size: 12,  // X軸刻度字體大小
                                                        weight: 'bold'  // X軸刻度字體設置為粗體
                                                    }
                                                },
                                                offset: true  // 在X軸兩側增加空白
                                            },
                                            y: {
                                                title: {
                                                    display: true,
                                                    text: 'BVPS',
                                                    font: {
                                                        size: 14,  // Y軸標題字體大小
                                                        weight: 'bold'  // Y軸標題字體設置為粗體
                                                    }
                                                },
                                                ticks: {
                                                    font: {
                                                        size: 12,  // Y軸刻度字體大小
                                                        weight: 'bold'  // Y軸刻度字體設置為粗體
                                                    }
                                                },
                                                beginAtZero: true,  // Y軸從0開始
                                                offset: true  // 在Y軸兩側增加空白
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                labels: {
                                                    font: {
                                                        size: 14,  // 圖例字體大小
                                                        weight: 'bold'  // 圖例字體設置為粗體
                                                    }
                                                }
                                            },
                                            datalabels: {
                                                align: 'end',
                                                anchor: 'end',
                                                backgroundColor: 'rgba(255, 255, 255, 0.8)', // 白色背景帶透明度
                                                borderColor: 'rgba(255, 165, 0, 1)',  // 邊框顏色設置為橘色
                                                borderRadius: 4,
                                                borderWidth: 1,
                                                font: {
                                                    size: 12,  // 數據標籤字體大小
                                                    weight: 'bold'
                                                },
                                                formatter: function(value, context) {
                                                    return 'Q: ' + context.chart.data.labels[context.dataIndex] + '\nBVPS: ' + value;
                                                }
                                            }
                                        }
                                    },
                                    plugins: [ChartDataLabels]
                                });
                                </script>
                            </body>
                            </html>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h3 class="accordion-header" id="headingfive"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefive" aria-expanded="false" aria-controls="collapsefive">Sale(營收)</button></h3>
                                    <div class="accordion-collapse collapse" id="collapsefive" aria-labelledby="headingfive" data-bs-parent="#accordionExample">
                                    <!-- 第五張圖 -->
                                    <?php $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
                                              $stmt = $conn->prepare("SELECT Quarter,Sale FROM quarter WHERE CompanyID = ?");
                                              $stmt->bind_param("s", $companyID);   
                                              $stmt->execute();
                                              $stmt->bind_result($quarter, $EPS);
                                              $companies_metrics = [];
                                              while ($stmt->fetch()) {
                                                $companies_metrics[] = [
                                                    'Quarter' => $quarter,
                                                    'EPS' => $EPS,
                                                ];
                                            }
                                            $stmt->close();
                                            $conn->close();
                                            $metrics_json_Sale = json_encode($companies_metrics);
                                              ?>
                                    <!DOCTYPE html>
                            <html>
                            <head>
                                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                            </head>
                            <body>
                                <canvas id="quarterEPSChart5" width="400" height="200"></canvas> <!-- 修改這個 canvas 的 id -->
                                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
                                                                    
                                <script>
                                // 從 PHP 獲取數據
                                var metrics = <?php echo $metrics_json_Sale; ?>;
                                                                    
                                // 提取 Quarter 和 EPS 數據
                                var quarters = metrics.map(function(metric) { return metric.Quarter; });
                                var epsValues = metrics.map(function(metric) { return metric.EPS; });
                                                                    
                                // 配置 Chart.js 圖表
                                var ctx1 = document.getElementById('quarterEPSChart5').getContext('2d');
                                var quarterEPSChart1 = new Chart(ctx1, {
                                    type: 'line',
                                    data: {
                                        labels: quarters,
                                        datasets: [{
                                            label: 'Sale',
                                            data: epsValues,
                                            borderColor: 'rgba(128, 0, 128, 1)',
                                            borderWidth: 3,  // 設置線條粗細
                                            fill: false,
                                            pointBackgroundColor: 'rgba(128, 0, 128, 1)' // 設置數據點顏色
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            x: {
                                                title: {
                                                    display: true,
                                                    text: 'Quarter',
                                                    font: {
                                                        size: 14,  // X軸標題字體大小
                                                        weight: 'bold'  // X軸標題字體設置為粗體
                                                    }
                                                },
                                                ticks: {
                                                    font: {
                                                        size: 12,  // X軸刻度字體大小
                                                        weight: 'bold'  // X軸刻度字體設置為粗體
                                                    }
                                                },
                                                offset: true  // 在X軸兩側增加空白
                                            },
                                            y: {
                                                title: {
                                                    display: true,
                                                    text: 'Sale',
                                                    font: {
                                                        size: 14,  // Y軸標題字體大小
                                                        weight: 'bold'  // Y軸標題字體設置為粗體
                                                    }
                                                },
                                                ticks: {
                                                    font: {
                                                        size: 12,  // Y軸刻度字體大小
                                                        weight: 'bold'  // Y軸刻度字體設置為粗體
                                                    }
                                                },
                                                beginAtZero: true,  // Y軸從0開始
                                                offset: true  // 在Y軸兩側增加空白
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                labels: {
                                                    font: {
                                                        size: 14,  // 圖例字體大小
                                                        weight: 'bold'  // 圖例字體設置為粗體
                                                    }
                                                }
                                            },
                                            datalabels: {
                                                align: 'end',
                                                anchor: 'end',
                                                backgroundColor: 'rgba(255, 255, 255, 0.8)', // 白色背景帶透明度
                                                borderColor: 'rgba(255, 165, 0, 1)',  // 邊框顏色設置為橘色
                                                borderRadius: 4,
                                                borderWidth: 1,
                                                font: {
                                                    size: 12,  // 數據標籤字體大小
                                                    weight: 'bold'
                                                },
                                                formatter: function(value, context) {
                                                    return 'Q: ' + context.chart.data.labels[context.dataIndex] + '\nSale: ' + value;
                                                }
                                            }
                                        }
                                    },
                                    plugins: [ChartDataLabels]
                                });
                                </script>
                            </body>
                            </html>
                                    </div>
                                </div>
                            </div>

                        </div>
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
            </div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
