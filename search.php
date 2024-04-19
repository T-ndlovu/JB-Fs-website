<?php
require_once "includes/dbh.inc.php";

if (isset($_GET['search'])) {
    $filtervalues = $_GET['search'];


    if (!empty($filtervalues)) {
        $query = "SELECT * FROM product WHERE Name LIKE :filtervalues";
        $stmt = $pdo->prepare($query);

        $searchParam = "%$filtervalues%";
        $stmt->bindParam(':filtervalues', $searchParam, PDO::PARAM_STR);
        if (!$stmt->execute()) {

            echo "Error executing query: " . $stmt->errorInfo()[2];
        } else {
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($products) > 0) {
                ?>
                <?= template_header('search') ?>
                <link rel="stylesheet" href="./public/extra.css">
                <section style="padding-top:10px; padding-bottom:20px">
                    <div
                        style="background-image: url('https://shorturl.at/qsNP0'); background-size: cover; background-position: center; text-align: center; padding: 50px 0;">

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
                            <div class="product-details">
                                <span class="product-name"><?= $product['Name'] ?> for</span>
                                <span class="product-price">&#82; <?= $product['Price'] ?></span>
                            </div>
                        </a>

                    <?php endforeach; ?>
                </div>
                <?php
            } else {
                echo "No products found.";
            }
        }
    } else {

        header("Location: index.php");
        exit();
    }
} else {

    header("Location: index.php");
    exit();
}
?>
<?= template_footer() ?>