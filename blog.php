<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog | Custom Panda</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php include 'components/header.php'; ?>

    <section class="fashion-blog">
        <div class="blog-header">
            <h2>Style Journal</h2>
            <p>Latest trends, fashion tips & style inspiration</p>
        </div>

        <div class="blog-grid">

            <!-- Blog Card -->
            <article class="blog-card">
                <div class="blog-img">
                    <img src="assets/img/products/1.png" alt="">
                </div>
                <div class="blog-content">
                    <span class="blog-tag">Trends</span>
                    <h3>Winter Fashion Trends 2026</h3>
                    <p>
                        Discover the must-have winter outfits that keep you stylish and warm this season.
                    </p>
                    <a href="#" class="read-more">Read More →</a>
                </div>
            </article>

            <article class="blog-card">
                <div class="blog-img">
                    <img src="assets/img/products/2.png" alt="">
                </div>
                <div class="blog-content">
                    <span class="blog-tag">Style Tips</span>
                    <h3>How to Style Oversized Hoodies</h3>
                    <p>
                        Learn easy ways to style oversized hoodies for a casual yet trendy look.
                    </p>
                    <a href="#" class="read-more">Read More →</a>
                </div>
            </article>

            <article class="blog-card">
                <div class="blog-img">
                    <img src="assets/img/products/3.png" alt="">
                </div>
                <div class="blog-content">
                    <span class="blog-tag">Lookbook</span>
                    <h3>Streetwear Lookbook 2026</h3>
                    <p>
                        Explore bold streetwear outfits inspired by modern urban fashion.
                    </p>
                    <a href="#" class="read-more">Read More →</a>
                </div>
            </article>

        </div>
    </section>


    <?php include 'components/footer.php'; ?>

</body>

</html>