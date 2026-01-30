<section id="feature" class="section-p1">
    <div class="feature-track">

        <?php
        if (!isset($conn)) {
            include 'config/db.php';
        }

        $categoryQuery = $conn->query("SELECT id, name, img FROM categories ORDER BY name ASC");

        while ($cat = $categoryQuery->fetch_assoc()) {
        ?>
            <div class="fe-box">
                <a href="<?= BASE_URL ?>category.php?id=<?= $cat['id'] ?>">
                    <?php if (!empty($cat['img'])) { ?>
                        <img src="<?= $cat['img']; ?>" alt="<?= htmlspecialchars($cat['name']); ?>">
                    <?php } ?>
                    <h6><?= htmlspecialchars($cat['name']); ?></h6>
                </a>
            </div>
        <?php } ?>

    </div>
</section>


<script src="assets/js/script.js"></script> 
