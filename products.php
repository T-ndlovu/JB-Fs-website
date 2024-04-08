<style>
    /* Your CSS styles here */
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



<?php
require_once "includes/dbh.inc.php";

// Function to sanitize input
function sanitize($data)
{
    return htmlspecialchars($data, ENT_QUOTES);
}

// Fetching products for the current page
$num_products_on_each_page = 5;
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
<section style="padding-top:10px">
    <!-- Your section content here -->
</section>

<div class="card-body">
    <div class="row">
        <div class="col-md-7">
            <!-- Search form -->
            <form action="index.php" method="GET">
                <input type="hidden" name="page" value="products">
                <div class="input-group mb-3">
                    <input type="text" name="search" required
                        value="<?= isset($_GET['search']) ? sanitize($_GET['search']) : '' ?>" class="form-control"
                        placeholder="Search data">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="filter-section">
    <!-- Filter form -->
    <div class="filter-form">
        <form action="index.php" method="GET">
            <input type="hidden" name="page" value="products">
            <div class="filter-inputs">
                <div class="filter-input">
                    <label for="start_price">Min Price: </label>
                    <input type="text" name="start_price" id="start_price"
                        value="<?= isset($_GET['start_price']) ? sanitize($_GET['start_price']) : '100' ?>"
                        class="start_price">
                </div>
                <div class="filter-input">
                    <label for="end_price">Max Price: </label>
                    <input type="text" name="end_price" id="end_price"
                        value="<?= isset($_GET['end_price']) ? sanitize($_GET['end_price']) : '900' ?>"
                        class="end_price">
                </div>
                <div class="filter-input">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
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


<?= template_footer() ?>