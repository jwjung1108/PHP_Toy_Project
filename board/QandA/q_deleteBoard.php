<?php
include '../../connect.php';
session_start();
?>

<?php
// 사용자 권한 확인
$userid = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : '';
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <!-- 필요한 헤더 정보 추가 -->
</head>

<body>
    <?php
    $number = $_GET['number'];

    // 댓글 존재 여부 확인
    $stmt = mysqli_prepare($conn, 'SELECT COUNT(*) FROM q_comment WHERE boardnumber = ?');
    mysqli_stmt_bind_param($stmt, 'i', $number);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $comment_count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($comment_count > 0) {
        echo "<script>
                alert('댓글이 존재하므로 삭제가 불가능합니다.');
                location.href = './list_qboard.php';
              </script>";
        exit();
    }

    // 게시글 작성자 확인
    $stmt = mysqli_prepare($conn, "SELECT userid FROM q_board WHERE number = ?");
    mysqli_stmt_bind_param($stmt, "i", $number);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $post_userid);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // 삭제 권한 확인
    if ($userid != $post_userid && $_SESSION['authority'] != "admin") {
        echo "<script>
                alert('접근 권한이 없습니다.');
                location.href = './list_qboard.php';
              </script>";
        exit();
    }

    // 게시글 삭제
    $stmt = mysqli_prepare($conn, "DELETE FROM q_board WHERE number = ?");
    mysqli_stmt_bind_param($stmt, "i", $number);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    echo "<script>
            alert('게시글이 삭제되었습니다.');
            location.href = 'list_qboard.php';
          </script>";
    ?>
</body>

</html>
