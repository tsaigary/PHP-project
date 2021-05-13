<?php
session_start();
require_once('./db.inc.php');
require_once('./template/BS-html-head.php');
require_once('./template/BS-header.php');
require_once './template-cart/func-buildTree.php';
// require_once("./tpl/func-getRecursiveCategoryIds.php");
?>
<form name="myForm" method="POST" action="./addOrder.php">

    <div class="container">
        <!-- HERO SECTION-->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                    <div class="col-lg-6">
                        <h1 class="h2 text-uppercase mb-0">購物車</h1>
                    </div>
                    <div class="col-lg-6 text-lg-right">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Cart</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-5">
            <h2 class="h5 text-uppercase mb-4">Shopping cart</h2>
            <div class="row">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <!-- CART TABLE-->
                    <div class="table-responsive mb-4">
                        <table class="table">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0" scope="col"> <strong class="text-small text-uppercase">商品名稱</strong></th>
                                    <th class="border-0" scope="col"> <strong class="text-small text-uppercase">價格</strong></th>
                                    <th class="border-0" scope="col"> <strong class="text-small text-uppercase">數量</strong></th>
                                    <th class="border-0" scope="col"> <strong class="text-small text-uppercase">小計</strong></th>
                                    <th class="border-0" scope="col"> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //放置結合當前資料庫資料的購物車資訊
                                $arr = [];

                                $total = 0;

                                if (isset($_SESSION["cart"]) && count($_SESSION["cart"]) > 0) {
                                    //重新排序索引
                                    $_SESSION["cart"] = array_values($_SESSION["cart"]);

                                    //SQL 敘述
                                    $sql = "SELECT `items`.`itemId`, `items`.`itemName`, `items`.`itemImg`, `items`.`itemPrice`, `items`.`itemQty`, `items`.`itemCategoryId`, `items`.`created_at`, `items`.`updated_at`, `categories`.`categoryId`, `categories`.`categoryName`
                                    FROM `items` INNER JOIN `categories`
                                    ON `items`.`itemCategoryId` = `categories`.`categoryId`
                                    WHERE `itemId` = ? ";

                                    for ($i = 0; $i < count($_SESSION["cart"]); $i++) {
                                        $arrParam = [
                                            (int)$_SESSION["cart"][$i]["itemId"]
                                        ];

                                        //查詢
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute($arrParam);

                                        //若商品項目個數大於 0，則列出商品
                                        if ($stmt->rowCount() > 0) {
                                            $arrTmp = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
                                            $arrTmp['cartQty'] = $_SESSION["cart"][$i]["cartQty"];
                                            $arr[] = $arrTmp;
                                        }
                                    }

                                    for ($i = 0; $i < count($arr); $i++) {
                                        //計算總額
                                        $total += $arr[$i]["itemPrice"] * $arr[$i]["cartQty"];
                                ?>
                                        <tr>
                                            <th class="pl-0 border-0" scope="row">
                                                <div class="media align-items-center">
                                                    <a class="reset-anchor d-block animsition-link" href="detail.html">
                                                        <img src="./images/items/<?php echo $arr[$i]["itemImg"] ?>" alt="" width="70" class="img-fluid rounded shadow-sm">
                                                    </a>
                                                    <div class="media-body ml-3">
                                                        <strong class="h6">
                                                            <a href="#" class="text-dark d-inline-block align-middle"><?php echo $arr[$i]["itemName"] ?></a>
                                                        </strong>
                                                    </div>
                                                </div>
                                            </th>
                                            <td class="align-middle border-0">
                                                <p class="mb-0 small">$<?php echo $arr[$i]["itemPrice"] ?></p>
                                            </td>
                                            <td class="align-middle border-0">
                                                <div class="border d-flex align-items-center justify-content-between px-3"><span class="small text-uppercase text-gray headings-font-family">數量</span>
                                                    <div class="quantity">
                                                        <button class="dec-btn p-0"><i class="fas fa-caret-left"></i></button>
                                                        <input class="form-control form-control-sm border-0 shadow-0 p-0" type="text" value="<?php echo $arr[$i]["cartQty"] ?>" />
                                                        <button class="inc-btn p-0"><i class="fas fa-caret-right"></i></button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle border-0">
                                                <p class="mb-0 small"><?php echo ($arr[$i]["itemPrice"] * $arr[$i]["cartQty"]) ?></p>
                                            </td>
                                            <td class="align-middle border-0"><a class="reset-anchor" href="./deleteCart.php?idx=<?php echo $i ?>"><i class="fas fa-trash-alt small text-muted"></i></a></td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- CART NAV-->
                    <div class="bg-light px-4 py-3">
                        <div class="row align-items-center text-center">
                            <div class="col-md-6 mb-3 mb-md-0 text-md-left"><a class="btn btn-link p-0 text-dark btn-sm" href="shop.php"><i class="fas fa-long-arrow-alt-left mr-2"> </i>Continue shopping</a></div>
                            <div class="col-md-6 text-md-right"><a class="btn btn-outline-dark btn-sm" href="checkout.html">Procceed to checkout<i class="fas fa-long-arrow-alt-right ml-2"></i></a></div>
                        </div>
                    </div>
                </div>
                <!-- ORDER TOTAL-->
                <div class="col-lg-4">
                    <div class="card border-0 rounded-0 p-lg-4 bg-light">
                        <div class="card-body">
                            <h5 class="text-uppercase mb-4">Cart total</h5>
                            <ul class="list-unstyled mb-0">
                                <li class="d-flex align-items-center justify-content-between"><strong class="text-uppercase small font-weight-bold">Subtotal</strong><span class="text-muted small">$<?php echo $total ?></span></li>
                                <li class="border-bottom my-2"></li>
                                <li class="d-flex align-items-center justify-content-between mb-4"><strong class="text-uppercase small font-weight-bold">Total</strong><span>$<?php echo $total ?></span></li>
                                <li>
                                    <form action="#">
                                        <div class="form-group mb-0">
                                            <input class="form-control" type="text" placeholder="Enter your coupon">
                                            <button class="btn btn-dark btn-sm btn-block" type="submit"> <i class="fas fa-gift mr-2"></i>Apply coupon</button>
                                        </div>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

</form>

<?php
require_once('./template/footer.php');
require_once('./template/BS-html-foot.php');
?>