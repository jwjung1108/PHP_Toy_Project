<?php
include '../../connect.php';
?>

<?php
//사용자 권한 확인
session_start();
$userid = $_SESSION['UserID'];

if($_SESSION['authority'] != 'admin'){
    ?>
    <script>
        alert("지정된 사용자가 아닙니다.");
        location.href = "list_nboard.php";
    </script>
    <?php
    exit();
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
</head>

<body>
    <?php
    $number = $_GET['number'];

    $sql = "delete from n_board where number = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        echo "<script> alert('SQL 준비에 실패했습니다'); ";
        echo "location.href = 'list_board.php'; </script>";
        exit();
    }

    mysqli_stmt_bind_param($stmt, 'i', $number);

    if(mysqli_stmt_execute($stmt)){
        echo '<script>';
        echo 'alert("게시글이 삭제되었습니다.");';
        echo 'location.href = list_nboard.php;';
        echo '</script>';

        mysqli_stmt_close($stmt);
    }
    else{
        echo '<script> alert("삭제에 문제가 생겼습니다. 관리자에게 문의해주세요.");';
        echo 'location.href = "list_nboard.php"; </script>';
        
        mysqli_stmt_close($stmt);
        exit();
    }
    
?>
</body>

</html>