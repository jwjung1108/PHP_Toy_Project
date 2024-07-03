<?php
session_start();

$userid = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : '';
if ($userid == '') {
    ?>
    <script>
        alert("로그인을 해주세요");
        location.href = "../../index.php";
    </script>
    <?php
    exit();
}
?>