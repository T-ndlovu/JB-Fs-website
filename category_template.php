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
        <section style="padding-top:10px">
            <div
                style="background-image: url('https://shorturl.at/qsNP0'); background-size: cover; background-position: center; text-align: center; padding: 50px 0;">
                <h1 style="font-size: 36px; margin: 10px;margin-bottom:10px; color:white; font-weight:bold">
                    <?php echo $category['Category_Name']; ?>
                </h1>
            </div>
        </section>
        <div class="products-wrapper1">
            <?php foreach ($products as $product): ?>
                <?php
                $productImageQuery = "SELECT * FROM productimage";
                $productImageStmt = $pdo->prepare($productImageQuery);
                $productImageStmt->execute();
                $productImages = $productImageStmt->fetchAll(PDO::FETCH_ASSOC);

                $imageURL = '';
                foreach ($productImages as $img) {
                    if ($img['ProductID'] === $product['ProductID']) {
                        $imageURL = $img['ImageURL'];
                        break;
                    }
                }
                ?>
                <a href="index.php?page=product&id=<?= $product['ProductID'] ?>" class="product">
                    <img src="<?= $imageURL ?>" width="200" height="200" alt="<?= $product['Name'] ?>">
                    <span class="name">
                        <?= $product['Name'] ?>
                    </span>
                    <span class="price">&#82;
                        <?= $product['Price'] ?>
                    </span>
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