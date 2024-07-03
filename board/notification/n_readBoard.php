<?php
include '../../connect.php';
session_start();
?>

<!doctype html>
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
            $number = $_GET['number'];

            // Prepare and execute the query to fetch board details
            $stmt = mysqli_prepare($conn, "SELECT * FROM n_board WHERE number = ?");
            mysqli_stmt_bind_param($stmt, 'i', $number);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $board = mysqli_fetch_array($result);
            mysqli_stmt_close($stmt);

            // Prepare and execute the query to check n_time table
            $stmt = mysqli_prepare($conn, "SELECT * FROM n_time WHERE userid = ? AND boardnumber = ?");
            mysqli_stmt_bind_param($stmt, 'si', $_SESSION['UserID'], $number);
            mysqli_stmt_execute($stmt);
            $check_table = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_array($check_table);
            $result = mysqli_num_rows($check_table) > 0;
            mysqli_stmt_close($stmt);

            // Current time
            $current_time = time();

            // Access time from n_time table
            $stmt = mysqli_prepare($conn, "SELECT access FROM n_time WHERE boardnumber = ? AND userid = ?");
            mysqli_stmt_bind_param($stmt, 'is', $number, $_SESSION['UserID']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $db_access = mysqli_fetch_array($result);
            mysqli_stmt_close($stmt);

            $fomater = "Y-m-d H:i:s";
            $view = $board['views'];

            if ($result) {
                if ($current_time - strtotime($db_access['access']) > 3600) {
                    $view++;
                    $stmt = mysqli_prepare($conn, "UPDATE n_board SET views = ? WHERE number = ?");
                    mysqli_stmt_bind_param($stmt, 'ii', $view, $number);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);

                    $current_time = date($fomater, $current_time);
                    $stmt = mysqli_prepare($conn, "UPDATE n_time SET access = ? WHERE boardnumber = ? AND userid = ?");
                    mysqli_stmt_bind_param($stmt, 'sis', $current_time, $number, $_SESSION['UserID']);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                }
            } else {
                $view++;
                $current_time = date($fomater, $current_time);
                $stmt = mysqli_prepare($conn, "INSERT INTO n_time (userid, boardnumber, access) VALUES (?, ?, ?)");
                mysqli_stmt_bind_param($stmt, 'sis', $_SESSION['UserID'], $number, $current_time);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                $stmt = mysqli_prepare($conn, "UPDATE n_board SET views = ? WHERE number = ?");
                mysqli_stmt_bind_param($stmt, 'ii', $view, $number);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
            ?>
            <!-- 글 불러오기 -->
            <div id="board_read">
                <h2><?php echo $board['title']; ?></h2>
                <div id="user_info">
                    <?php echo $board['title']; ?>
                    <?php echo $board['created']; ?> 조회:
                    <?php echo $view; ?> 추천:
                    <?php echo $board['likes']; ?>
                    <div id="bo_line"></div>
                </div>
                <div id="bo_content">
                    <?php echo nl2br($board['board']); ?>
                </div>
                <!-- 목록, 수정, 삭제 -->
                <div id="bo_ser">
                    <a class="btn-sort" href="/">[이전으로]</a>
                    <?php
                    if ($_SESSION['UserID'] == $board['userid']) { ?>
                        <a class="btn-sort" href="n_replaceBoard.php?number=<?php echo $board['number']; ?>">[수정]</a>
                        <a class="btn-sort" href="n_deleteBoard.php?number=<?php echo $board['number']; ?>">[삭제]</a>
                    <?php } ?>
                </div>
                <div>
                    <?php
                    $download = isset($board['filename']) ? $board['filename'] : '';
                    if ($download === '') {
                        echo "다운로드 파일이 존재하지 않습니다.";
                    } else {
                        echo $board['filename'] . " "; ?>
                        <a href="../n_download.php?number=<?php echo $board['number']; ?>">[다운로드]</a>
                    <?php } ?>
                </div>
            </div>
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
