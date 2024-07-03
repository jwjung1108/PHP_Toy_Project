<?php
session_start();
?>

<!DOCTYPE html>
<html>

<?php include 'header.php' ?>

<body class="is-preload">

    <!-- Wrapper -->
    <div id="wrapper" class="fade-in">

        <!-- Intro -->
        <div id="intro">
            <h1>환영합니다!</h1>
            <p>올바른 지식을 더하고! 잘못된 지식을 빼고! 지식을 나누고! 학습을 곱하고!</p>
            <ul class="actions">
                <li><a href="#header" class="button icon solid solo fa-arrow-down scrolly">계속</a></li>
            </ul>
        </div>


        <?php
        $currentPage = 'index';
        include 'nav.php'; ?>
        <!-- Main -->
        <div id="main">

            <!-- Featured Post -->
            <article class="post featured">
                <header class="major">
                    <h2>사칙<br />
                        연산</h2>
                    <p>사칙연산은 지식을 나누고 공유하며 필요한 공부를 하는 곳 입니다.</p>

                </header>
                <a href="#" class="image main"><img src="images/study.png" alt="" /></a>
            </article>

            <!-- Posts -->
            <section class="posts">
                <article>
                    <header>
                        <h2>알림</h2>
                    </header>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">제목</th>
                                <th scope="col">작성자</th>
                                <th scope="col">등록일</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include './connect.php'; // 데이터베이스 연결 정보 포함
                            
                            // 최신 공지사항 5개를 가져오는 쿼리
                            $sql_n = 'SELECT * FROM n_board ORDER BY important DESC, created DESC LIMIT 5';
                            $result_n = mysqli_query($conn, $sql_n); ?>

                            <?php
                            while ($row_n = mysqli_fetch_array($result_n)) {
                                ?>
                                <tr>
                                    <td>
                                        <a
                                            href="/board/notification/n_readBoard.php?number=<?php echo $row_n['number']; ?>">
                                            <?php echo $row_n['title']; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php echo $row_n['nickname']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row_n['created']; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>

                    <a href="#" class="image fit"><img src="images/notice.png" alt="알림" /></a>
                    <p>중요한 소식을 확인하세요!</p>
                    <ul class="actions special">
                        <li><a href="/board/notification/list_nboard.php" class="button">이동</a></li>
                    </ul>
                </article>
                <article>
                    <header>

                        <h2>광장</h2>
                    </header>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">제목</th>
                                <th scope="col">작성자</th>
                                <th scope="col">등록일</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include './connect.php'; // 데이터베이스 연결 정보 포함
                            
                            $sql_s = 'SELECT * FROM s_board ORDER BY created DESC LIMIT 5';
                            $result_s = mysqli_query($conn, $sql_s); ?>

                            <?php
                            while ($row_s = mysqli_fetch_array($result_s)) {
                                ?>
                                <tr>
                                    <td>
                                        <a href="/board/standard/readBoard.php?number=<?php echo $row_s['number']; ?>">
                                            <?php echo $row_s['title']; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php echo $row_s['nickname']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row_s['created']; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <a href="#" class="image fit"><img src="images/free.png" alt="광장" /></a>
                    <p>자유롭게 소통하세요!</p>
                    <ul class="actions special">
                        <li><a href="/board/standard/list_board.php" class="button">이동</a></li>
                    </ul>
                </article>
                <article>
                    <header>

                        <h2>보관소</h2>
                    </header>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">제목</th>
                                <th scope="col">작성자</th>
                                <th scope="col">등록일</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include './connect.php'; // 데이터베이스 연결 정보 포함
                            
                            $sql_r = 'SELECT * FROM r_board ORDER BY created DESC LIMIT 5';
                            $result_r = mysqli_query($conn, $sql_r); ?>

                            <?php
                            while ($row_r = mysqli_fetch_array($result_r)) {
                                ?>
                                <tr>
                                    <td>
                                        <a href="/board/reference/r_readBoard.php?number=<?php echo $row_r['number']; ?>">
                                            <?php echo $row_r['title']; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php echo $row_r['nickname']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row_r['created']; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <a href="#" class="image fit"><img src="images/reference.png" alt="보관소" /></a>
                    <p>자료들이 저장되어 있는 곳 입니다!</p>
                    <ul class="actions special">
                        <li><a href="/board/reference/list_rboard.php" class="button">이동</a></li>
                    </ul>
                </article>
                <article>
                    <header>

                        <h2>토론관</h2>
                    </header>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">제목</th>
                                <th scope="col">작성자</th>
                                <th scope="col">등록일</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include './connect.php'; // 데이터베이스 연결 정보 포함
                            
                            $sql_q = 'SELECT * FROM q_board ORDER BY created DESC LIMIT 5';
                            $result_q = mysqli_query($conn, $sql_q); ?>

                            <?php
                            while ($row_q = mysqli_fetch_array($result_q)) {
                                ?>
                                <tr>
                                    <td>
                                        <a href="/board/QandA/q_readBoard.php?number=<?php echo $row_q['number']; ?>">
                                            <?php echo $row_q['title']; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php echo $row_q['nickname']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row_q['created']; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <a href="#" class="image fit"><img src="images/qna.png" alt="토론관" /></a>
                    <p>궁금한 점을 질문하세요!</p>
                    <ul class="actions special">
                        <li><a href="/board/QandA/list_qboard.php" class="button">이동</a></li>
                    </ul>
                </article>
            </section>


        </div>

        <?php include 'footer.php' ?>
    </div>

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.scrollex.min.js"></script>
    <script src="assets/js/jquery.scrolly.min.js"></script>
    <script src="assets/js/browser.min.js"></script>
    <script src="assets/js/breakpoints.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>

</body>

</html>