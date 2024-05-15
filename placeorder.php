<?= template_header('Place Order') ?>


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sessionId = session_id();
    $subtotal = $_POST['subtotal'];

    require_once 'includes/payfast.inc.php';

    //require_once 'includes/payflex.inc.php'; ?>



<?php } ?>




<?= template_footer() ?>