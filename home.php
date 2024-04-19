<?php

$productQuery = "SELECT * FROM product";
$productStmt = $pdo->prepare($productQuery);
$productStmt->execute();
$products = $productStmt->fetchAll(PDO::FETCH_ASSOC);


$productImageQuery = "SELECT * FROM productimage";
$productImageStmt = $pdo->prepare($productImageQuery);
$productImageStmt->execute();
$productImages = $productImageStmt->fetchAll(PDO::FETCH_ASSOC);


?>

<?= template_header('Home') ?>

<!-- Hero -->
<section class="bg-custom-orange pb-24 mt-4 flex justify-center w-full sm:p-24">
    <div class="mx-auto flex flex-col lg:flex-row-reverse lg:items-center">
        <img src="public/images/hero.webp" alt="Hero image"
            class="aspect-5/4 w-full object-fit lg:w-[650px] lg:h-[500px] lg:ml-[-200px]" />
        <div class="max-w-md z-10 text-center mt-[-30px] lg:mt-0 lg:text-left">
            <h1 class="text-5xl font-bold">A space only you can create.</h1>
            <p class="mb-12">
                Elevate your home and office with our incredibly high-quality
                furniture at surprisingly affordable prices. Our exceptional service
                goes beyond the sale, ensuring a smile-worthy experience that leaves
                your space looking stylish and feeling functional.
            </p>
            <a class="bg-black rounded-full text-white text-center py-2 px-3" href="#">
                Order now
            </a>
        </div>
    </div>
</section>
<!-- Explore -->
<section class="w-full p-24">
    <div class="max-w-3xl mx-auto">
        <h1 class="font-semibold text-center text-4xl mb-5">
            Explore our range of products.
        </h1>
        <div class="items-center space-y-5 md:space-y-0 md:space-x-5 md:flex md:justify-center">
            <a href="#" class="aspect-4/5 max-w-64 mb-2 relative">
                <div class="overflow-hidden">
                    <img src="https://rb.gy/kvy6j3" alt="Image of a blue sofa"
                        class="w-full h-full object-cover hover:scale-110 transition duration-150 ease-linear" />
                </div>
                <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-center py-2">
                    Rugs
                </div>
            </a>
            <a href="#" class="aspect-4/5 max-w-64 mb-5 relative">
                <div class="overflow-hidden">
                    <img src="https://rb.gy/ov9ban" alt="Image of 2 coffee tables"
                        class="w-full h-full object-cover hover:scale-110 transition duration-150 ease-linear" />
                </div>
                <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-center py-2">
                    Small Tables
                </div>
            </a>
            <a href="#" class="aspect-4/5 max-w-64 mb-5 relative">
                <div class="overflow-hidden">
                    <img src="https://rb.gy/1kqiil" alt="Image of 2 coffee tables"
                        class="w-full h-full object-cover hover:scale-110 transition duration-150 ease-linear" />
                </div>
                <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-center py-2">
                    Sofas
                </div>
            </a>
            <a href="#" class="aspect-4/5 max-w-64 mb-5 relative">
                <div class="overflow-hidden">
                    <img src="https://rb.gy/3z8wza" alt="Image of 2 coffee tables"
                        class="w-full h-full object-cover hover:scale-110 transition duration-150 ease-linear" />
                </div>
                <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-center py-2">
                    BedRoom
                </div>
            </a>

        </div>

    </div>
</section>
<!-- Slides -->
<section class="promoslide max-w-screen-2xl mx-auto">
    <div class="slideshow-container">
        <!-- Full-width images with number and caption text -->
        <div class="mySlides fade">
            <div class="numbertext">1 / 3</div>
            <img src="public/images/couch.jpg" style="width: 100%; height: 800px" />
            <div class="text">
                <h1 class="slider-h1">Comfortability</h1>
                <p class="slider-p">Sink into blissful comfort with our cloud-like couch.</p>
                <a href="index.php?page=category_template&categoryid=#"><button id="promo-button">Shop
                        Couches</button></a>
            </div>
        </div>

        <div class="mySlides fade">
            <div class="numbertext">2 / 3</div>
            <img src="public/images/wall_painting.jpg" style="width: 100%; height: 800px" />
            <div class="text">
                <h1 class="slider-h1">Perfect Finishing Touch</h1>
                <p class="slider-p">Art infuses your home with warmth, transforming it from a space into a haven.</p>
                <a href="index.php?page=category_template&categoryid=#"><button id="promo-button">Shop
                        Paintings</button></a>
            </div>
        </div>

        <div class="mySlides fade">
            <div class="numbertext">3 / 3</div>
            <img src="public/images/coffee_table.webp" style="width: 100%; height: 800px" />
            <div class="text">
                <h1 class="slider-h1">Small set piece</h1>
                <p class="slider-p">Its more than just a part of the home.</p>
                <a href="index.php?page=category_template&categoryid=#"> <button id="promo-button">Shop Set
                        Piece</button></a>
            </div>
        </div>

        <!-- Next and previous buttons -->
        <a class="prev">&#10094;</a>
        <a class="next">&#10095;</a>
    </div>
    <br />

    <!-- The dots/circles -->
    <div style="text-align: center">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
    </div>
