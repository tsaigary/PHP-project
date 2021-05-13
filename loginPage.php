<?php
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
          <h1 class="h2 text-uppercase mb-0">LOGIN</h1>
        </div>
        <div class="col-lg-6 text-lg-right">

        </div>
      </div>
    </div>
  </section>
  <section class="py-5">
    <!-- BILLING ADDRESS-->
    <h2 class="h5 text-uppercase mb-4">輸入帳號密碼</h2>
    <div class="row">
      <div class="col-lg-8">
        <form name="myForm" method="post" action="./login.php">
          <div class="row">
            <div class="col-lg-6 form-group">
              <label class="text-small text-uppercase" for="firstName">帳號</label>
              <input class="form-control form-control-lg" name="username" id="firstName" type="text" placeholder="請輸入帳號">
            </div>
            <div class="col-lg-6 form-group">
              <label class="text-small text-uppercase" for="lastName">密碼</label>
              <input class="form-control form-control-lg" name="pwd" id="lastName" type="password" placeholder="請輸入密碼">
            </div>
            <div class="col-lg-12 form-group">
              <input class="btn btn-dark" type="submit" value="登入">
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>
<?php require_once './template/footer.php' ?>
<?php require_once './template/BS-html-foot.php' ?>