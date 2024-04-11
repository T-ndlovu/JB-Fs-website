<?php

require_once 'includes/register_view.inc.php';
require_once 'includes/login_view.inc.php';

// If the user clicked the add to cart button on the product page we can check for the form data
if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])) {
    // Set the post variables so we easily identify them, also make sure they are integer
    $product_id = (int) $_POST['product_id'];
    $quantity = (int) $_POST['quantity'];

    $stmt = $pdo->prepare('SELECT * FROM product WHERE ProductID = ?');
    $stmt->execute([$_POST['product_id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product && $quantity > 0) {
        // Product exists in database, now we can create/update the session variable for the cart
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            if (array_key_exists($product_id, $_SESSION['cart'])) {
                // Product exists in cart so just update the quanity
                $_SESSION['cart'][$product_id] += $quantity;
            } else {

                $_SESSION['cart'][$product_id] = $quantity;
            }
        } else {

            $_SESSION['cart'] = array($product_id => $quantity);
        }
    }

    header('location: index.php?page=cart');
    exit;
}
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    // Remove the product from the shopping cart
    unset($_SESSION['cart'][$_GET['remove']]);
}

if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    // Loop through the post data so we can update the quantities for every product in cart
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $id = str_replace('quantity-', '', $k);
            $quantity = (int) $v;

            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {

                $_SESSION['cart'][$id] = $quantity;
            }
        }
    }

    header('location: index.php?page=cart');
    exit;
}

if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    header('Location: index.php?page=placeorder');
    exit;
}

$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;

if ($products_in_cart) {
    // There are products in the cart so we need to select those products from the database
    // Products in cart array to question mark string array, we need the SQL statement to include IN (?,?,?,...etc)
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $stmt = $pdo->prepare('SELECT * FROM product WHERE ProductID IN (' . $array_to_question_marks . ')');
    // We only need the array keys, not the values, the keys are the id's of the products
    $stmt->execute(array_keys($products_in_cart));
    // Fetch the products from the database and return the result as an Array
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Calculate the subtotal
    foreach ($products as $product) {
        $subtotal += (float) $product['Price'] * (int) $products_in_cart[$product['ProductID']];
    }
}
?>

<?= template_header('Cart') ?>

