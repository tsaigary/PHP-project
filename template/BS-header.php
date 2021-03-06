<!-- navbar-->
<header class="header bg-white">
    <div class="container px-0 px-lg-3">
        <nav class="navbar navbar-expand-lg navbar-light py-3 px-lg-0"><a class="navbar-brand" href="./index.php"><span class="font-weight-bold text-uppercase text-dark">ArtDDICT</span></a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <!-- Link--><a class="nav-link" href="index.php">首頁</a>
                    </li>
                    <li class="nav-item">
                        <!-- Link--><a class="nav-link" href="shop.php">商店</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <?php if (isset($_SESSION["username"])) { ?>
                        <li class="navbar-nav">
                            <a class="nav-link" href="./order.php">我的訂單</a>
                        </li>
                        <li class="navbar-nav">
                            <a class="nav-link" href="./itemTracking.php">我的最愛</a>
                        </li>
                    <?php } ?>
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
                        <?php require_once("./template/login.php") ?>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>