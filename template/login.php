<!-- <span class="ml-3 mr-3"> | </span> -->
<?php if (!isset($_SESSION["username"])) { ?>
    <a class="nav-link" href="./loginPage.php">
        <i class="fas fa-user-alt mr-1 text-gray"></i>
        登入
    </a>
<?php } else { ?>
    <a class="nav-link" href="../logout.php?logout=1">
        <i class="fas fa-user-alt mr-1 text-gray"></i>
        登出
    </a>
<?php } ?>