<section class="product-container">
    <div class="cart content-wrapper">
        <h1>Shopping Cart</h1>
        <form action="index.php?page=cart" method="post">
            <table>
                <thead>
                    <tr>
                        <td colspan="2">Product</td>
                        <td>Price</td>
                        <td>Quantity</td>
                        <td>Total</td>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($products)) : ?>
                        <tr>
                            <td colspan="5" style="text-align:center;">You have no products added in your Shopping
                                Cart
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($products as $product) : ?>
                            <tr>
                                <td class="img">
                                    <a href="index.php?page=product&id=<?= $product['ProductID'] ?>">
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
                                        <img src="<?= $imageURL ?>" width="50" height="50" alt="<?= $product['Name'] ?>">
                                    </a>
                                </td>
                                <td>
                                    <a href="index.php?page=product&id=<?= $product['ProductID'] ?>">
                                        <?= $product['Name'] ?>
                                    </a>
                                    <br>
                                    <a href="index.php?page=cart&remove=<?= $product['ProductID'] ?>" class="remove">Remove</a>
                                </td>
                                <td class="price">&#82;
                                    <?= $product['Price'] ?>
                                </td>
                                <td class="quantity">
                                    <input type="number" name="quantity-<?= $product['ProductID'] ?>" value="<?= $products_in_cart[$product['ProductID']] ?>" min="1" max="<?= $product['Quantity'] ?>" placeholder="Quantity" required>
                                </td>
                                <td class="price">
                                    <?= $product['Price'] * $products_in_cart[$product['ProductID']] ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    <?php endif; ?>
                </tbody>
            </table>

            <div class="price-info"><span class="subtotal">Subtotal:</span>
                <span class="price">&#82;
                    <?= $subtotal ?>
                </span>
            </div>

            <?php $sessionId = session_id(); ?>
            <div class="buttons">
                <input type="submit" value="Update" name="update">
                <?php if (isset($_SESSION['user_id'])) { ?>
                    <input type="submit" value="Check Out" name="placeorder">
                <?php } ?>
                <!--?php var_dump($_SESSION); ?-->

            </div>

    </div>
    <?php require_once 'includes/process-order.inc.php'; ?>
    <form method="post">
        <input type="submit" name="final" value="final">

    </form>


    <div class="register-form">
        <h2>Create an account.</h2>
        <form action="includes/register.inc.php" method="post" class="register">
            <div class="form-group">
                <h3>Your Personal Details</h3>
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="firstName" required placeholder="First Name" />
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" required name="lastName" placeholder="Last Name" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <input type="email" class="form-control" required name="email" placeholder="E-Mail" />
                    </div>
                    <div class="col-md-6">
                        <input type="tel" class="form-control" required name="telephone" placeholder="Telephone" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <input type="tel" class="form-control" name="altTelephone" placeholder="Alternative Number" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <h3>Your Address</h3>
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class="form-control" required name="address1" placeholder="Address 1" />
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="address2" placeholder="Address 2 (Optional)" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class="form-control" required name="city" placeholder="City" />
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" required name="postcode" placeholder="Post Code" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <select name="country" class="form-control">
                            <option value="">Select your country</option>
                            <option>South Africa</option>
                            <option>Algeria</option>
                            <option>Angola</option>
                            <option>Benin</option>
                            <option>Botswana</option>
                            <option>Burkina Faso</option>
                            <option>Burundi</option>
                            <option>Cabo Verde</option>
                            <option>Cameroon</option>
                            <option>Central African Republic</option>
                            <option>Chad</option>
                            <option>Comoros</option>
                            <option>Congo (Democratic Republic of the)</option>
                            <option>Congo (Republic of the)</option>
                            <option>Djibouti</option>
                            <option>Egypt</option>
                            <option>Equatorial Guinea</option>
                            <option>Eritrea</option>
                            <option>Eswatini</option>
                            <option>Ethiopia</option>
                            <option>Gabon</option>
                            <option>Gambia</option>
                            <option>Ghana</option>
                            <option>Guinea</option>
                            <option>Guinea-Bissau</option>
                            <option>Ivory Coast</option>
                            <option>Kenya</option>
                            <option>Lesotho</option>
                            <option>Liberia</option>
                            <option>Libya</option>
                            <option>Madagascar</option>
                            <option>Malawi</option>
                            <option>Mali</option>
                            <option>Mauritania</option>
                            <option>Mauritius</option>
                            <option>Morocco</option>
                            <option>Mozambique</option>
                            <option>Namibia</option>
                            <option>Niger</option>
                            <option>Nigeria</option>
                            <option>Rwanda</option>
                            <option>Sao Tome and Principe</option>
                            <option>Senegal</option>
                            <option>Seychelles</option>
                            <option>Sierra Leone</option>
                            <option>Somalia</option>
                            <option>South Sudan</option>
                            <option>Sudan</option>
                            <option>Tanzania</option>
                            <option>Togo</option>
                            <option>Tunisia</option>
                            <option>Uganda</option>
                            <option>Zambia</option>
                            <option>Zimbabwe</option>
                            <option value="Other">Other (please specify)</option>
                        </select>
                        <input type="text" name="other_country" placeholder="Enter your country" style="display: none;">
                    </div>
                    <script>
                        document.querySelector('select[name="country"]').addEventListener('change', function() {
                            var otherInput = document.querySelector('input[name="other_country"]');
                            if (this.value === 'Other') {
                                otherInput.style.display = 'block';
                            } else {
                                otherInput.style.display = 'none';
                            }
                        });
                    </script>
                    <div class="col-md-6">
                        <select name="region" class="form-control">
                            <option value="">Select your region</option>
                            <option>Gauteng</option>
                            <option>Eastern Cape</option>
                            <option>Free State</option>
                            <option>Gauteng</option>
                            <option>KwaZulu-Natal</option>
                            <option>Limpopo</option>
                            <option>Mpumalanga</option>
                            <option>North West</option>
                            <option>Northern Cape</option>
                            <option>Western Cape</option>
                            <option>Limpopo</option>
                            <option value="Other">Other (please specify)</option>
                        </select>
                        <input type="text" name="other_region" placeholder="Enter your country" style="display: none;">
                    </div>
                    <script>
                        document.querySelector('select[name="region"]').addEventListener('change', function() {
                            var otherInput = document.querySelector('input[name="other_region"]');
                            if (this.value === 'Other') {
                                otherInput.style.display = 'block';
                            } else {
                                otherInput.style.display = 'none';
                            }
                        });
                    </script>
                </div>
            </div>
            <div class="form-group">
                <h3>Your Password</h3>
                <div class="row">
                    <div class="col-md-6">
                        <input type="password" class="form-control" name="pwd" placeholder="Password" required />
                    </div>
                </div>
            </div>
            <button type="submit" class="btn-primary">Submit</button>
        </form>
        <?php
        check_register_errors();
        ?>
    </div>


    <div class="login-form">
        <h2>Login</h2>
        <form action="includes/login.inc.php" method="post" class="login">
            <div class="form-field">
                <input type="text" placeholder="Email Address" name="email" required class="form-control" />
            </div>
            <div class="form-field">
                <input type="password" placeholder="Password" name="pwd" required class="form-control" />
            </div>
            <div class="pass-link"><a href="index.php?page=forgot-password">Forgot password?</a></div>
            <button type="submit" class="btn-primary">Submit</button>
            <div class="register-link">
                Dont Have Account? <a href="#">register now</a>
            </div>
        </form>
        <?php
        check_login_errors();
        ?>
    </div>

    </form>
