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
        <section style="padding-top:10px; padding-bottom:20px">
            <div
                style="background-image: url('https://shorturl.at/qsNP0'); background-size: cover; background-position: center; text-align: center; padding: 50px 0;">
                <h1 style="font-size: 36px; margin: 10px;margin-bottom:10px; color:white; font-weight:bold">
                    <?php echo $category['Category_Name']; ?>
                </h1>
            </div>
        </section>

        <div class="listed-products">
            <?php foreach ($products as $product): ?>
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
<style>
    .individual-product {
        margin: 0 auto;
        margin-bottom: 20px;
        width: 400px;
        aspect-ratio: 5/4;
    }

    .individual-product img {
        border-radius: 8px;
        object-fit: cover;
        width: 100%;
        height: 100%;
        max-height: 450px;
        max-width: 600px;
    }

    .individual-product img {
        margin: 0 auto;
    }

    .products {
        padding: 2%;
        max-width: 1236px;
        margin: 0 auto;
    }

    .products h1 {
        padding: 2%;
    }

    .products p,
    .product-details {
        text-align: center;
    }

    .product-name {
        font-size: large;
    }

    .product-price {
        font-size: large;
        font-weight: bold;
    }

    @media (min-width: 1068px) {
        .individual-product img {
            width: 100%;
            height: 100%;
        }

        .individual-product {
            width: 400px;
            aspect-ratio: 5/4;
        }

        .listed-products {
            display: grid;
            grid-template-rows: 1fr 1fr;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 30px;
        }
    }
</style>

<?= template_footer() ?>