</section>
<!-- Top Picks -->
<?php
$displayedProductIDs = []; // Initialize the array to track displayed product IDs
?>

<section class="p-20w-full max-w-screen-1xl mx-auto">
    <h1 class="text-4xl text-center">Our Top Picks</h1>
    <div class="flex flex-wrap justify-center mt-4 space-x-4">
        <?php
        $numProductsDisplayed = 0; // Variable to track the number of displayed products
        for ($i = count($products) - 1; $i >= 0; $i--) {
            $product = $products[$i];
            $productId = $product['ProductID'];

            // Check if the product has already been displayed
            if (!in_array($productId, $displayedProductIDs)) {
                $displayedProductIDs[] = $productId; // Add the product ID to the displayed list
        
                // Find the first image for this product
                $productImage = null;
                foreach ($productImages as $img) {
                    if ($img['ProductID'] === $productId) {
                        $productImage = $img;
                        break;
                    }
                }

                // Output product details if image found
                if ($productImage !== null) {
                    ?>
                    <a href="index.php?page=product&id=<?= $product['ProductID'] ?>" class="mb-4">
                        <div class="space-y-1">
                            <div class="relative overflow-hidden">
                                <img src="<?= $productImage['ImageURL'] ?>" width="200" height="200" alt="<?= $product['Name'] ?>">
                            </div>
                            <p class="font-light text-gray-500">
                                <?= $product['Name'] ?>
                            </p>
                            <p class="font-semibold">&#82;
                                <?= $product['Price'] ?>
                            </p>
                        </div>
                    </a>
                    <?php
                    $numProductsDisplayed++;

                    // Break the loop if 10 products are displayed
                    if ($numProductsDisplayed >= 10) {
                        break;
                    }
                }
            }
        } ?>
    </div>
</section>



<!-- About Us -->
<section class="p-24 w-full bg-custom-orange">
    <div class="mx-auto max-w-screen-2xl md:flex md:space-x-12 md:justify-center md:items-center">
        <h1 class="font-semibold text-4xl">About Us</h1>
        <p class="mt-4 max-w-2xl md:mt-0">
            JB Furniture House is a family-owned business with a passion for
            creating beautiful and functional furniture. We believe that your home
            should be a reflection of your style, and we're here to help you find
            the perfect pieces to make that happen.
            <br /><br />
            We offer a wide selection of high-quality furniture for every room in
            your house, from living room sofas and dining room tables to bedroom
            beds and office desks. We also carry a variety of home decor items to
            help you add the finishing touches to your space.
        </p>
    </div>
</section>
<!-- Location -->
<section class="p-24 w-full md:flex md:space-x-20">
    <img src="https://d2gt4h1eeousrn.cloudfront.net/80139779/location-BBYesn/i96LlT6-1200x1200.webp"
        alt="Self Care Manual - Location Image"
        class="max-w-[500px] w-11/12 aspect-square mx-auto object-cover md:aspect-4/5 md:mx-0 md:w-1/2" />
    <div class="space-y-5 mt-8 md:space-y-8 md:mt-16">
        <h1 class="font-bold text-2xl md:text-4xl">Location</h1>
        <p class="max-w-96">
            Create a space that reflects your style with our wide selection of
            high-quality furniture.
        </p>
        <div class="md:space-y-2">
            <h2 class="font-semibold">Our address</h2>
            <p>dr and, C/O Sefako Makgatho, Dr Van Der Merwe Rd, Montana, Pretoria, 0182</p>
            <a
                href="https://www.google.com/maps/dir/-25.7032192,28.1378816/jb+furniture+auction/@-25.671732,28.1604163,13z/data=!4m9!4m8!1m1!4e1!1m5!1m1!1s0x1ebfdfe6b76bb129:0xf7487328f9c53ce6!2m2!1d28.2492205!2d-25.6775164?entry=ttu">
                Get directions </a>
        </div>
        <div class="md:space-y-2">
            <h2 class="font-semibold">Contact info</h2>
            <p>
                068 561 3608 <br />
                email@example.com
            </p>
        </div>
    </div>
</section>
<?= template_footer() ?>