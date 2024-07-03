<?php
include '../../connect.php';

session_start();
$userid = $_SESSION['UserID'];

if ($_SESSION['authority'] != "admin") {
    ?>
    <script>
        alert("접근 권한이 없습니다.");
        location.href = "./list_qboard.php";
    </script>
    <?php
    exit();
}

$number = $_GET['number'];

$stmt = mysqli_prepare($conn,'DELETE FROM q_comment WHERE number = ?');

mysqli_stmt_bind_param($stmt,'i', $number);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    ?>
    <script>
        alert("댓글이 삭제되었습니다.");
        history.go(-1);
    </script>
    <?php
} else {
    mysqli_stmt_close($stmt);
    ?>
    <script>
        alert("댓글 삭제에 실패하였습니다.");
        history.go(-1);
    </script>
    <?php
}
?>
