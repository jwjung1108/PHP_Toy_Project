<?php
session_start();
include '../../connect.php';

$userid = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : '';
$number = isset($_GET['number']) ? $_GET['number'] : '';

if (empty($number) || empty($userid)) {
    echo "<script> alert('잘못된 접근입니다.'); location.href = 'list_qboard.php'; </script>";
    exit();
}

$stmt = mysqli_prepare($conn, 'SELECT id FROM users WHERE id = (SELECT userid FROM q_board WHERE number = ?)');
mysqli_stmt_bind_param($stmt, 'i', $number);
mysqli_stmt_execute($stmt);
$result = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

if (!$result || ($userid != $result['id'] && $_SESSION['authority'] != "admin")) {
    echo "<script> alert('지정된 사용자가 아닙니다.'); location.href = 'list_qboard.php'; </script>";
    exit();
}

$title = isset($_POST['title']) ? htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8') : '';
$board = isset($_POST['board']) ? htmlspecialchars($_POST['board'], ENT_QUOTES, 'UTF-8') : '';

if (empty($title) || empty($board)) {
    echo "<script> alert('제목과 내용을 모두 입력해주세요.'); location.href = window.history.back(-1); </script>";
    exit();
}

$stmt = mysqli_prepare($conn, "UPDATE q_board SET title = ?, board = ? WHERE number = ?");
mysqli_stmt_bind_param($stmt, "ssi", $title, $board, $number);

if (!mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    echo "<script> alert('저장에 문제가 생겼습니다. 관리자에게 문의해주세요.'); location.href = 'list_qboard.php'; </script>";
    exit();
} else {
    mysqli_stmt_close($stmt);
    echo "<script> alert('게시글이 수정되었습니다.'); location.href = 'list_qboard.php'; </script>";
}
?>
