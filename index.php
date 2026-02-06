<?php
include 'config/db.php'
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Panda Store | Comfortable Everyday Clothing Manufacturer in India</title>
    <meta name="description" content="Custom Panda Store offers comfortable men’s clothing including T-shirts, hoodies, and sportswear, designed for daily and regular use.">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <?php include 'components/header.php'; ?>


    <div id="carouselExampleIndicators" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="assets/img/banner/banner.png" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="assets/img/banner/banner-2.png" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <?php include 'components/get-category.php'; ?>

    
    <section id="product1" class="section-p1 py-3">
        <h2>New Arrivals</h2>
        <p>Summer Collection New Modern Design</p>
        <?php
        $limit = 4;
        include 'components/new-arrival-products.php' ?>
    </section>

    <section id="product1" class="section-p1 py-3">
        <h2>Best Selling Products </h2>
        <p>Most loved products chosen for quality, comfort, and daily wear needs</p>
        <?php
        $limit = 4;
        include 'components/best-sales-products.php'; ?>
    </section>

    <section id="banner" class="section-m1">
        <h4>Repair Services</h4>
        <h2>Up to <span>60% Off</span> - All t-Shirts & Accessories</h2>
        <button class="normal">Explore More</button>
    </section>

    <section id="product1" class="section-p1 py-3">
        <h2>Trending Now </h2>
        <p>Popular styles loved for comfort, fit, and everyday wear</p>
        <?php
        $limit = 4;
        include 'components/trending-products.php'; ?>
    </section>

    <section id="product1" class="section-p1 py-3">
        <h2>Featured Products</h2>
        <p>Summer Collection New Modern Design</p>
        <?php include 'components/product-cards.php'; ?>
    </section>






    <section class="banner-wrapper">

        <!-- TOP 2 BANNERS -->
        <section id="sm-banner" class="banner-row two-banner">
            <div class="banner-box">
                <h4>crazy deals</h4>
                <h2>buy 1 get 1 free</h2>
                <span>The best classic dress is on sale at cara</span>
                <button class="white">Learn More</button>
            </div>

            <!-- <div class="banner-box banner-box2">
                    <h4>spring/summer</h4>
                    <h2>upcomming season</h2>
                    <span>The best classic dress is on sale at cara</span>
                    <button class="white">Collection</button>
                </div> -->
        </section>
    </section>


    <!-- <section id="newsletter" class="section-p1 section-m1">
            <div class="newstext">
                <h4>Sign Up For newsletters</h4>
                <p>Get E-mail updates about our latest shop and <span>special offers.</span></p>
            </div>
            <div class="form">
                <input type="text" placeholder="Your email address">
                <button class="normal">Sign Up</button>
            </div>
        </section> -->


    <section class="faq-section">
        <h2>Frequently Asked Questions</h2>

        <div class="faq-item">
            <button class="faq-question">
                <span>Do you accept bulk orders?</span>
                <span class="icon">+</span>
            </button>
            <div class="faq-answer">
                Yes, we accept bulk orders and ensure consistent quality, proper finishing, and smooth coordination throughout the complete order process.
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question">
                <span>Can I customize T-shirts with my design?</span>
                <span class="icon">+</span>
            </button>
            <div class="faq-answer">
                Yes, customized T-shirts are available with your designs, logos, or text, suitable for personal, business, and promotional use.
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question">
                <span>What fabric quality do you use?</span>
                <span class="icon">+</span>
            </button>
            <div class="faq-answer">
                We use comfortable and durable fabric that feels good to wear and performs well for regular, long term daily usage.
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question">
                <span>How long does order processing take?</span>
                <span class="icon">+</span>
            </button>
            <div class="faq-answer">
                Order processing time depends on quantity and customization, but we always aim for timely production and reliable dispatch.
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question">
                <span>Do you deliver products across India?</span>
                <span class="icon">+</span>
            </button>
            <div class="faq-answer">
                Yes, we supply and deliver our apparel products across India with safe packaging and trusted delivery partners.
            </div>
        </div>
    </section>


    <section class="py-5 stat-section mb-2" id="stats">
        <div class="container">
            <div class="row text-center g-4">

                <div class="col-6 col-md-3">
                    <div class="stat-box">
                        <i class="fa-solid fa-face-smile stat-icon"></i>
                        <h2><span class="counter" data-target="500">0</span>+</h2>
                        <p>Happy Customers</p>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="stat-box">
                        <i class="fa-solid fa-box stat-icon"></i>
                        <h2><span class="counter" data-target="1000">0</span>+</h2>
                        <p>Products Delivered</p>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="stat-box">
                        <i class="fa-solid fa-calendar-check stat-icon"></i>
                        <h2><span class="counter" data-target="7">0</span>+</h2>
                        <p>Years of Experience</p>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="stat-box">
                        <i class="fa-solid fa-users stat-icon"></i>
                        <h2><span class="counter" data-target="50">0</span>+</h2>
                        <p>Product Variations</p>
                    </div>
                </div>

            </div>
        </div>
    </section>






    <!-- <section class="newsletter-section py-5 my-5">
            <div class="container">
                <div class="row align-items-center g-4">

                    
                    <div class="col-lg-6 text-center text-lg-start fade-left">
                        <h4 class="fw-bold mb-2">Sign Up For Newsletters</h4>
                        <p class="mb-0">
                            Get E-mail updates about our latest shop and
                            <span class="highlight">special offers</span>
                        </p>
                    </div>

                    
                    <div class="col-lg-6 fade-right">
                        <form class="d-flex flex-column flex-sm-row gap-2">
                            <input type="email" class="form-control newsletter-input"
                                placeholder="Your email address" required>
                            <button class="btn newsletter-btn">
                                Sign Up
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </section> -->

    </div>

    <?php include 'components/footer.php'; ?>

    <script src="assets/js/script.js"></script>

    <!-- <script src="assets/js/common-cart.js"></script> -->

    <script>
        document.querySelectorAll(".faq-question").forEach(button => {
            button.addEventListener("click", () => {
                const faqItem = button.parentElement;
                const icon = button.querySelector(".icon");


                document.querySelectorAll(".faq-item").forEach(item => {
                    if (item !== faqItem) {
                        item.classList.remove("active");
                        item.querySelector(".icon").textContent = "+";
                    }
                });

                // Toggle current
                faqItem.classList.toggle("active");
                icon.textContent = faqItem.classList.contains("active") ? "−" : "+";
            });
        });
    </script>


    <script>
        const counters = document.querySelectorAll('.counter');
        let started = false;

        const startCounting = () => {
            counters.forEach(counter => {
                const target = +counter.dataset.target;
                let count = 0;
                const increment = target / 120;

                const update = () => {
                    if (count < target) {
                        count += increment;
                        counter.innerText = Math.ceil(count);
                        requestAnimationFrame(update);
                    } else {
                        counter.innerText = target;
                    }
                };
                update();
            });
        };

        const observer = new IntersectionObserver(entries => {
            if (entries[0].isIntersecting && !started) {
                started = true;
                startCounting();
            }
        }, {
            threshold: 0.5
        });

        observer.observe(document.querySelector('#stats'));
    </script>



</body>

</html>