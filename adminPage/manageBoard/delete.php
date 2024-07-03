<?php
include '../../connect.php';
session_start();

if ($_SESSION['authority'] != 'admin') {
    ?>
    <script>
        alert("접근 권한이 없습니다");
    </script>
    <?php
    exit();
}

$number = $_GET['number'];
$board = $_GET['board'];

if ($board == "자료실") {
    $sql = "DELETE from r_board where number='$number'";
} else if ($board == "공지사항") {
    $sql = "DELETE from n_board where number = '$number'";
} else if ($board == "질문") {
    $sql = "DELETE from q_board where number = '$number'";
} else {
    $sql = "DELETE from s_board where number = '$number'";
}

$result = mysqli_query($conn, $sql);

if ($result) {
    ?>
    <script>
        alert("게시글이 삭제되었습니다.");
        history.go(-1);
    </script>
    <?php
} else {
    ?>
    <script>
        alert("오류 발생!");
        history.go.(-1);
    </script>
    <?php
}

?>