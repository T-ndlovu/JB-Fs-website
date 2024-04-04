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
    <link rel="stylesheet" href="public/secondary_styles.css" />
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
                        <img class="demo cursor" src="<?= $ImageURL0 ?>" alt="<?= $product['Name'] ?>" onclick="currentS(1)">
                    </div>
                    <div class="col">
                        <img class="demo cursor" src="<?= $ImageURL1 ?>" alt="<?= $product['Name'] ?>" onclick="currentS(2)" a>
                    </div>
                    <div class="col">
                        <img class="demo cursor" src="<?= $ImageURL2 ?>" alt="<?= $product['Name'] ?>" onclick="currentS(3)">
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

    <style>
        .container {
            padding: 10px 20px;
            max-width: 1700px;
            margin: 0px auto;
        }

        .cont {
            position: relative;
            width: 100%;
            margin: 0 auto;
        }

        .description {
            margin-top: 10px;
        }

        .bar {
            margin: 0 auto;
            margin-top: 40px;
            display: flex;
            align-items: center;
            flex-direction: column;
        }

        .bar-btn {
            border-radius: 8px;
            padding: 8px 12px;
            width: 100%;
            background-color: #e2a011;
            transition: background-color 0.15s ease-in-out;
            margin-bottom: 5px;
        }

        .bar-btn:hover {
            background-color: gray;
        }

        .info-section {
            max-width: 1200px;
            margin: 0 auto;
            border-radius: 10px;
            margin: 0 auto;
            margin-top: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }

        /* Right Side */
        .r-side {
            margin-top: 10px;
            flex: 1;

        }

        .product-content-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5%;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: grey;
            width: 100%;
        }

        .product-details {
            flex: 1;
        }

        .product-name {
            font-size: 30px;
            margin-bottom: 8px;
            color: #000000;

        }

        .product-price {
            font-size: 18px;
            color: white;

        }

        .add-to-cart-form {
            display: flex;
            align-items: center;

        }

        .add-to-cart-form input[type="number"] {
            width: 60px;
            padding: 8px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .add-to-cart-button {
            padding: 10px 20px;
            background-color: #e2a001;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .add-to-cart-button:hover {
            background-color: green;
        }

        /* Media Queries */
        @media (min-width: 768px) {
            .bar {
                width: 708px;
                flex-direction: row;
                justify-content: space-around;
            }

            .cont {
                width: 65%;
            }

            .bar-btn {
                padding: 12px 46px;
                width: auto;
                margin-bottom: 0px;
            }
        }
    </style>


    <?= template_footer() ?>

<?php } ?>