<?php
include '../../connect.php';
include '../point/ReadPoint.php';
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
                $number = $_GET['number']; /* bno함수에 title값을 받아와 넣음*/
                $stmt = mysqli_prepare($conn, 'SELECT * FROM q_board WHERE number = ?');
                mysqli_stmt_bind_param($stmt, 'i', $number);
                mysqli_stmt_execute($stmt);
                $board = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                mysqli_stmt_close($stmt);

                $stmt = mysqli_prepare($conn, 'SELECT * FROM q_time WHERE userid = ? AND boardnumber = ?');
                mysqli_stmt_bind_param($stmt,'si', $_SESSION['UserID'], $number);
                mysqli_stmt_execute($stmt);
                $check_table = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_array($check_table);
                mysqli_stmt_close($stmt);

                $result = mysqli_num_rows($check_table) > 0;

                // 현재시간
                $current_time = time();

                // time table access 시간
                $stmt = mysqli_prepare($conn,"SELECT access FROM q_time WHERE boardnumber = ? AND userid = ?");
                mysqli_stmt_bind_param($stmt, 'is', $number, $_SESSION['UserID']);
                mysqli_stmt_execute($stmt);
                $db_access = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                mysqli_stmt_close($stmt);

                $fomater = "Y-m-d H:i:s";
                $view = $board['views'];

                if ($result) {
                    if ($current_time - strtotime($db_access['access']) > 3600) {
                        $view = $view + 1;

                        $stmt = mysqli_prepare($conn, "UPDATE q_board SET views = ? WHERE number = ?");
                        mysqli_stmt_bind_param($stmt, 'ii', $view, $number);


                        if (mysqli_stmt_execute($stmt)) {
                            mysqli_stmt_close($stmt);
                            $current_time = date($fomater, $current_time);
                            $stmt = mysqli_prepare($conn,'UPDATE q_time SET access = ? WHERE boardnumber = ? AND userid = ?');
                            mysqli_stmt_bind_param($stmt, 'sis', $current_time, $number, $_SESSION['UserID']);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_close($stmt);
                        }
                    }
                } else {
                    $view = $view + 1;
                    $current_time = date($fomater, $current_time);
                    $stmt = mysqli_prepare($conn, 'INSERT into q_time(userid,boardnumber, access) values( ?, ?, ?)');
                    mysqli_stmt_bind_param($stmt, 'sis', $_SESSION['UserID'], $number, $current_time);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);

                    $stmt = mysqli_prepare($conn, "INSERT into q_time(userid,boardnumber, access) values( ?, ?, ?");
                    mysqli_stmt_bind_param($stmt, 'sis',$_SESSION['UserID'], $number, $current_time);
                    mysqli_stmt_close($stmt);

                    $stmt = mysqli_prepare($conn, "UPDATE q_board set views = ? where number = ? ");
                    mysqli_stmt_bind_param($stmt, 'ii',$view, $number);
                    mysqli_stmt_close($stmt);
                }
                ?>
                <!-- 글 불러오기 -->
                <div id="board_read">
                    <h2>
                        <?php echo $board['title']; ?>
                    </h2>
                    <div id="user_info">
                        <?php echo $board['title']; ?>
                        <?php echo $board['created']; ?> 조회:
                        <?php echo $view; ?>
                        <div id="bo_line"></div>
                    </div>
                    <div id="bo_content">
                        <?php echo nl2br($board['board']); ?>
                    </div>
                    <!-- 목록, 수정, 삭제 -->
                    <div id="bo_ser">

                        <a class="btn-sort" href="q_replaceBoard.php?number=<?php echo $board['number']; ?>">[수정]</a>
                        <a class="btn-sort" href="q_deleteBoard.php?number=<?php echo $board['number']; ?>">[삭제]</a>

                    </div>
                    <div>
                        <?php $download = isset($board['filename']) ? $board['filename'] : '';
                        if ($download === '') {
                            echo "다운로드 파일이 존재하지 않습니다.";
                        } else {
                            echo $board['filename'] . " "; ?>
                            <a href="../q_download.php?number=<?php echo $board['number']; ?>">[다운로드]</a>
                            <?php
                        }
                        ?>
                    </div>


                    <!-- 답변 -->
                    <?php
                    $sql = "select * from q_comment where boardnumber = '$number'";
                    $result = mysqli_query($conn, $sql);
                    ?>
                    <div class="container">
                        <h1 class="text-center">답변 게시판</h1>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">번호</th>
                                    <th scope="col">내용</th>
                                    <th scope="col">작성자</th>
                                    <th scope="col">등록일</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $i = 1;
                                while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                    <tr>
                                        <th scope="row">
                                            <?php echo $i++; ?>
                                        </th>
                                        <td>
                                            <?php echo $row['comment']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['nickname']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['created']; ?>
                                        </td>
                                        <td>
                                            <a href="q_deleteComment.php?number=<?php echo $row['number'] ?>">
                                                <?php echo "삭제"; ?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>

                        </table>
                        <p></p>
                        <div class="text-center">
                            <!-- 댓글 작성 버튼 -->
                            <?php
                            $userid = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : '';
                            if ($userid != NULL) {

                                $stmt = mysqli_prepare($conn, 'SELECT authority FROM users WHERE id = ?');
                                mysqli_stmt_bind_param( $stmt,'s', $userid);
                                mysqli_stmt_execute($stmt);
                                $row = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                                if ($_SESSION['authority'] == "admin") {
                                    ?>
                                    <div id="commentModal">
                                        <form class="box-form" action='q_writeCommentProcess.php?number=<?php echo $number ?>'
                                            method="POST">
                                            <textarea name="comment" style="resize: none;"></textarea>
                                            <input type="hidden" name="boardnumber" value="<?php echo $number; ?>">
                                            <input type="submit" value="작성">
                                        </form>
                                    </div>
                                    <?php
                                }
                            }
                            ?>






                            <div>
                                <a class="btn-sort" href="/">뒤로가기</a>
                            </div>


                        </div>
                    </div>
            </section>


        </div>

        <?php include '../../header.php'; ?>

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