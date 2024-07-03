<?php
include '../../connect.php';

session_start();
$userid = $_SESSION['UserID'];

$number = $_GET['number'];

$stmt = mysqli_prepare($conn,'SELECT userid FROM r_comment WHERE number = ?');
mysqli_stmt_bind_param( $stmt,'i',$number);
mysqli_execute($stmt);
$result = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);  

if ($result['userid'] != $userid) {
    if ($_SESSION['authority'] != 'admin') {
        ?>
        <script>
            alert("접근 권한이 없습니다.");
            history.go(-1);
        </script>
        <?php
        exit();
    }
}

$stmt = mysqli_prepare($conn,'DELETE FROM r_comment WHERE number = ?');
mysqli_stmt_bind_param( $stmt,'i',$number);

if (mysqli_execute($stmt)) {
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