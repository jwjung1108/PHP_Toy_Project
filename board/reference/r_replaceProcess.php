<?php
session_start();
$userid = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : '';
include '../../connect.php';

if ($userid == '') {
    ?>
    <script>
        alert("로그인을 해주세요");
        location.href = "../../index.php";
    </script>
    <?php
    exit();
}


$userid = htmlspecialchars($userid);
$check_user = "SELECT userid FROM r_board WHERE userid = '$userid' AND number = '{$_GET['number']}'";
$result = mysqli_fetch_array(mysqli_query($conn, $check_user));

if ($userid != $result['userid']) {
    if ($check_authority['authority'] != 2) {
?>
                        <script>
                            alert("접근 권한이 없습니다.");
                            location.href = "list_rboard.php";
                        </script>
<?php
        exit();
    }
}

$title = htmlspecialchars($_POST['title']);
$board = htmlspecialchars($_POST['board']);

$sql = "update r_board set title ='$title', board='$board' where number = '{$_GET['number']}' and userid = '$userid'";

$result = mysqli_query($conn, $sql);

if ($result === false) {
    echo "저장에 문제가 생겼습니다. 관리자에게 문의해주세요.";
} else {
?>
    <script>
        alert("게시글이 수정되었습니다.");
        location.href = "list_rboard.php";
    </script>
<?php
}
?>