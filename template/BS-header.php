<!-- navbar-->
<header class="header bg-white">
    <div class="container px-0 px-lg-3">
        <nav class="navbar navbar-expand-lg navbar-light py-3 px-lg-0"><a class="navbar-brand" href="../index.php"><span class="font-weight-bold text-uppercase text-dark">ArtDDICT</span></a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <!-- Link--><a class="nav-link" href="index.php">首頁</a>
                    </li>
                    <li class="nav-item">
                        <!-- Link--><a class="nav-link" href="shop.php">商店</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="detail.html">Product detail</a>
                    </li> -->
                    <!-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="pagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pages
                        </a>
                        <div class="dropdown-menu mt-3" aria-labelledby="pagesDropdown">
                            <a class="dropdown-item border-0 transition-link" href="index.html">Homepage</a>
                            <a class="dropdown-item border-0 transition-link" href="shop.html">Category</a>
                            <a class="dropdown-item border-0 transition-link" href="detail.html">Product detail</a>
                            <a class="dropdown-item border-0 transition-link" href="cart.html">Shopping cart</a>
                            <a class="dropdown-item border-0 transition-link" href="checkout.html">Checkout</a>
                        </div>
                    </li> -->
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="myCart.php">
                            <i class="fas fa-dolly-flatbed mr-1 text-gray"></i>
                            購物車
                            <small class="text-gray">
                                (<span id="cartItemNum">
                                    <?php
                                    if (isset($_SESSION["cart"])) {
                                        echo count($_SESSION["cart"]);
                                    } else {
                                        echo 0;
                                    }
                                    ?>
                                </span>)
                            </small></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./loginPage.php">
                            <i class="fas fa-user-alt mr-1 text-gray"></i>
                            登入
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>