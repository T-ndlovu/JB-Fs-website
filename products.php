<?php
// Fetching products for the current page
$num_products_on_each_page = 5;
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int) $_GET['p'] : 1;
$offset = ($current_page - 1) * $num_products_on_each_page;

$stmt = $pdo->prepare('SELECT * FROM product ORDER BY "Name" LIMIT ?, ?');
$stmt->bindValue(1, $offset, PDO::PARAM_INT);
$stmt->bindValue(2, $num_products_on_each_page, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Total number of products
$total_products_stmt = $pdo->query('SELECT COUNT(*) FROM product');
$total_products = $total_products_stmt->fetchColumn();
?>

<?= template_header('Products') ?>
<section style="padding-top:10px">
    <div
        style="background-image: url('https://shorturl.at/mnCQX'); background-size: cover; background-position: center; text-align: center; color:red ; padding: 50px 0;">
        <h1 style="font-size: 36px; margin: 0;margin-bottom:10px; color:red; font-weight:bold">
            Sale
        </h1>
    </div>
</section>
<div class="products content-wrapper">




    <div class="p-container">
        <div class="filter-section">
            <div class="filter-header">
                <h4>Filter Products by Price</h4>
            </div>
            <div class="filter-form">
                <form action="index.php" method="GET">
                    <input type="hidden" name="page" value="products">
                    <div class="filter-inputs">
                        <div class="filter-input">

                            <label for="start_price">Min Price: </label>


                            <input type="text" name="start_price" id="start_price"
                                value="<?= isset($_GET['start_price']) ? $_GET['start_price'] : '100' ?>"
                                class="start_price">
                        </div>
                        <div class="filter-input">

                            <label for="end_price">Max Price: </label>


                            <input type="text" name="end_price" id="end_price"
                                value="<?= isset($_GET['end_price']) ? $_GET['end_price'] : '900' ?>" class="end_price">
                        </div>
                        <div class="filter-input">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="listed-products">
            <?php
            require_once "includes/dbh.inc.php";
            if (isset($_GET['start_price']) && isset($_GET['end_price'])) {
                $startprice = $_GET['start_price'];
                $endprice = $_GET['end_price'];

                $sql = "SELECT * FROM product WHERE Price BETWEEN :startprice AND :endprice";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['startprice' => $startprice, 'endprice' => $endprice]);
                $num_returned_products = $stmt->rowCount();
            } else {
                $sql = "SELECT * FROM product";
                $stmt = $pdo->query($sql);
                $num_returned_products = $stmt->rowCount();
            }

            if ($stmt->rowCount() > 0) {
                while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // Fetch the first image for each product
                    $sql_image = "SELECT * FROM productimage WHERE ProductID = :product_id LIMIT 1";
                    $stmt_image = $pdo->prepare($sql_image);
                    $stmt_image->execute(['product_id' => $product['ProductID']]);
                    $image = $stmt_image->fetch(PDO::FETCH_ASSOC);

                    // Display product and its first image
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
                    <?php
                }
            } else {
                echo "<div class='col-md-12'><p>No Record Found</p></div>";
            }
            ?>
        </div>
    </div>



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

    <div class="buttons">
        <?php if ($current_page > 1 && count($products) > 0): ?>
            <a
                href="index.php?page=products&p=<?= $current_page - 1 ?>&start_price=<?= $_GET['start_price'] ?>&end_price=<?= $_GET['end_price'] ?>">Prev</a>
        <?php endif; ?>

        <?php if (count($products) > 0 && count($products) == $num_products_on_each_page): ?>
            <a
                href="index.php?page=products&p=<?= $current_page + 1 ?>&start_price=<?= $_GET['start_price'] ?>&end_price=<?= $_GET['end_price'] ?>">Next</a>
        <?php endif; ?>
    </div>




    <?= template_footer() ?>