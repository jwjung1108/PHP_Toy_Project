<?php
session_start();
$userid = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : '';
include '../../connect.php';

if ($_SESSION['authority'] != 'admin') {
    ?>
    <script>
        alert("지정된 사용자가 아닙니다.");
        location.href = "./list_nboard.php";
    </script>
    <?php
    exit();
}

$stmt = mysqli_prepare($conn, "UPDATE n_board SET title = ?, board = ? WHERE number = ?");

if (!$stmt) {
    echo "<script> alert('SQL 연동 오류');";
    echo "location.href = 'list.nboard.php'; </script>";
    exit();
}

mysqli_stmt_bind_param($stmt, 'ssi', $_POST['title'], $_POST['board'], $_GET['number']);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    ?>
    <script>
        alert("게시글이 수정되었습니다.");
        location.href = "list_nboard.php";
    </script>
    <?php
}
else{
    mysqli_stmt_close($stmt);
    echo '<script> alert("저장에 문제가 생겼습니다. 관리자에게 문의해주세요.");';
    echo 'location.href = "list_nboard"; </script>';
    exit();
}
?>