</section>

<style>
    .product-container {
        max-width: 1700px;
        margin: 0 auto;
        padding-bottom: 1%;
    }

    .login-form,
    .register-form,
    .content-wrapper {
        margin: 0 auto;
        margin-bottom: 2.5rem;
        width: 50%;
        min-width: 350px;
        padding: 8px 20px;
        border: 1px solid #e2a011;
        border-radius: 10px;
    }

    .login-form h2,
    .register-form h2 {
        font-size: x-large;
    }

    .login-form h2 {
        margin-bottom: 22px;
    }

    .login-form h3,
    .register-form h3 {
        margin-top: 22px;
        margin-bottom: 4px;
    }

    .login-form {
        margin-top: 1.5rem;
    }

    .content-wrapper,
    .login-form {
        border: 0;
    }

    @media (min-width: 1168px) {
        .product-container {
            margin-top: 1.75rem;
            display: flex;
            justify-content: space-around;
            /* align-items: center; */
        }

        .login-form,
        .register-form,
        .content-wrapper {
            margin-top: 0;
            width: 25%;
            margin-bottom: 0;
        }
    }

    h2 {
        color: #e2a011;
    }

    .form-field {
        margin-bottom: 15px;
    }

    .pass-link,
    .register-link {
        margin-top: 10px;
        text-align: center;
    }

    input[type="submit"] {
        background-color: #e2a011;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-primary {
        background-color: #e2a011;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-primary:hover {
        background-color: gray;
    }

    select {
        width: 100%;
        padding: 8px;
        border-radius: 5px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        margin-top: 5px;
    }

    .subtotal {
        font-size: larger;
        color: black;
    }

    .price-info {
        padding: 2rem 0;
    }

    .form-control {
        width: 100%;
        margin-bottom: 8px;
        padding: 6px;
        background-color: #f9f9f9;
        border-radius: 8px;
    }

    .cart h1 {
        display: block;
        font-weight: normal;
        font-size: 24px;
        text-align: center;
    }

    .cart table {
        width: 100%;
    }

    .cart table thead td {
        padding: 30px 0;
        border-bottom: 1px solid #eeeeee;
    }

    .cart table thead td:last-child {
        text-align: right;
    }

    .cart table tbody td {
        padding: 20px 0;
        border-bottom: 1px solid #eeeeee;
    }

    .cart table tbody td:last-child {
        text-align: right;
    }

    .cart table .img {
        width: 80px;
    }

    .cart table .remove {
        color: #777777;
        font-size: 12px;
        padding-top: 3px;
    }

    .cart table .remove:hover {
        text-decoration: underline;
    }

    .cart table .price {
        color: #999999;
    }

    .cart table a {
        text-decoration: none;
        color: #555555;
    }

    .cart table input[type="number"] {
        width: 68px;
        padding: 10px;
        border: 1px solid #ccc;
        color: #555555;
        border-radius: 5px;
    }

    .cart .buttons {
        text-align: right;
        padding-bottom: 40px;
    }

    .cart .buttons input[type="submit"] {
        margin-left: 5px;
        padding: 12px 20px;
        border: 0;
        /* background: #4e5c70; */
        background: #e2a011;
        color: #ffffff;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        border-radius: 5px;
    }

    .cart .buttons input[type="submit"]:hover {
        background: #434f61;
    }
</style>

<?= template_footer() ?>