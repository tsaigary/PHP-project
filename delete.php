<?php
require_once('./checkSession.php'); // 引入判斷是否登入機制
require_once('./db.inc.php'); // 引用資料庫連線
// -------------------------刪除頭像檔案--------------------------- //

// 先查詢出特定 id (editId) 資料欄位中的大頭貼檔案名稱
$sqlGetImg = "SELECT `itemImg` FROM `items` WHERE `itemId` = ? ";
$stmtGetImg = $pdo->prepare($sqlGetImg);

// 加入繫結陣列
$arrGetImgParam = [
    (int)$_GET['itemId']
];

// 執行 SQL 語法
$stmtGetImg->execute($arrGetImgParam);

// 若有找到 studentImg 的資料
if ($stmtGetImg->rowCount() > 0) {
    // 取得指定 id 的學生資料 (1筆)
    $arrImg = $stmtGetImg->fetchAll()[0];

    // 若是 studentImg 裡面不為空值，代表過去有上傳過
    if ($arrImg['itemImg'] !== NULL) {
        // unlink刪除實體檔案,如果找不到檔案會報錯
        // @unlink刪除實體檔案,不會報錯,找到檔案就刪除
        @unlink("./images/items/" . $arrImg['itemImg']);
    }
}

// -------------------------刪除整筆個人資料--------------------------- //

// SQL刪除語法
$sql = "DELETE FROM `items` WHERE `itemId` = ? ";

// 加入繫結陣列
// 用GET取得id
$arrParam = [
    (int)$_GET['itemId']
];

// 防止透過SQL Injerction滲透
$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

if ($stmt->rowCount() > 0) {
    header("Refresh: 1; url=./shop-admin.php");
    echo "刪除成功";
} else {
    header("Refresh: 1; url=./shop-admin.php");
    echo "刪除失敗";
}
