<?php
include '../../connect.php';
include '../point/WriteCoPoint.php';
session_start();

$nickname = $_SESSION['UserName'];

$number = $_GET['number'];
$sql = "
    insert into r_comment
    (userid, nickname, boardnumber, comment, created)
    values('$userid', '$nickname', '$number','{$_POST['comment']}', NOW())";

$result = mysqli_query($conn, $sql);

if ($result === false) {
    echo "저장에 문제가 생겼습니다. 관리자에게 문의해주세요.";
} else {
?>
    <script>
        alert("댓글이 작성되었습니다.");
        location.href = "r_readBoard.php?number=<?php echo $number?>";
    </script>
<?php
}
?>