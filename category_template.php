<?= template_header('category_template') ?>
<?php

// Check if category ID is provided in URL parameters
if (isset($_GET['categoryid'])) {
    $categoryId = $_GET['categoryid'];

    $categoryStmt = $pdo->prepare("SELECT Category_Name FROM category WHERE CategoryID = ?");
    $categoryStmt->execute([$categoryId]);
    $category = $categoryStmt->fetch(PDO::FETCH_ASSOC);

    if ($category) {

        $productsStmt = $pdo->prepare("SELECT * FROM product WHERE CategoryID = ?");
        $productsStmt->execute([$categoryId]);
        $products = $productsStmt->fetchAll(PDO::FETCH_ASSOC);
?>
        <link rel="stylesheet" href="./public/extra.css">
        <section style="padding-top:10px; padding-bottom:20px">
            <div style="background-image: url('https://shorturl.at/qsNP0'); background-size: cover; background-position: center; text-align: center; padding: 50px 0;">
                <h1 style="font-size: 36px; margin: 10px;margin-bottom:10px; color:white; font-weight:bold">
                    <?php echo $category['Category_Name']; ?>
                </h1>
            </div>
        </section>

        <div class="listed-products">
            <?php foreach ($products as $product) : ?>
                <?php
                $sql_image = "SELECT * FROM productimage WHERE ProductID = :product_id LIMIT 1";
                $stmt_image = $pdo->prepare($sql_image);
                $stmt_image->execute(['product_id' => $product['ProductID']]);
                $image = $stmt_image->fetch(PDO::FETCH_ASSOC);
                ?>

                <a href="index.php?page=product&id=<?= $product['ProductID'] ?>" class="individual-product">
                    <img src="<?= $image['ImageURL']; ?>" alt="<?= $product['Name'] ?>">
                    <div class="product-details"><span class="product-name">
                            <?= $product['Name'] ?> for
                        </span>
                        <span class="product-price">&#82;
                            <?= $product['Price'] ?>
                        </span>
                    </div>
                </a>

            <?php endforeach; ?>
        </div>
<?php
    } else {
        echo "Category not found!";
    }
} else {
    echo "Category ID not provided!";
}

?>

<?= template_footer() ?>