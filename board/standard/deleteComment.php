<?php
include '../../connect.php';
$number = $_GET['number'];
$boardnumber = $_GET['number'];
$sql = "select userid from s_comment where number= '$number'";
$row = mysqli_fetch_array(mysqli_query($conn, $sql));
$userid = $_SESSION['UserID']
    ?>

<?php
//사용자 권한 확인
session_start();
$userid = $_SESSION['UserID'];

$check_user = "select authority from users where id='$userid'";
$rows = mysqli_fetch_array(mysqli_query($conn, $check_user));

if ($_SESSION['UserID'] != $row['userid']) {
    if ($rows['authority'] != 2) {
        ?>
        <script>
            alert("접근 권한이 없습니다.");
            history.go(-1);
        </script>
        <?php
        exit();
    }
?>
<?php
}

$sql = "DELETE from s_comment where number = '$number'";
$result = mysqli_query($conn, $sql);

if ($result) {
    ?>
    <script>
        alert("댓글이 삭제되었습니다.");
        history.go(-1);
    </script>
    <?php
} else {
    ?>
    <script>
        alert("삭제에 문제가 생겼습니다. 관리자에게 문의해주세요.");
        history.go(-1);
    </script>
    <?php
}
?>