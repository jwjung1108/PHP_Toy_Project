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

                //board
                $stmt = mysqli_prepare($conn,'SELECT * FROM r_board WHERE number = ?');
                mysqli_stmt_bind_param($stmt,'i', $number);
                mysqli_stmt_execute( $stmt );

                $board = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                mysqli_stmt_close($stmt);

                //check_table
                $stmt = mysqli_prepare($conn,'select * from r_time where userid= ? and boardnumber = ?');
                mysqli_stmt_bind_param($stmt,'si', $_SESSION['UserID'], $number);
                mysqli_stmt_execute( $stmt );
                $check_table = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_array($check_table);
                $result = mysqli_num_rows($check_table);
                mysqli_stmt_close($stmt);

                // 현재시간
                $current_time = time();

                // time table access 시간
                $stmt = mysqli_prepare($conn,'SELECT access from r_time WHERE boardnumber = ? and userid = ?');
                mysqli_stmt_bind_param($stmt, 'is', $number, $_SESSION['UserID']);
                mysqli_stmt_execute( $stmt );
                $db_access = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                mysqli_stmt_close($stmt);

                $fomater = "Y-m-d H:i:s";
                $view = $board['views'];

                if ($result) {
                    if ($current_time - strtotime($db_access['access']) > 3600) {
                        $view = $view + 1;
                        if (mysqli_query($conn, "update r_board set views = '" . $view . "' where number = '" . $number . "'")) {
                            $current_time = date($fomater, $current_time);
                            mysqli_query($conn, "update r_time set access = '$current_time' where boardnumber = $number and userid = '{$_SESSION['UserID']}'");
                        }
                    }
                } else {
                    $view = $view + 1;
                    $current_time = date($fomater, $current_time);
                    mysqli_query($conn, "insert into r_time(userid,boardnumber, access) values('{$_SESSION['UserID']}', $number, '$current_time')");
                    mysqli_query($conn, "update r_board set views = '" . $view . "' where number = '" . $number . "'");
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

                    <div id="image_container">
                        <?php
                        $imagePath = ''; // 이미지 파일이 아닌 경우 기본적으로 빈 문자열로 초기화
                        
                        // 이미지 파일 확장자 목록
                        $imageExtensions = array('jpg', 'jpeg', 'png', 'gif');

                        if (!empty($board['filename'])) {
                            $fileExtension = strtolower(pathinfo($board['filename'], PATHINFO_EXTENSION));

                            // 이미지 확장자인 경우 이미지 경로 설정
                            if (in_array($fileExtension, $imageExtensions)) {
                                $absoluteImagePath = $board['filepath'];

                                // 웹 서버 루트 디렉토리까지의 절대 경로
                                $webServerRoot = $_SERVER['DOCUMENT_ROOT'];

                                // 상대 경로 생성 (웹 서버 루트 디렉토리 제거)
                                $imagePath = str_replace($webServerRoot, '', $absoluteImagePath);
                            }
                        }

                        // 이미지를 표시할지 여부를 검사하여 이미지를 표시
                        if (!empty($imagePath)) {
                            echo '<img src="' . $imagePath . '" alt="첨부 이미지" id="image">';
                        }

                        ?>
                    </div>

                    <!-- 목록, 수정, 삭제 -->
                    <div id="bo_ser">

                        <a class="btn-sort" href="r_replaceBoard.php?number=<?php echo $board['number']; ?>">[수정]</a>
                        <a class="btn-sort" href="r_deleteBoard.php?number=<?php echo $board['number']; ?>">[삭제]</a>
                        <a class="btn-sort" href="r_boardLike.php?number=<?php echo $board['number']; ?>">[추천]</a>

                    </div>
                    <div>
                        <?php $download = isset($board['filename']) ? $board['filename'] : '';
                        if ($download === '') {
                            echo "다운로드 파일이 존재하지 않습니다.";
                        } else {
                            echo $board['filename'] . " "; ?>
                            <a href="../r_download.php?number=<?php echo $board['number']; ?>">[다운로드]</a>
                            <?php
                        }
                        ?>
                    </div>

                    <!-- 댓글 -->
                    <?php
                    $sql = "select * from r_comment where boardnumber = '$number'";
                    $result = mysqli_query($conn, $sql);
                    ?>
                    <div>
                        <h2>댓글</h2>
                        <table>
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
                                            <a>
                                                <?php echo $row['comment']; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php echo $row['nickname']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['created']; ?>
                                        </td>
                                        <td>
                                            <a href="r_deleteComment.php?number=<?php echo $row['number'] ?>">
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

                            <div>
                                <form class="box-form" action='r_writeCommentProcess.php?number=<?php echo $number ?>'
                                    method="POST">
                                    <textarea name="comment" style="resize: none;"></textarea>
                                    <input type="hidden" name="boardnumber" value="<?php echo $number; ?>">
                                    <input type="submit" value="작성">
                                </form>
                            </div>


                            <div>
                                <a href="/" class="btn-sort">목록으로 돌아가기</a>
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