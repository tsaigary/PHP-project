<?php
// 啟動 session
session_start();

// 引用資料庫連線
// require_once會讀取或跳轉到括弧內網址一次,也可以寫成 require_once './db.inc.php'
require_once('./db.inc.php');

if (isset($_POST['username']) && isset($_POST['pwd'])) {
    //1-Admin判斷(from admin)
    $sql = "SELECT `username`, `pwd` 
            FROM `admin` 
            WHERE `username` = ? 
            AND `pwd` = ? ";
    //可共用(使用者輸入資料)
    $arrParam = [
        $_POST['username'],
        sha1($_POST['pwd'])
    ];

    $pdo_stmt = $pdo->prepare($sql); // prepare 新增跳脫字元讓之後程式判讀特殊字元為字串
    $pdo_stmt->execute($arrParam); // execute 執行前面prepare模擬好的狀態

    if ($pdo_stmt->rowCount() > 0) {
        // 將傳送過來的 post 變數資料，放到 session，
        $_SESSION['username'] = $_POST['username'];
        // 3秒後跳頁
        header("Refresh: 1; url=./admin.php");
        // echo "登入成功!!! 1秒後自動進入後端頁面";
        // require_once('templates/login_success.html');

        //admin登入成功
    } else {
        //user判斷(代表admin登入失敗)
        // SQL 語法,?讓pdo處理後續程式(data finding 資料細節)
        $sql_users = "SELECT `username`, `pwd` 
                FROM `users` 
                WHERE `username` = ? 
                AND `pwd` = ? ";

        $pdo_stmt_users = $pdo->prepare($sql_users); // prepare 新增跳脫字元讓之後程式判讀特殊字元為字串
        $pdo_stmt_users->execute($arrParam); // execute 執行前面prepare模擬好的狀態

        if ($pdo_stmt_users->rowCount() > 0) {
            // 將傳送過來的 post 變數資料，放到 session，
            $_SESSION['username'] = $_POST['username'];
            // 3秒後跳頁
            header("Refresh: 1; url=./index.php");
            // echo "登入成功!!! 1秒後自動進入後端頁面";
            // require_once('templates/login_success.html');
        } else {
            session_destroy();

            header("Refresh: 3; url=./index.php");
            echo "登入失敗…3秒後自動回登入頁";
        }
    }
} else {
    // 關閉session
    session_destroy();

    header("Refresh: 3; url=./index.php");
    echo "請確實登入…3秒後自動回登入頁";
}
