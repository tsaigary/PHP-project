<?php
require_once('./checkSession.php'); // 引入判斷是否登入機制
require_once('./db.inc.php'); // 引用資料庫連線

/**
 * 注意：
 * 
 * 因為要判斷更新時檔案有無上傳，
 * 所以要先對前面/其它的欄位先進行 SQL 語法字串連接，
 * 再針對圖片上傳的情況，給予對應的 SQL 字串和資料繫結設定。
 * 
 */

// 先對其它欄位，進行 SQL 語法字串連接
$sql = "UPDATE `items` 
        SET 
        `itemId` = ?,
        `itemName` = ?, 
        `itemCategoryId` = ?,
        `itemQty` = ?,
        `itemPrice` = ? ";

// 先對其它欄位進行資料繫結設定
$arrParam = [
    $_POST['itemId'],
    $_POST['itemName'],
    $_POST['itemCategoryId'],
    $_POST['itemQty'],
    $_POST['itemPrice']
];

// 判斷檔案上傳是否正常，error = 0 為正常
if ($_FILES["itemImg"]["error"] === 0) {
    // 為上傳檔案命名
    $strDatetime = date("YmdHis");

    // 找出副檔名
    $extension = pathinfo($_FILES["itemImg"]["name"], PATHINFO_EXTENSION);

    // 建立完整名稱
    $itemImg = $strDatetime . "." . $extension;

    // 若上傳成功，則將上傳檔案從暫存資料夾，移動到指定的資料夾或路徑
    if (move_uploaded_file($_FILES["itemImg"]["tmp_name"], "./images/items/" . $itemImg)) {
        /**
         * 刪除先前的舊檔案: 
         * 一、先查詢出特定 id 資料欄位中的大頭貼檔案名稱
         * 二、刪除實體檔案
         * 三、更新成新上傳的檔案名稱
         *  */

        // 先查詢出特定 id (editId) 資料欄位中的大頭貼檔案名稱
        $sqlGetImg = "SELECT `itemImg` FROM `items` WHERE `itemId` = ? ";
        $stmtGetImg = $pdo->prepare($sqlGetImg);

        // 加入繫結陣列
        $arrGetImgParam = [
            (int)$_POST['itemId']
        ];

        // 執行 SQL 語法
        $stmtGetImg->execute($arrGetImgParam);

        // 若有找到 studentImg 的資料
        if ($stmtGetImg->rowCount() > 0) {
            // 取得指定 id 的學生資料 (1筆)
            $arrImg = $stmtGetImg->fetchAll()[0];

            // 若是 studentImg 裡面不為空值，代表過去有上傳過
            if ($arrImg['itemImg'] !== NULL) {
                // 刪除實體檔案
                @unlink("./images/items/" . $arrImg['itemImg']);
            }

            /**
             * 因為前面 `studentDescription` = ? 後面沒有加「,」，
             * 若是這裡會有更新 studentImg 的需要，
             * 代表 `studentDescription` = ? 後面缺一個「,」，
             * 不然會報錯
             */
            $sql .= ",";

            // studentImg SQL 語句字串
            $sql .= "`itemImg` = ? ";

            // 僅對 studentImg 進行資料繫結
            $arrParam[] = $itemImg;
        }
    }
}

// SQL 結尾
$sql .= "WHERE `itemId` = ? ";
$arrParam[] = (int)$_POST['id'];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

if ($stmt->rowCount() > 0) {
    header("Refresh: 1; url=./shop-admin.php");
    echo "更新成功";
} else {
    header("Refresh: 1; url=./shop-admin.php");
    echo "沒有任何更新";
}
