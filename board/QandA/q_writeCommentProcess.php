<?php
include '../../connect.php';
include '../point/WriteCoPoint.php';
session_start();
$userid = $_SESSION['UserID'];
$nickname = $_SESSION['UserName'];

$stmt = mysqli_prepare($conn, 'SELECT * FROM users WHERE id = ?');
mysqli_stmt_bind_param($stmt, 's', $userid);
mysqli_stmt_execute($stmt);
$result = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

if ($result['authority'] != 2) {
    ?>
    <script>
        alert("권한이 없습니다.");
        location.href = "./list_qboard.php";
    </script>
    <?php
    exit();
}

$number = $_GET['number'];

$stmt = mysqli_prepare($conn, 'INSERT INTO q_comment(userid, nickname, boardnumber, comment, created) values (?, ?, ?, ?, NOW())');
mysqli_stmt_bind_param($stmt,'ssis', $userid, $nickname, $number, $_POST['comment']);

if (!mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    echo "<script> alert('저장에 문제가 생겼습니다. 관리자에게 문의해주세요.'); location.href = 'list_qboard.php'; </script>";
    exit();
} else {
    mysqli_stmt_close($stmt);
    echo "<script> alert('댓글이 작성되었습니다.'); location.href = 'list_qboard.php'; </script>";
}
?>