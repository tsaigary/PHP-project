<?php
session_start();
require_once './db.inc.php';
require_once './template/BS-html-head.php';
require_once './template/BS-header.php';
require_once './template-cart/func-buildTree.php';
require_once './template-cart/func-getRecursiveCategoryIds.php';
?>

<div class="container">
  <!-- HERO SECTION-->
  <section class="py-5 bg-light">
    <div class="container">
      <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
        <div class="col-lg-6">
          <h1 class="h2 text-uppercase mb-0">結帳</h1>
        </div>
        <div class="col-lg-6 text-lg-right">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
              <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
              <li class="breadcrumb-item"><a href="myCart.php">購物車</a></li>
              <li class="breadcrumb-item active" aria-current="page">結帳</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </section>
  <section class="py-5">
    <!-- BILLING ADDRESS-->
    <h2 class="h5 text-uppercase mb-4">Billing details</h2>
    <div class="row">
      <div class="col-lg-8">
        <form action="#">
          <div class="row">
            <div class="col-lg-6 form-group">
              <label class="text-small text-uppercase" for="lastName">姓氏</label>
              <input class="form-control form-control-lg" id="lastName" type="text" placeholder="輸入您的姓氏">
            </div>
            <div class="col-lg-6 form-group">
              <label class="text-small text-uppercase" for="firstName">名字</label>
              <input class="form-control form-control-lg" id="firstName" type="text" placeholder="輸入您的名字">
            </div>
            <div class="col-lg-6 form-group">
              <label class="text-small text-uppercase" for="email">電子郵件</label>
              <input class="form-control form-control-lg" id="email" type="email" placeholder="範例： gary@artddict.com">
            </div>
            <div class="col-lg-6 form-group">
              <label class="text-small text-uppercase" for="phone">電話號碼</label>
              <input class="form-control form-control-lg" id="phone" type="tel" placeholder="範例：02 2345 6789">
            </div>
            <div class="col-lg-6 form-group">
              <label class="text-small text-uppercase" for="company">公司名稱 (選填)</label>
              <input class="form-control form-control-lg" id="company" type="text" placeholder="您的公司名稱">
            </div>
            <div class="col-lg-6 form-group">
              <label class="text-small text-uppercase" for="country">國家</label>
              <select class="selectpicker country" id="country" data-width="fit" data-style="form-control form-control-lg" data-title="選擇您的國家"></select>
            </div>
            <div class="col-lg-12 form-group">
              <label class="text-small text-uppercase" for="address">郵寄地址</label>
              <input class="form-control form-control-lg" id="address" type="text" placeholder="範例：台北市北投區大度路1號">
            </div>
            <div class="col-lg-6 form-group">
              <label class="text-small text-uppercase" for="city">鄉鎮/區域</label>
              <input class="form-control form-control-lg" id="city" type="text">
            </div>
            <div class="col-lg-6 form-group">
              <label class="text-small text-uppercase" for="state">城市/國家</label>
              <input class="form-control form-control-lg" id="state" type="text">
            </div>
            <!-- <div class="col-lg-6 form-group">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" id="alternateAddressCheckbox" type="checkbox">
                <label class="custom-control-label text-small" for="alternateAddressCheckbox">Alternate billing address</label>
              </div>
            </div> -->
            <div class="col-lg-12 form-group mt-2">
              <button class="btn btn-dark" type="submit">Place order</button>
            </div>
          </div>
        </form>
      </div>
      <!-- ORDER SUMMARY-->

      <div class="col-lg-4">
        <div class="card border-0 rounded-0 p-lg-4 bg-light">
          <div class="card-body">
            <h5 class="text-uppercase mb-4">Your order</h5>
            <ul class="list-unstyled mb-0">
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

                  <li class="d-flex align-items-center justify-content-between mb-1"><strong class="small font-weight-bold"><?php echo $arr[$i]["itemName"] ?></strong><span class="text-muted small">$<?php echo $arr[$i]["itemPrice"] ?></span></li>
              <?php
                }
              }
              ?>
              <li class="border-bottom my-3"></li>
              <li class="d-flex align-items-center justify-content-between"><strong class="text-uppercase small font-weight-bold">總計</strong><span>$<?php echo $total ?></span></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

  </section>
</div>
<?php require_once './template/footer.php' ?>
<?php require_once './template/BS-html-foot.php' ?>