<?php
include '../../connect.php';
?>

<?php
//사용자 권한 확인
session_start();
$userid = $_SESSION['UserID'];

if ($_SESSION['authority'] != 'admin') {
    ?>
    <script>
        alert("지정된 사용자가 아닙니다.");
        location.href = "./list_nboard.php";
    </script>
    <?php
    exit();
}
?>

<!DOCTYPE html>
<html lang="ko">
<?php include '../../header.php'; ?>

<body class="is-preload">

    <!-- Wrapper -->
    <div id="wrapper" class="fade-in">


        <?php include '../../nav.php'; ?>

        <!-- Main -->
        <div id="main">



            <!-- Posts -->
            <section class="post">
                <?php
                $sql = "SELECT authority FROM users WHERE id= ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt,"s", $userid);
                mysqli_stmt_execute($stmt);
                $check = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                mysqli_stmt_close($stmt);

                if ($check['authority'] == 2) {
                    ?><a href="n_writeForm.php">작성</a>
                    <?php
                }
                ?>
                <?php

                $number = $_GET['number'];
                $stmt = mysqli_prepare($conn,'SELECT * FROM n_board WHERE number = ?');
                mysqli_stmt_bind_param($stmt,'s', $number);
                mysqli_stmt_execute($stmt);
                $row = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                
                mysqli_stmt_close($stmt); 
                $title = $row['title'];
                $board = $row['board'];
                ?>


                <form action='n_replaceProcess.php?number=<?php echo $number ?>' method="POST">
                    <p><input type="title" style="appearance: none;" name="title" value=<?php echo $title ?>></p>
                    <p><textarea name="board" cols="50" rows="10"><?php echo $board ?></textarea></p>
                    <p><input type="submit" value="수정"></p>
                </form>
            </section>
        </div>


        <?php include '../../footer.php'; ?>

    </div>

    <!-- Scripts -->
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/jquery.scrollex.min.js"></script>
    <script src="/assets/js/jquery.scrolly.min.js"></script>
    <script src="/assets/js/browser.min.js"></script>
    <script src="/assets/js/breakpoints.min.js"></script>
    <script src="/assets/js/util.js"></script>
    <script src="/assets/js/main.js"></script>

</body>

</html>