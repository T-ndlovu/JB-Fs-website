<?= template_header('forgot-password') ?>
<link rel="stylesheet" href="public/secondary_styles.css" />


<section style="padding-top:40px; padding-bottom:40px">

    <div class="forgot-container">
        <h1 class="f-title">Forgot Your Password?</h1>
        <p class="f-description">Enter the e-mail address associated with your account. Click submit to have a password
            reset link e-mailed to you.</p>

        <form action="includes/reset-request.inc.php" method="post">
            <div class="f-form-group">
                <label for="email" class="f-form-label">Your E-Mail Address</label>
                <input type="email" id="email" name="email" required class="f-form-control"
                    placeholder="Enter your email">
            </div>
            <button type="submit" class="submit-btn" name="reset-submit">Submit</button>
        </form>
        <?php
        if (isset($_GET['reset'])) {
            if ($_GET['reset'] == "success") {
                echo "<h3> Check your email</h3>";
            }
        }
        ?>


        <div class="back-link-forgot-container">
            <a href="index.php?page=cart" class="back-link">← BACK</a>
        </div>
    </div>

</section>



<?= template_footer() ?>