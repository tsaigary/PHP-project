<?php
require_once('./checkSession.php'); // 引入判斷是否登入機制
require_once('./db.inc.php'); // 引用資料庫連線

// SQL 敘述
$sql = "INSERT INTO `event` 
        (`eventName`, `eventClass`, `eventId`, `eventDescription`, `eventDateStart`, `eventDateEnd`, `eventPrice`, `eventImg`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

if ($_FILES["eventImg"]["error"] === 0) {
    // 為上傳檔案命名
    $strDatetime = date("YmdHis");

    // 找出副檔名
    $extension = pathinfo($_FILES["eventImg"]["name"], PATHINFO_EXTENSION);

    // 建立完整名稱
    $imgFileName = $strDatetime . "." . $extension;

    // 移動暫存檔案到實際存放位置
    $isSuccess = move_uploaded_file($_FILES["eventImg"]["tmp_name"], "./images/" . $imgFileName);

    // 若上傳失敗，則不會繼續往下執行，回到管理頁面
    // if (!$isSuccess) {
    //     header("Refresh: 3; url=./addEvent.php");
    //     echo "圖片上傳失敗";
    //     exit();
    // }
}

// 繫結用陣列
$arr = [
    $_POST['eventName'],
    $_POST['eventClass'],
    $_POST['eventId'],
    $_POST['eventDescription'],
    $_POST['eventDateStart'],
    $_POST['eventDateEnd'],
    $_POST['eventPrice'],
    $imgFileName
];

$stmt = $pdo->prepare($sql);
$stmt->execute($arr);
if ($stmt->rowCount() > 0) {
    header("Location: ./eventList.php");
    echo "新增成功";
} else {
    header("Refresh: 3; url=./addEvent.php");
    echo "新增失敗";
}
