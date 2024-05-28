<?= template_header('Place Order') ?>


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sessionId = session_id();
    $subtotal = $_POST['subtotal'];



    //require_once 'includes/payflex.inc.php'; ?>

    <div class="pay-cont">

        <h2 id="pay-heading">Select Payment Method:</h2>


        <div class="row-pay">
            <div class="column-pay" style="background-color:#aaa;">
                <h2 id="pay-title">Payfast:</h2>
                <?php require_once 'includes/payfast.inc.php'; ?>
            </div>
            <div class="column-pay" style="background-color:#bbb;">
                <h2 id="pay-title">Payflex:</h2>
            </div>
            <div class="column-pay" style="background-color:#ccc;">
                <h2 id="pay-title">Manual EFT:</h2>
                <button class="open-button" onclick="openForm()">View Details</button>

                <div class="form-popup" id="myForm">
                    <form action="/action_page.php" class="form-container">
                        <p>Bank:<br>
                            Account Name:<br>
                            Account Number:<br>
                            Branch Name:<br>
                            Branch Code:<br>
                            Account Type:<br>
                            Kindly ensure order number is clearly stated as reference.
                            Please email proof of payment to:<br>

                            THIS ORDER WILL BE CANCELLED IF NOT PAID WITHIN 48 HOURS.
                            NB: PLEASE BE ADVISED THAT WE DO NOT ACCEPT CASH DEPOSITS INTO THE ACCOUNT. ANY CASH DEPOSIT
                            FEES FOR
                            CLIENTS ACCOUNT.<br>
                            Thank you for shopping with us.<br>
                            JB Furniture House</p>
                </div>
                <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
                </form>
            </div>
        </div>
    </div>


    </div>
    <h2 class="blue-text">Subtotal: R<?php echo $subtotal ?></h2>



<?php } ?>




<?= template_footer() ?>