<?php
function buyerdata($pdo)
{
    $buyerid = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; // Use the value of $_SESSION['user_id'] as $buyerid


    if ($buyerid !== null) {
        $query = "SELECT * FROM customer WHERE CustomerID = :id;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $buyerid);
        $stmt->execute();

        $info = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if $info is not empty
        if ($info) {
            return $info;
        } else {
            return null; // or handle the case where no customer is found
        }
    } else {
        return null;
    }
}

function addressdata($pdo)
{
    $buyerid = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    if ($buyerid !== null) {
        $query = "SELECT customer.CustomerID, deliveryaddress.* 
                  FROM deliveryaddress 
                  LEFT JOIN customer ON deliveryaddress.CustomerID = customer.CustomerID 
                  WHERE customer.CustomerID = :id;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $buyerid);
        $stmt->execute();

        $inf = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if $info is not empty
        if ($inf) {
            return $inf;
        } else {
            return null;
        }
    } else {
        return null;
    }

}
?>