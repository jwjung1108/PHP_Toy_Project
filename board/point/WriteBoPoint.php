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

$sql = "select point from users where id = '$userid'";
$result = mysqli_fetch_array(mysqli_query($conn, $sql));

$point = $result['point'] + 10;

$sql = "update users set point = '$point' where id = '$userid'";
mysqli_query( $conn, $sql);

?>