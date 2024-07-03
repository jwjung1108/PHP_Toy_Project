<?php
// mysql 연결
include '../connect.php';
session_start();

// 사용자 권한 확인
$check_authority = $_SESSION['authority'];

if ($check_authority != 'admin') {
    ?>
    <script>
        alert("접근 권한이 없습니다.");
        location.href = "/";
        
    </script>
    <?php
    exit();
}
?>

