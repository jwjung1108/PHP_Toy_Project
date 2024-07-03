<?php
include '../../connect.php';
session_start();
?>

<?php
// 사용자 권한 확인
$userid = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : '';

$sql = "SELECT authority FROM users WHERE id='$userid'";
$row = mysqli_fetch_array(mysqli_query($conn, $sql));

?>

<!DOCTYPE html>
<html lang="ko">

<head>
</head>

<body>
    <?php
    $number = $_GET['number'];
    $check_user = "SELECT userid FROM s_board WHERE userid = '$userid' AND number = '$number'";
    $result = mysqli_fetch_array(mysqli_query($conn, $check_user));

    if ($userid != $result['userid']) {
        if ($row['authority'] != 2) {
            ?>
            <script>
                alert("접근 권한이 없습니다.");
                location.href = "list_board.php";
            </script>
            <?php
            exit();
        }
        $sql = "DELETE from s_board WHERE number = '$number'";
        mysqli_query($conn, $sql);
        ?>
    <script>
        alert("게시글이 삭제되었습니다.");
        location.href = "list_board.php";
    </script>
    <?php
    ?>
    <?php
    } else {
        $sql = "DELETE from s_board WHERE number = '$number'";
        mysqli_query($conn, $sql);
        ?>
        <script>
            alert("게시글이 삭제되었습니다.");
            location.href = "list_board.php";
        </script>
        <?php
    }
    ?>
</body>

</html>