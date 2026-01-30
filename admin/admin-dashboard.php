<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Panda Admin Dashboard</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f5f6fa;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: #111827;
        }

        .sidebar a {
            color: #cbd5e1;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
        }

        .sidebar a:hover {
            background: #1f2933;
            color: #fff;
        }

        .sidebar .active {
            background: #2563eb;
            color: #fff;
        }

        .card-icon {
            font-size: 30px;
        }

        @media(max-width:768px) {
            .sidebar {
                position: fixed;
                left: -250px;
                top: 0;
                z-index: 1000;
                transition: 0.3s;
            }

            .sidebar.show {
                left: 0;
            }
        }

        /* Reset */
        li {
            list-style: none;
        }

        /* Main menu link */
        li>a {
            display: block;
            padding: 14px 18px;
            color: #e5e7eb;
            text-decoration: none;
            background: #0f172a;
            cursor: pointer;
        }

        /* Hover */
        li>a:hover {
            background: #1e293b;
            color: #38bdf8;
        }

        /* Submenu hidden */
        li>ul {
            display: none;
            background: #020617;
        }

        /* Submenu links */
        li>ul li a {
            display: block;
            padding: 12px 45px;
            font-size: 14px;
            color: #cbd5f5;
            text-decoration: none;
        }

        li>ul li a:hover {
            background: #1e293b;
            color: #22d3ee;
        }
    </style>


</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-light bg-white shadow-sm px-3">
        <button class="btn btn-primary d-md-none" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </button>
        <span class="navbar-brand ms-2">Custom Panda</span>
        <div>
            <i class="bi bi-person-circle fs-4"></i>
        </div>
    </nav>

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <h4 class="text-white text-center py-3">Admin Panel</h4>
            <ul>
                <li>
                    <a class="active" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>

                </li>
                <li>

                    <a href="#"><i class="bi bi-bag"></i> Products</a>
                    <ul>
                        <li> <a href="products/add.php">Create</a></li>
                        <li> <a href="products/all-products.php">Manage</a> </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="bi bi-bag"></i> Categories</a>
                    <ul>
                        <li> <a href="categories/add.php">Create</a></li>
                        <li> <a href="categories/all-categories.php">Manage</a> </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="bi bi-bag"></i> Brands</a>
                    <ul>
                        <li> <a href="brand/add.php">Create</a></li>
                        <li> <a href="brand/all-brands.php">Manage</a> </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="bi bi-bag"></i> Blogs</a>
                    <ul>
                        <li> <a href="add-blog.php">Create</a></li>
                        <li> <a href="blog-management.php">Manage</a> </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="bi bi-cart"></i> Orders</a>
                    <ul>
                        <li> <a href="add-blog.php">Create</a></li>
                        <li> <a href="blog-management.php">Manage</a> </li>
                    </ul>
                </li>
            </ul>


            
            <a href="#"><i class="bi bi-people"></i> Customers</a>
            <a href="auth/logout.php"  class="text-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>

        <!-- Main Content -->
        <div class="container-fluid p-4">

            <!-- Cards -->
            <div class="row g-3">
                <div class="col-md-3 col-6">
                    <div class="card shadow-sm">
                        <div class="card-body d-flex justify-content-between">
                            <div>
                                <h6>Total Products</h6>
                                <h4>120</h4>
                            </div>
                            <i class="bi bi-bag card-icon text-primary"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="card shadow-sm">
                        <div class="card-body d-flex justify-content-between">
                            <div>
                                <h6>Total Orders</h6>
                                <h4>85</h4>
                            </div>
                            <i class="bi bi-cart card-icon text-success"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="card shadow-sm">
                        <div class="card-body d-flex justify-content-between">
                            <div>
                                <h6>Customers</h6>
                                <h4>60</h4>
                            </div>
                            <i class="bi bi-people card-icon text-warning"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="card shadow-sm">
                        <div class="card-body d-flex justify-content-between">
                            <div>
                                <h6>Revenue</h6>
                                <h4>₹45,000</h4>
                            </div>
                            <i class="bi bi-currency-rupee card-icon text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="card mt-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Products</h5>
                    <!-- <button class="btn btn-primary btn-sm">+ Add Product</button> -->
                    <a href="add-product.html" class="btn btn-primary btn-sm">
                        + Add Product
                    </a>

                </div>
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="productTable">
                            <tr>
                                <td>1</td>
                                <td>Men T-Shirt</td>
                                <td>Men</td>
                                <td>₹799</td>
                                <td>25</td>
                                <td>
                                    <button class="btn btn-sm btn-warning">Edit</button>
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Women Kurti</td>
                                <td>Women</td>
                                <td>₹1299</td>
                                <td>18</td>
                                <td>
                                    <button class="btn btn-sm btn-warning">Edit</button>
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("show");
        }
    </script>

    <script>
        let products = JSON.parse(localStorage.getItem("products")) || [];
        let table = document.getElementById("productTable");

        products.forEach((p, index) => {
            table.innerHTML += `
        <tr>
            <td>${index + 1}</td>
            <td>${p.name}</td>
            <td>${p.category}</td>
            <td>₹${p.price}</td>
            <td>${p.stock}</td>
            <td>
                <button class="btn btn-sm btn-danger" onclick="deleteProduct(${index})">Delete</button>
            </td>
        </tr>
    `;
        });

        function deleteProduct(i) {
            products.splice(i, 1);
            localStorage.setItem("products", JSON.stringify(products));
            location.reload();
        }
    </script>

    <script>
        function logout() {
            localStorage.removeItem("isLogin");
            window.location.href = "login.html";
        }
    </script>

    <script>
        document.querySelectorAll('li > a').forEach(menu => {
            menu.addEventListener('click', function(e) {

                const submenu = this.nextElementSibling;

                if (submenu && submenu.tagName === 'UL') {
                    e.preventDefault();

                    // Close other open submenus
                    document.querySelectorAll('li > ul').forEach(ul => {
                        if (ul !== submenu) {
                            ul.style.display = 'none';
                        }
                    });

                    // Toggle current submenu
                    submenu.style.display =
                        submenu.style.display === 'block' ? 'none' : 'block';
                }
            });
        });
    </script>



</body>

</html>