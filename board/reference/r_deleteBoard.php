<?php
include '../../connect.php';
session_start();
?>

<?php
// 사용자 권한 확인
$userid = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : '';

$stmt = mysqli_prepare($conn,'SELECT authority FROM users WHERE id = ?');
mysqli_stmt_bind_param($stmt,'s', $userid);
mysqli_stmt_execute($stmt);

$row = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

?>

<!DOCTYPE html>
<html lang="ko">

<head>
</head>

<body>
    <?php
    $number = $_GET['number'];
    $stmt = mysqli_prepare($conn,'SELECT userid FROM r_board WHERE userid = ? AND number = ?');
    mysqli_stmt_bind_param($stmt,'si', $userid, $number);
    mysqli_execute($stmt);
    $result = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);

    if ($userid != $result['userid']) {
        if ($row['authority'] == 2) {

            $stmt = mysqli_prepare($conn, 'DELETE FROM r_board WHERE number = ?');
            mysqli_stmt_bind_param($stmt,'i', $number);
            mysqli_execute($stmt);
            mysqli_stmt_close($stmt);
            ?>

            <script>
                alert("게시글이 삭제되었습니다.");
                location.href = "list_rboard.php";
            </script>
        <?php } ?>
        <script>
            alert("접근 권한이 없습니다.");
            location.href = "list_rboard.php";
        </script>
        <?php
        exit();
        
    } else {
            $stmt = mysqli_prepare($conn, 'DELETE FROM r_board WHERE number = ?');
            mysqli_stmt_bind_param($stmt,'i', $number);
            mysqli_execute($stmt);
            mysqli_stmt_close($stmt);
        ?>
        <script>
            alert("게시글이 삭제되었습니다.");
            location.href = "list_rboard.php";
        </script>
        <?php
    }
    ?>
</body>

</html>