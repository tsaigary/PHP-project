<?php
//建立種類列表
function buildTree($pdo, $parentId = 0)
{
    $sql = "SELECT `categoryId`, `categoryName`, `categoryParentId`
            FROM `categories` 
            WHERE `categoryParentId` = ?";
    $stmt = $pdo->prepare($sql);
    $arrParam = [$parentId];
    $stmt->execute($arrParam);
    if ($stmt->rowCount() > 0) {
        echo '<ul class="list-unstyled small text-muted pl-lg-4 font-weight-normal mb-5">';
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for ($i = 0; $i < count($arr); $i++) {
            echo '<li class="mb-2">';
            echo "<a class='reset-anchor' href='./itemList.php?categoryId={$arr[$i]['categoryId']}'>{$arr[$i]['categoryName']}</a>";
            buildTree($pdo, $arr[$i]['categoryId']);
            echo "</li>";
        }
        echo "</ul>";
    }
}
