<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="dashboard.css">

</head>

<body>

    <div class="container-fluid">
        <div class="row min-vh-100">

            <!-- SIDEBAR -->
            <aside class="col-lg-2 col-md-3 sidebar p-4" id="sidebar">
                <div class="logo mb-4">AdminPanel</div>

                <ul class="nav flex-column gap-1">

                    <!-- Dashboard (no dropdown) -->
                    <li class="nav-item active">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-chart-line"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>


                    <!-- Users -->
                    <li class="nav-item dropdown-item">
                        <a class="nav-link dropdown-toggle" href="#">
                            <i class="fa-solid fa-user"></i>
                            <span>Users</span>
                            <i class="fa-solid fa-chevron-down arrow"></i>
                        </a>
                        <ul class="submenu">
                            <li><a href="#">All Users</a></li>
                            <li><a href="#">Add User</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown-item">
                        <a class="nav-link dropdown-toggle" href="#">
                            <i class="fa-solid fa-user"></i>
                            <span>Brands</span>
                            <i class="fa-solid fa-chevron-down arrow"></i>
                        </a>
                        <ul class="submenu">
                            <li><a href="#">Manage Brands</a></li>
                            <li><a href="#">Add Brand</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown-item">
                        <a class="nav-link dropdown-toggle" href="#">
                            <i class="fa-solid fa-user"></i>
                            <span>Category</span>
                            <i class="fa-solid fa-chevron-down arrow"></i>
                        </a>
                        <ul class="submenu">
                            <li><a href="#">Manage Category</a></li>
                            <li><a href="#">Add Category</a></li>
                        </ul>
                    </li>

                    <!-- Products -->
                    <li class="nav-item dropdown-item">
                        <a class="nav-link dropdown-toggle" href="#">
                            <i class="fa-solid fa-box"></i>
                            <span>Products</span>
                            <i class="fa-solid fa-chevron-down arrow"></i>
                        </a>
                        <ul class="submenu">
                            <li><a href="#" class="load-page" data-page="products/all-products.php">
                                    All Products
                            </a></li>

                            <li>
                                <a href="products/add.php" class="load-page" data-page="products/add.php">
                                    Add Product
                                </a>
                            </li>

                        </ul>
                    </li>

                    <!-- Orders -->
                    <li class="nav-item dropdown-item">
                        <a class="nav-link dropdown-toggle" href="#">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span>Orders</span>
                            <i class="fa-solid fa-chevron-down arrow"></i>
                        </a>
                        <ul class="submenu">
                            <li><a href="#">All Orders</a></li>
                            <li><a href="#">Pending</a></li>
                            <li><a href="#">Completed</a></li>
                        </ul>
                    </li>

                    <!-- Invoices -->
                    <li class="nav-item dropdown-item">
                        <a class="nav-link dropdown-toggle" href="#">
                            <i class="fa-solid fa-file-invoice"></i>
                            <span>Invoices</span>
                            <i class="fa-solid fa-chevron-down arrow"></i>
                        </a>
                        <ul class="submenu">
                            <li><a href="#">All Invoices</a></li>
                            <li><a href="#">Create Invoice</a></li>
                        </ul>
                    </li>

                    <!-- Settings (no dropdown) -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-gear"></i>
                            <span>Settings</span>
                        </a>
                    </li>

                </ul>
            </aside>
            <!-- TOPBAR -->
            <div class="col-lg-10 col-md-9 p-4">
                <div class="topbar d-flex justify-content-between align-items-center mb-4 ">
                    <h3 class="mb-0">Dashboard</h3>
                    <div class="d-flex align-items-center gap-3">
                        <i class="fa-regular fa-bell top-icon"></i>
                        <div class="avatar">A</div>
                    </div>

                </div>
            </div>

            <!-- MAIN -->

            <main class="col-lg-10 col-md-9 p-4 main" id="main-content">
                <!-- HERO -->
                <div class="row mb-4 mt-2">
                    <div class="col-12">
                        <div class="hero d-flex justify-content-between align-items-center">
                            <div>
                                <h4>Congratulations 🎉</h4>
                                <p class="mb-3">You achieved higher sales this month.</p>
                                <button class="btn hero-btn">View Report</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STATS -->
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="stat-card">
                            <h6>Products Sold</h6>
                            <span>765</span>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="stat-card">
                            <h6>Total Balance</h6>
                            <span>18,765</span>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="stat-card">
                            <h6>Sales Profit</h6>
                            <span>4,876</span>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mt-4">

                    <div class="col-lg-8">
                        <div class="stat-card">
                            <h6>Yearly Sales</h6>
                            <canvas id="salesChart" height="120"></canvas>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="stat-card">
                            <h6>Sales by Category</h6>
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>

                </div>



                <div class="container-fluid">
                    <div class="row g-4">

                        <!-- Sales Overview -->
                        <div class="col-lg-8">
                            <div class="card admin-card">
                                <h5 class="card-title mb-4">Sales overview</h5>

                                <div class="mb-4">
                                    <div class="d-flex justify-content-between">
                                        <span>Total profit</span>
                                        <span>$8,374 <small>(10.1%)</small></span>
                                    </div>
                                    <div class="progress admin-progress">
                                        <div class="progress-bar progress-profit" style="width:40%"></div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="d-flex justify-content-between">
                                        <span>Total income</span>
                                        <span>$9,714 <small>(13.6%)</small></span>
                                    </div>
                                    <div class="progress admin-progress">
                                        <div class="progress-bar progress-income" style="width:55%"></div>
                                    </div>
                                </div>

                                <div>
                                    <div class="d-flex justify-content-between">
                                        <span>Total expenses</span>
                                        <span>$6,871 <small>(28.2%)</small></span>
                                    </div>
                                    <div class="progress admin-progress">
                                        <div class="progress-bar progress-expense" style="width:65%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Balance -->
                        <div class="col-lg-4">
                            <div class="card admin-card">
                                <h6>Current balance</h6>
                                <h2 class="fw-bold">$187,650</h2>

                                <ul class="list-unstyled mt-3 mb-4 balance-list">
                                    <li><span>Order total</span><span>$287,650</span></li>
                                    <li><span>Earning</span><span>$25,500</span></li>
                                    <li><span>Refunded</span><span>$1,600</span></li>
                                </ul>

                                <div class="d-flex gap-2">
                                    <button class="btn btn-request w-50">Request</button>
                                    <button class="btn btn-transfer w-50">Transfer</button>
                                </div>
                            </div>
                        </div>

                        <!-- Best Salesman -->
                        <div class="col-lg-8">
                            <div class="card admin-card">
                                <h5 class="card-title">Best salesman</h5>

                                <table class="table align-middle mt-3 admin-table">
                                    <thead>
                                        <tr>
                                            <th>Seller</th>
                                            <th>Product</th>
                                            <th>Country</th>
                                            <th>Total</th>
                                            <th>Rank</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Jayvion Simon</td>
                                            <td>CAP</td>
                                            <td>🇩🇪</td>
                                            <td>$83.74</td>
                                            <td><span class="rank rank-1">Top 1</span></td>
                                        </tr>
                                        <tr>
                                            <td>Lucian Obrien</td>
                                            <td>Branded shoes</td>
                                            <td>🇬🇧</td>
                                            <td>$97.14</td>
                                            <td><span class="rank rank-2">Top 2</span></td>
                                        </tr>
                                        <tr>
                                            <td>Deja Brady</td>
                                            <td>Headphone</td>
                                            <td>🇫🇷</td>
                                            <td>$68.71</td>
                                            <td><span class="rank rank-3">Top 3</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Latest Products -->
                        <div class="col-lg-4">
                            <div class="card admin-card">
                                <h5 class="card-title">Latest products</h5>

                                <ul class="list-unstyled mt-3 product-list">
                                    <li><strong>Urban Explorer Sneakers</strong><span>$83.74</span></li>
                                    <li>
                                        <strong>Classic Leather Loafers</strong>
                                        <span class="old-price">$97.14</span>
                                        <span class="new-price">$97.14</span>
                                    </li>
                                    <li><strong>Mountain Trekking Boots</strong><span>$68.71</span></li>
                                    <li>
                                        <strong>Elegance Stiletto Heels</strong>
                                        <span class="old-price">$85.21</span>
                                        <span class="new-price">$85.21</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>




            </main>

        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const salesChart = new Chart(document.getElementById('salesChart'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Sales',
                    data: [1200, 1900, 1700, 2300, 2100, 2600],
                    borderColor: '#088178',
                    backgroundColor: 'rgba(8,129,120,0.15)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        grid: {
                            color: '#dfdfd9'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        const categoryChart = new Chart(document.getElementById('categoryChart'), {
            type: 'doughnut',
            data: {
                labels: ['T-Shirts', 'Hoodies', 'Caps'],
                datasets: [{
                    data: [45, 30, 25],
                    backgroundColor: [
                        '#f9be08',
                        '#088178',
                        '#cdb4db'
                    ]
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>

    <!-- drop down -->
    <script>
        document.querySelectorAll('.dropdown-toggle').forEach(item => {
            item.addEventListener('click', e => {
                e.preventDefault();
                const parent = item.closest('.dropdown-item');
                parent.classList.toggle('open');
            });
        });
    </script>

    <!-- <script>
        document.querySelectorAll('.load-page').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                const page = this.dataset.page;
                const mainContent = document.getElementById('main-content');

                
                mainContent.innerHTML = '<p class="text-center">Loading...</p>';

                fetch(page)
                    .then(res => res.text())
                    .then(html => {
                        mainContent.innerHTML = html;
                    })
                    .catch(err => {
                        mainContent.innerHTML = '<p class="text-danger text-center">Failed to load page</p>';
                    });
            });
        });
    </script> -->
    <script src="../assets/js/admin-dashboard.js"></script>


</body>

</html>