<?php

function template_header($title)
{
    // Get the number of items in the shopping cart, which will be displayed in the header.
    $num_items_in_cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

    echo <<<EOT
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>JB Furniture House</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="public/output.css"/>
    <link rel="stylesheet" href="public/style.css"/>
    <link rel="stylesheet" href="public/secondary-styles.css"/>
    <link rel="stylesheet" href="public/cart.css"/>
    <link rel="stylesheet" href="public/extra.css"/>
    <link rel="stylesheet" href="public/footer.css"/>
</head>
<body>
<header class="mt-3 px-4 container mx-auto max-w-screen-2xl flex justify-between items-center">
    <div class="flex justify-around items-center space-x-6 ">
        <a href="index.php" class=""><h1 class="text-custom-orange text-2xl">JB Furniture House</h1></a>
        <div class="hidden space-x-6 lg:flex">
            <a href="index.php?page=category_template&categoryid=3" class="">Living Room</a>
            <a href="index.php?page=category_template&categoryid=9" class="">Ornaments</a>
            <a href="index.php?page=category_template&categoryid=2" class="">Dining</a>
            <a href="index.php?page=category_template&categoryid=5" class="">Bedroom</a>
            <a href="index.php?page=category_template&categoryid=7" class="">Rugs</a>
           
            <a href="index.php?page=products" style="color:red; font-weight: bold;">On Sale</a>
        </div>
    </div>
    <div class="flex justify-around items-center space-x-4">
    <form method="get" action="index.php">
    <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
    </svg></button>
    <input type="hidden" name="page" value="search">
    <input type="text" name="p_search" placeholder="Search Product...">  
    </form>

        <a
        class="hidden bg-black rounded-full text-white text-center py-2 px-5 lg:block"
        href="mailto:#"
      >
        Contact us
      </a>
EOT;


    echo '<a href="index.php?page=cart">';
    echo '<div style="display: flex; align-items: center;">';
    echo '<i class="fas fa-shopping-cart"></i>';
    echo '<span style="display: inline-block; padding: 0px 8px;border-radius: 50%; background-color: #e2a011; color: white; margin-left: 5px; ">';
    echo $num_items_in_cart;
    echo '</span>';
    echo '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">';
    echo '<path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"/>';
    echo '</svg>';
    echo '</div>';
    echo '</a>';


    echo <<<EOT
        <input id="menu-toggle" type="checkbox" />
        <label class="menu-button-container" for="menu-toggle">
            <div class="menu-button"></div>
        </label>
        <ul class="menu">
           
            <li>
                <a href="index.php?page=category_template&categoryid=3" class="">Living Room</a>
            </li>
            <li>
            <a href="index.php?page=category_template&categoryid=9" class="">Ornaments</a>
            </li>
            <li>
                <a href="index.php?page=category_template&categoryid=2" class="">Dining</a>
            </li>
            <li>
                <a href="index.php?page=category_template&categoryid=5" class="">Bedroom</a>
            </li>
            <li>
                <a href="index.php?page=category_template&categoryid=7" class="">Rugs</a>
            </li>
           
            <li>
                <a href="index.php?page=products" class="">On Sale</a>
            </li>
            <li>
                <a href="mailto:#" class="">Contact Us</a>
            </li>
              
        </ul>
    </div>
</header>
<main>
EOT;
}

// Template footer
function template_footer()
{
    echo <<<EOT
</main>
<footer>
    <div class="footer-content">
        <div class="footer-section about">
        <a href="index.php"> <h3>JB Furniture House</h3></a>
            <p>We supply modern home, office, and kitchen furniture at the best price in town. Quality guaranteed.</p>
              
            <div class="socials-links space-x-4">
              <a href="#" target="_blank" rel="noopener noreferrer">
                  <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                      <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
                  </svg>
              </a>

              <a href="#" target="_blank" rel="noopener noreferrer">
                  <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                      <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951" />
                  </svg>
              </a>

              <a href="#" target="_blank" rel="noopener noreferrer">
                  <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                      <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232" />
                  </svg>
              </a>

              <a href="#" target="_blank" rel="noopener noreferrer">
                  <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                      <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z" />
                  </svg>
              </a>
            </div>
        </div>
        
        <div class="footer-section links">
            <h3>Customer Support</h3>
            <ul>
                <li><a href="index.php?page=cart">Sign In</a></li>
                <li><a href="index.php?page=cart">Create Account</a></li>
                <li><a href="mailto:#" class="">Contact Us</a> </li>
            </ul>
        </div>
        
        <div class="footer-section links">
            <h3>Customer Service</h3>
            <ul>
                <li><a href="index.php?page=public/docs/privacy">Privacy Policy</a></li>
                <li><a href="index.php?page=public/docs/delivery">Delivery Policy</a></li>
                <li><a href="index.php?page=public/docs/paypolicy">Payment Policy</a></li>
                <li><a href="index.php?page=public/docs/terms_cond">Terms & Conditions</a></li>
            </ul>
        </div>
    </div>
</footer>
<script src="public/script.js"></script>
<script src="public/product.js"></script>
<script src="public/filter.js"></script>
</body>
</html>
EOT;
}
