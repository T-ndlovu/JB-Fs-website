<?php
if (isset($_POST['final'])) {
    $subtotal = 0;
    $sessionId = session_id();
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $product_ids = array();
    $quantities = array();
    $totals = array();
    $today = date("Y-m-d");

    if (!empty($products)) {
        foreach ($products as $product) {
            // Get product details
            $product_id = $product['ProductID'];
            $quantity = $products_in_cart[$product_id];
            $price = $product['Price'];

            $total = $price * $quantity;
            $subtotal += $total;

            $product_ids[] = $product_id;
            $quantities[] = $quantity;
            $totals[] = $total;
        }
        //populate orders table

        $sql = "INSERT INTO `order` (CustomerID, OrderDate, TotalPrice) VALUES (:user_id, :today, :subtotal)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':today', $today);
        $stmt->bindParam(':subtotal', $subtotal);
        $stmt->execute();

        if ($stmt->rowCount() > 0) { // Check if insertion was successful
            // Get the order ID for the current customer
            $order_id = $pdo->lastInsertId();

            // Insert into orderdetails table
            foreach ($product_ids as $index => $product_id) {
                if (isset($quantities[$index]) && isset($totals[$index])) {
                    $current_product_id = $product_id;
                    $current_quantity = $quantities[$index];
                    $current_total = $totals[$index];

                    $sql = "INSERT INTO orderdetails (OrderID, ProductID, Quantity, Price) VALUES (:order_id, :current_product_id, :current_quantity, :current_total)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
                    $stmt->bindParam(':current_product_id', $current_product_id, PDO::PARAM_INT);
                    $stmt->bindParam(':current_quantity', $current_quantity, PDO::PARAM_INT);
                    $stmt->bindParam(':current_total', $current_total);
                    $stmt->execute();
                }
            }
        } else {
            echo "Failed to insert into orders table.";
        }

    }
}


?>