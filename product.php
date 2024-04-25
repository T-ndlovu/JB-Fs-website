<?php

// Display single product detail if 'id' parameter is provided
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM product WHERE ProductID = ?');
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        exit('Product does not exist!');
    }

    $productImageQuery = "SELECT * FROM productimage";
    $productImageStmt = $pdo->prepare($productImageQuery);
    $productImageStmt->execute();
    $productImages = $productImageStmt->fetchAll(PDO::FETCH_ASSOC);

    $imageURLs = array();

    foreach ($productImages as $img) {
        if ($img['ProductID'] === $product['ProductID']) {
            // Add the image URL to the array
            $imageURLs[] = $img['ImageURL'];
        }
    }
    $ImageURL0 = isset($imageURLs[0]) ? $imageURLs[0] : '';
    $ImageURL1 = isset($imageURLs[1]) ? $imageURLs[1] : '';
    $ImageURL2 = isset($imageURLs[2]) ? $imageURLs[2] : '';
    ?>

    <?= template_header('Product') ?>
    <link rel="stylesheet" href="public/secondary-styles.css" />
    <section class="container">
        <div class="l-side">
            <div class="cont">
                <div class="mySlide">
                    <div class="numbertext">1 / 3</div>
                    <img src="<?= $ImageURL0 ?>" alt="<?= $product['Name'] ?>">
                </div>

                <div class="mySlide">
                    <div class="numbertext">2 / 3</div>
                    <img src="<?= $ImageURL1 ?>" alt="<?= $product['Name'] ?>">
                </div>

                <div class="mySlide">
                    <div class="numbertext">3 / 3</div>
                    <img src="<?= $ImageURL2 ?>" alt="<?= $product['Name'] ?>">
                </div>

                <a class="prevv" onclick="plusSlide(-1)">&#10094;</a>
                <a class="nextt" onclick="plusSlide(1)">&#10095;</a>

                <div class="rows">
                    <div class="col">
                        <img class="demo cursor" src="<?= $ImageURL0 ?>" alt="<?= $product['Name'] ?>"
                            onclick="currentS(1)">
                    </div>
                    <div class="col">
                        <img class="demo cursor" src="<?= $ImageURL1 ?>" alt="<?= $product['Name'] ?>" onclick="currentS(2)"
                            a>
                    </div>
                    <div class="col">
                        <img class="demo cursor" src="<?= $ImageURL2 ?>" alt="<?= $product['Name'] ?>"
                            onclick="currentS(3)">
                    </div>
                </div>
            </div>
            <section class="description">
                <div class="bar">
                    <button class="bar-btn" onclick="openinfo(event,'Warranty')">
                        Warranty
                    </button>
                    <button class="bar-btn" onclick="openinfo(event,'Care Instructions')">
                        Care Instructions
                    </button>
                    <button class="bar-btn" onclick="openinfo(event,'Description')">
                        Description
                    </button>
                </div>
                <div class="info-section">
                    <div id="Warranty" class="info">
                        <p>
                            <?= $product['WarrantyInfo'] ?>
                        </p>
                    </div>

                    <div id="Care Instructions" class="info" style="display: none">
                        <p>
                            <?= $product['CareInstructions'] ?>
                        </p>
                    </div>
                    <div id="Description" class="info" style="display: none">
                        <p>
                            <?= $product['Description'] ?>
                        </p>
                    </div>
                </div>
            </section>
        </div>

        <div class="r-side">
            <div class="product-content-wrapper">
                <script async
                    src="https://widgets.payflex.co.za/your-merchant-name/partpay-widget-0.1.2.js?type=calculator&min=50&max=400&amount=300"
                    type="application/javascript"></script>
                <div class="product-details">

                    <h1 class="product-name">
                        <?= $product['Name'] ?>
                    </h1>
                    <p class="product-price">&#82;
                        <?= $product['Price'] ?>
                    </p>

                </div>
                <form class="add-to-cart-form" action="index.php?page=cart" method="post">
                    <input type="number" name="quantity" value="1" min="1" max="<?= $product['Quantity'] ?>" required>
                    <input type="hidden" name="product_id" value="<?= $product['ProductID'] ?>">
                    <button type="submit" class="add-to-cart-button">Add To Cart</button>
                </form>
            </div>
        </div>
    </section>




    <?= template_footer() ?>

<?php } ?>