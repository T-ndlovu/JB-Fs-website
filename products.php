<?php
require_once "includes/dbh.inc.php";

// Function to sanitize input
function sanitize($data)
{
    return htmlspecialchars($data, ENT_QUOTES);
}

// Fetching products for the current page
$num_products_on_each_page = 10;
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int) $_GET['p'] : 1;
$offset = ($current_page - 1) * $num_products_on_each_page;

// Filter functionality
$filter_conditions = [];
$filter_params = [];

if (isset($_GET['start_price']) && isset($_GET['end_price'])) {
    $filter_conditions[] = "Price BETWEEN :start_price AND :end_price";
    $filter_params['start_price'] = sanitize($_GET['start_price']);
    $filter_params['end_price'] = sanitize($_GET['end_price']);
}

// Search functionality
$search_query = '';
$search_params = [];

if (isset($_GET['search'])) {
    $search_query = 'WHERE CONCAT(Name, Price) LIKE :search';
    $search_params['search'] = '%' . sanitize($_GET['search']) . '%';
}

// Build the query
$query = 'SELECT * FROM product ';
if (!empty($search_query)) {
    $query .= $search_query;
    if (!empty($filter_conditions)) {
        $query .= ' AND ' . implode(' AND ', $filter_conditions);
    }
} elseif (!empty($filter_conditions)) {
    $query .= 'WHERE ' . implode(' AND ', $filter_conditions);
}
$query .= ' ORDER BY Name LIMIT :offset, :limit';

$stmt = $pdo->prepare($query);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':limit', $num_products_on_each_page, PDO::PARAM_INT);

// Bind filter parameters
foreach ($filter_params as $key => $value) {
    $stmt->bindValue(':' . $key, $value);
}

// Bind search parameter
foreach ($search_params as $key => $value) {
    $stmt->bindValue(':' . $key, $value);
}

$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Total number of products
$total_products_stmt = $pdo->query('SELECT COUNT(*) FROM product');
$total_products = $total_products_stmt->fetchColumn();
?>


<?= template_header('Products') ?>
<section class="products-section">
    <div class="filter-section">
        <!-- Filter form -->
        <div class="search-and-filter">
            <div class="card-body">
                <!-- Search form -->
                <form action="index.php" method="GET">
                    <input type="hidden" name="page" value="products">
                    <div class="input-group mb-3">
                        <input type="text" name="search" required
                            value="<?= isset($_GET['search']) ? sanitize($_GET['search']) : '' ?>" class="form-control"
                            placeholder="Search Product...">
                        <div class="">
                            <button type="submit" class="btn btn-primary">Search</button>
                            <button type="button" class="btn btn-secondary" onclick="resetSearch()">Clear</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="custom-wrapper">
                <div class="filter-form">
                    <form action="index.php" method="GET">
                        <input type="hidden" name="page" value="products">

                        <input type="hidden" name="search"
                            value="<?= isset($_GET['search']) ? sanitize($_GET['search']) : '' ?>">

                        <div class="filter-inputs price-input-container">
                            <div class="price-input">
                                <div class="filter-input price-field ">
                                    <span>Minimum Price R:</span>
                                    <input type="number" name="start_price" id="start_price"
                                        value="<?= isset($_GET['start_price']) ? sanitize($_GET['start_price']) : '2500' ?>"
                                        class="start_price min-input">
                                </div>


                                <div class="filter-input price-field">
                                    <span>Maximum Price R:</span>
                                    <input type="text" name="end_price" id="end_price"
                                        value="<?= isset($_GET['end_price']) ? sanitize($_GET['end_price']) : '8500' ?>"
                                        class="end_price max-input">
                                </div>


                            </div>
                            <div class="slider-container">
                                <div class="price-slider">
                                </div>
                            </div>
                        </div>
                        <div class="range-input">
                            <input type="range" class="min-range" min="0" max="10000" value="2500" step="1">
                            <input type="range" class="max-range" min="0" max="10000" value="8500" step="1">
                        </div>
                        <div class="filter-input" style="padding-top:20px">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <button type="button" class="btn btn-secondary" onclick="resetFilters()">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Listed products -->
        <div class="listed-products">
            <?php
            if ($stmt->rowCount() > 0) {
                foreach ($products as $product) {
                    // Fetch the first image for each product
                    $sql_image = "SELECT * FROM productimage WHERE ProductID = :product_id LIMIT 1";
                    $stmt_image = $pdo->prepare($sql_image);
                    $stmt_image->execute(['product_id' => $product['ProductID']]);
                    $image = $stmt_image->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <div class="individual-product">
                        <a href="index.php?page=product&id=<?= $product['ProductID'] ?>">
                            <img src="<?= $image['ImageURL']; ?>" alt="<?= $product['Name'] ?>" class="product-image">
                        </a>
                        <div class="product-details">
                            <span class="product-name">
                                <?= $product['Name'] ?> for
                            </span>
                            <span class="product-price">
                                <?= $product['Price'] ?>
                            </span>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<div class='col-md-12'><p>No Record Found</p></div>";
            }
            ?>
        </div>
    </div>
</section>



<!-- Pagination buttons -->
<div class="buttons">
    <?php if ($current_page > 1 && count($products) > 0): ?>
        <a
            href="index.php?page=products&p=<?= $current_page - 1 ?>&start_price=<?= isset($_GET['start_price']) ? sanitize($_GET['start_price']) : '100' ?>&end_price=<?= isset($_GET['end_price']) ? sanitize($_GET['end_price']) : '900' ?>">Prev</a>
    <?php endif; ?>

    <?php if (count($products) > 0 && count($products) == $num_products_on_each_page): ?>
        <a
            href="index.php?page=products&p=<?= $current_page + 1 ?>&start_price=<?= isset($_GET['start_price']) ? sanitize($_GET['start_price']) : '100' ?>&end_price=<?= isset($_GET['end_price']) ? sanitize($_GET['end_price']) : '900' ?>">Next</a>
    <?php endif; ?>
</div>

<style>
    .products-section {
        text-align: left;
        padding: 2%;
        margin: 0 auto;
        margin-top: 2%;
    }

    .search-and-filter {
        margin-bottom: 4%;
        border-radius: 8px;
        padding: 2%;
        max-width: 650px;
        /* background-color: #FAFAFA;
        box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.1); */
    }

    .btn-primary {
        display: inline-block;
        text-decoration: none;
        margin-left: 5px;
        padding: 8px 20px;
        border: 0;
        background: #e2a001;
        color: #ffffff;
        font-size: 14px;
        border-radius: 5px;
        transition: background 0.15s ease-in-out;
    }

    .btn-secondary {
        display: inline-block;
        text-decoration: none;
        margin-left: 5px;
        padding: 8px 20px;
        border: 0;
        background: #e4e4e4;
        color: #000000;
        font-size: 14px;
        border-radius: 5px;
        transition: background 0.15s ease-in-out;
    }

    .btn-secondary:hover {
        background: #4e5c70;
    }

    .btn-primary:hover {
        background: green;
    }

    .topsection {
        background-color: red;
    }

    .form-control {
        width: 100%;
        margin-bottom: 8px;
        padding: 6px;
        background-color: #f9f9f9;
        border-radius: 8px;
    }

    .card-body {
        margin: 0 auto;
        width: 100%;
        max-width: 600px;
    }

    .custom-wrapper {
        margin: 0 auto;
        width: 100%;
        max-width: 600px;
    }
</style>


<?= template_footer() ?>