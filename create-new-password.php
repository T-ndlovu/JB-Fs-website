<?= template_header('create-new-password') ?>
<link rel="stylesheet" href="public/secondary_styles.css" />


<section style="padding-top:40px; padding-bottom:40px">
    <?php
    $selector = $_GET["selector"];
    $validator = $_GET["validator"];

    if (empty($validator) || empty($selector)) {
        echo "Could not valid your request";
    } else {
        if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
            ?>
            <div class="forgot-container">
                <h1 class="f-title">Reset Password</h1>
                <p class="f-description">Enter new password.</p>

                <form action="includes/reset-password.inc.php" method="post">
                    <div class="f-form-group">
                        <input type="hidden" name="selector" class="f-form-control" value="<?php echo $selector; ?>">
                        <input type="hidden" name="validator" class="f-form-control" value="<?php echo $validator; ?>">
                        <input type="password" name="pwd" class="f-form-control" placeholder="Enter new password...">
                        <input type="password" name="pwd-repeat" class="f-form-control" placeholder="Repeat new password...">
                    </div>
                    <button type="submit" class="submit-btn" name="reset-password-submit">Reset Password</button>
                </form>
                <?php
        }
    }

    ?>


</section>



<?= template_footer() ?>