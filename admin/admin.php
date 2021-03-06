<?php
require_once '../db.inc.php';
require_once '../checkSession.php';
require_once '../template/admin-html-head.php';
require_once './BS-header-admin.php';
require_once '../template-cart/func-buildTree.php';
require_once '../template-cart/func-getRecursiveCategoryIds.php';
?>


<!-- HERO SECTION-->
<div class="container">
  <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="../images/006.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="../images/003.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="../images/104.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="../images/101.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="../images/002.jpg" class="d-block w-100" alt="...">
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>
<!-- CATEGORIES SECTION-->
<section class="py-5">
  <header class="text-center">
    <p class="small text-muted small text-uppercase mb-1">一同與藝術，共襄盛舉</p>
    <h2 class="h5 text-uppercase mb-4">活動清單</h2>
  </header>
  <!-- 測試區 -->
  <div class="container-fluid">
    <div class="row">
      <?php
      // SQL 敘述
      $sql = "SELECT `id`, `eventName`, `eventDescription`, `eventPrice`, `eventImg`,`eventId`
                    FROM `event` 
                    ORDER BY `id` ASC";

      $stmt = $pdo->query($sql);

      if ($stmt->rowCount() > 0) {
        $arr = $stmt->fetchAll();
        for ($i = 0; $i < count($arr); $i++) {
      ?>
          <div class="col-md-6 mb-4 mb-md-0 py-3 px-5">
            <a class="category-item" href="./eventDetail.php?itemId=<?php echo $arr[$i]['eventId'] ?>">
              <img class="img-fluid" src="./images/<?php echo $arr[$i]['eventImg'] ?>" alt=""><strong><?php echo $arr[$i]['eventName'] ?>
                <a class="text-muted font-weight-normal" href="./edit.php?id=<?php echo $arr[$i]['id']; ?>">編輯 |</a>
                <a class="text-muted font-weight-normal" href="./delete.php?id=<?php echo $arr[$i]['id']; ?>"> 刪除</a></strong>
            </a>
          </div>
      <?php
        }
      }
      ?>
    </div>
  </div>
</section>
<!-- 測試區 -->
<?php require_once '../template/footer.php' ?>
<?php require_once '../template/admin-html-foot.php' ?>