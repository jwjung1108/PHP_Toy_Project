<?php
include '../../connect.php';
include '../point/WriteCoPoint.php';
include './xss_check.php';

$number = $_GET['number'];
$nickname = $_SESSION['UserName'];
$comment = xss_filter(($_POST['commment']));

$sql = "
    insert into s_comment
    (userid,nickname, boardnumber, comment, created)
    values('$userid','$nickname', '$number','$comment', NOW()
    )";

$result = mysqli_query($conn, $sql);

if ($result === false) {
    echo "저장에 문제가 생겼습니다. 관리자에게 문의해주세요.";
} else {
?>
    <script>
        alert("댓글이 작성되었습니다.");
        history.go(-1);
    </script>
<?php
}
?>