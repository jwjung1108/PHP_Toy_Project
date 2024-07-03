<?php
include '../../connect.php';

session_start();

$userid = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : '';
if ($userid == '') {
    ?>
    <script>
        alert("로그인을 해주세요");
        location.href = "../index.php";
    </script>
    <?php
    exit();
}


$number = $_GET['number'];

$row = mysqli_fetch_array(mysqli_query($conn, "select * from s_board where number= '$number' and userid = '$userid'"));
$title = $row['title'];
$board = $row['board'];

$check_authority = mysqli_fetch_array(mysqli_query($conn, "SELECT authority FROM users WHERE id='$userid'"));
?>

<!DOCTYPE html>
<html lang="ko">

<?php include '../../header.php'; ?>

<body class="is-preload">

    <!-- Wrapper -->
    <div id="wrapper" class="fade-in">


        <!-- Header -->
        <?php include '../../nav.php'; ?>

        <!-- Main -->
        <div id="main">



            <!-- Posts -->
            <section class="post">
                <?php
                $check_user = "SELECT userid FROM s_board WHERE userid = '$userid' AND number = '$number'";
                $result = mysqli_fetch_array(mysqli_query($conn, $check_user));

                if ($userid != $result['userid']) {
                    if ($check_authority['authority'] != 2) {
                        ?>
                        <script>
                            alert("접근 권한이 없습니다.");
                            location.href = "list_board.php";
                        </script>
                        <?php
                        exit();
                    }
                    ?>
                    <form action='replaceProcess.php?number=<?php echo $number ?>' method="POST">
                        <p><input type="title" name="title" value=<?php echo $title ?>></p>
                        <p><textarea name="board" cols="50" rows="10"><?php echo $board ?></textarea></p>
                        <p><input type="submit" value="수정"></p>
                    </form>
                    <?php
                } else {
                    ?>
                    <form action='replaceProcess.php?number=<?php echo $number ?>' method="POST">
                        <p><input type="title" name="title" value=<?php echo $title ?>></p>
                        <p><textarea name="board" cols="50" rows="10"><?php echo $board ?></textarea></p>
                        <p><input type="submit" value="수정"></p>
                    </form>
                    <?php
                }
                ?>
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