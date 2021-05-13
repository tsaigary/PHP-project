<?php
require_once '../checkSession.php';
require_once '../db.inc.php';
require_once '../template/BS-html-head.php';
require_once './BS-header-admin.php';
require_once '../template-cart/func-buildTree.php';
require_once '../template-cart/func-getRecursiveCategoryIds.php'
?>
<div class="container">
    <!-- HERO SECTION------------------------------------------------>
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 text-uppercase mb-0">Create Event</h1>
                </div>

            </div>
        </div>
    </section>
    <section class="py-5">
        <!-- BILLING ADDRESS-->
        <h2 class="h5 text-uppercase mb-4">活動資料</h2>
        <div class="row">
            <div class="col-lg-8">
                <form name="myForm" method="POST" action="./insert.php" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label class="text-small text-uppercase" for="firstName">活動名稱</label>
                            <input class="form-control form-control-lg" id="eventName" name="eventName" type="text" placeholder="輸入名稱">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label class="text-small text-uppercase" for="lastName">活動類別</label>
                            <input class="form-control form-control-lg" id="eventClass" name="eventClass" type="text" placeholder="類別C/D">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label class="text-small text-uppercase">活動編號</label>
                            <input class="form-control form-control-lg" id="eventId" name="eventId" type="text" placeholder="三碼編號，展覽0開頭，工作坊1開頭">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label class="text-small text-uppercase" for="phone">活動描述</label>
                            <input class="form-control form-control-lg" id="eventDescription" name="eventDescription" type="text" placeholder="描述活動">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label class="text-small text-uppercase" for="company">開始日期</label>
                            <input class="form-control form-control-lg" id="eventDateStart" name="eventDateStart" type=" text" placeholder="yyyy-mm-dd">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label class="text-small text-uppercase" for="company">結束日期</label>
                            <input class="form-control form-control-lg" id="eventDateEnd" name="eventDateEnd" type=" text" placeholder="yyyy-mm-dd">
                        </div>
                        <div class="col-lg-12 form-group">
                            <label class="text-small text-uppercase" for="address">活動票價</label>
                            <input class="form-control form-control-lg" id="eventPrice" name="eventPrice" type="text" placeholder="輸入整數值不含字元">
                        </div>
                        <div class="col-lg-12 form-group">
                            <label class="text-small text-uppercase" for="address">上傳圖片</label>
                            <input class="form-control form-control-lg" type="file" name="eventImg">
                        </div>

                        <div class="col-lg-12 form-group">
                            <input class="btn btn-dark" type="submit" name="smb" value="建立">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<?php require_once '../template/footer.php' ?>
<?php require_once '../template/BS-html-foot.php' ?>