<?php
include '../../connect.php';
include '../point/ReadPoint.php';
?>

<!doctype html>
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
                $number = $_GET['number']; /* bno함수에 title값을 받아와 넣음*/
                $board = mysqli_fetch_array(mysqli_query($conn, "select * from s_board where number ='" . $number . "'"));

                $check_table = (mysqli_query($conn, "select * from s_time where userid='" . $_SESSION['UserID'] . "' and boardnumber = '$number'"));
                $row = mysqli_fetch_array($check_table);

                $result = mysqli_num_rows($check_table) > 0;

                // 현재시간
                $current_time = time();

                // time table access 시간
                $db_access = mysqli_fetch_array(mysqli_query($conn, "select access from s_time where boardnumber=$number and userid='{$_SESSION['UserID']}'"));

                $fomater = "Y-m-d H:i:s";
                $view = $board['views'];

                if ($result) {
                    if ($current_time - strtotime($db_access['access']) > 3600) {
                        $view = $view + 1;
                        if (mysqli_query($conn, "update s_board set views = '" . $view . "' where number = '" . $number . "'")) {
                            $current_time = date($fomater, $current_time);
                            mysqli_query($conn, "update s_time set access = '$current_time' where boardnumber = $number and userid = '{$_SESSION['UserID']}'");
                        }
                    }
                } else {
                    $view = $view + 1;
                    $current_time = date($fomater, $current_time);
                    mysqli_query($conn, "insert into s_time(userid,boardnumber, access) values('{$_SESSION['UserID']}', $number, '$current_time')");
                    mysqli_query($conn, "update s_board set views = '" . $view . "' where number = '" . $number . "'");
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
                        <?php echo $view; ?> 추천:
                        <?php echo $board['likes']; ?>
                        <div id="bo_line"></div>
                    </div>
                    <div id="bo_content">
                        <?php echo nl2br($board['board']); ?>
                    </div>
                    <!-- 목록, 수정, 삭제 -->
                    <div id="bo_ser">

                        <a class="btn-sort" href="replaceBoard.php?number=<?php echo $board['number']; ?>">[수정]</a>
                        <a class="btn-sort" href="deleteBoard.php?number=<?php echo $board['number']; ?>">[삭제]</a>
                        <a class="btn-sort" href="boardLike.php?number=<?php echo $board['number']; ?>">[추천]</a>

                    </div>
                    <div>
                        <?php $download = isset($board['filename']) ? $board['filename'] : '';
                        if ($download === '') {
                            echo "다운로드 파일이 존재하지 않습니다.";
                        } else {
                            echo $board['filename'] . " "; ?>
                            <a href="../s_download.php?number=<?php echo $board['number']; ?>">[다운로드]</a>
                            <?php
                        }
                        ?>
                    </div>

                    <!-- 댓글 -->
                    <?php
                    $sql = "select * from s_comment where boardnumber = '$number'";
                    $result = mysqli_query($conn, $sql);
                    ?>
                    <div class="container">
                        <h2>댓글</h2>
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
                                            <a href="deleteComment.php?number=<?php echo $row['number'] ?>">
                                                <?php echo "삭제"; ?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php }
                                ?>
                            </tbody>
                        </table>
                        <p></p>
                        <div>



                            <div id="commentModal">
                                <form class="box-form" action='writeCommentProcess.php?number=<?php echo $number ?>'
                                    method="POST">
                                    <textarea name="comment" style="resize: none;"></textarea>
                                    <input type="hidden" name="boardnumber" value="<?php echo $number; ?>">
                                    <input type="submit" value="작성">
                                </form>
                            </div>


                            <a class="btn-sort" href="/">목록으로 돌아가기</a>
                        </div>
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