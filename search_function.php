<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h4>How to make Search box & filter data in HTML Table from Database in PHP MySQL </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">

                            <form action="index.php" method="GET">
                                <input type="hidden" name="page" value="products">
                                <div class="input-group mb-3">
                                    <input type="text" name="search" required value="<?php if (isset($_GET['search'])) {
                                        echo $_GET['search'];
                                    } ?>" class="form-control" placeholder="Search data">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once "includes/dbh.inc.php";

                            if (isset($_GET['search'])) {
                                $filtervalues = $_GET['search'];
                                $query = "SELECT * FROM product WHERE CONCAT(Name, Price) LIKE ?";
                                $stmt = $pdo->prepare($query);
                                $stmt->execute(["%$filtervalues%"]);

                                if ($stmt->rowCount() > 0) {
                                    while ($items = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        <tr>
                                            <td>
                                                <?= $items['ProductID']; ?>
                                            </td>
                                            <td>
                                                <?= $items['Name']; ?>
                                            </td>
                                            <td>
                                                <?= $items['Price']; ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="4">No Record Found</td>
                                </tr>
                                <?php
                            }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>