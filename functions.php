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
    <link rel="stylesheet" href="public/secondary_styles.css"/>
    <link rel="stylesheet" href="public/extra.css"/>
    <link rel="stylesheet" href="public/footer.css"/>
	</head>
	<body>
        <header class="mt-3 px-4 container mx-auto max-w-screen-2xl flex justify-between items-center"
        >
          <div class="flex justify-around items-center space-x-6 ">
          <a href="index.php" class=""><h1 class="text-custom-orange text-2xl">JB Furniture House</h1></a>
            <div class="hidden space-x-6 lg:flex">
              <a href="index.php?page=category_template&categoryid=3" class="">Living Room</a>
              <a href="index.php?page=category_template&categoryid=2" class="">Dining</a>
              <a href="index.php?page=category_template&categoryid=5" class="">Bedroom</a>
              <a href="index.php?page=category_template&categoryid=6" class="">Office</a>
              <a href="#" class="">Decor</a>
              <a href="index.php?page=products" style="color:red; font-weight: bold;">On Sale</a>
            </div>
          </div>
          <div class="flex justify-around items-center space-x-4">
            <a
              class="hidden bg-black rounded-full text-white text-center py-2 px-5 lg:block"
              href="#"
            >
              Contact us
            </a>
            <a>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="26"
              height="26"
              fill="currentColor"
              class="bi bi-search"
              viewBox="0 0 16 16"
            >
              <path
                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"
              />
            </svg>
            </a>

            <a href="index.php?page=cart">
            <div style="display: flex; align-items: center;">
              <i class="fas fa-shopping-cart"></i>
              <span style="display: inline-block; padding: 0px 8px;border-radius: 50%; background-color: #e2a011; color: white; margin-left: 5px; ">
              $num_items_in_cart
              </span>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="26"
                height="26"
                fill="currentColor"
                class="bi bi-bag"
                viewBox="0 0 16 16"
              >
                <path
                  d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"
                />
              </svg>
            </div>
          </a>
            <input id="menu-toggle" type="checkbox" />
            <label class="menu-button-container" for="menu-toggle">
              <div class="menu-button"></div>
            </label>
            <ul class="menu">
            <li>
                <a "href="index.php" class="">Home</a>
              </li>
              <li>
                <a href="#" class="">Living Room</a>
              </li>
              <li>
                <a href="#" class="">Dining</a>
              </li>
              <li>
                <a href="#" class="">Bedroom</a>
              </li>
              <li>
                <a href="#" class="">Office</a>
              </li>
              <li>
                <a href="#" class="">Decor</a>
              </li>
              <li>
                <a href="index.php?page=products" class="">On Sale</a>
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
              <h3>JB Furniture House</h3>
              <p>We supply modern home, office, and kitchen furniture at the best price in town. Quality guaranteed.</p>
          </div>
          <div class="footer-section links">
              <h3>Customer Support</h3>
              <ul>
                  <li><a href="index.php?page=cart">Sign in</a></li>
                  <li><a href="index.php?page=cart">Create account</a></li>
                  <li><a href="#">Account details</a></li>
            
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
?>