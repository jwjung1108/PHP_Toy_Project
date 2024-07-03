<?php
include '../../connect.php';
session_start();
// 정렬 방식 설정
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'number'; // 기본값은 순번
$sortIcon = ($sort == 'number') ? '▲' : '▼';
$search_con = isset($_GET['search']) ? $_GET['search'] : '';
// 정렬 기준 설정
$orderBy = '';
switch ($sort) {
    case 'views':
        $orderBy = 'ORDER BY views';
        break;
    case 'likes':
        $orderBy = 'ORDER BY likes';
        break;
    default:
        $orderBy = 'ORDER BY number';
        break;
}

// 카테고리와 검색어 가져오기
$category = isset($_GET['catgo']) ? $_GET['catgo'] : '';
$search_con = isset($_GET['search']) ? $_GET['search'] : '';

// SQL 쿼리 준비 및 실행
if (!empty($category) && !empty($search_con)) {
    $sql = "SELECT * FROM q_board WHERE $category LIKE ? AND isSecret = 0 $orderBy";
    $stmt = mysqli_prepare($conn, $sql);
    $search_param = "%$search_con%";
    mysqli_stmt_bind_param($stmt, 's', $search_param);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $sql = "SELECT * FROM q_board WHERE isSecret = 0 $orderBy";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
}

// $result = mysqli_query($conn, "SELECT * FROM q_board WHERE $category LIKE '%$search_param$' AND isSecret = 0 $orderBy");

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
                <div class="container search-results">
                    <h1 class="text-center">검색결과:
                        <?php echo htmlspecialchars($search_con); ?>
                    </h1>
                    <div class="table-responsive">
                        <div id="search_box">
                            <form class="box-form" action="q_search_result.php" method="get">
                                <select name="catgo">
                                    <option value="title">제목</option>
                                    <option value="nickname">글쓴이</option>
                                    <option value="board">내용</option>
                                </select>
                                <input type="text" name="search" required="required" />

                                <button>검색</button>
                            </form>
                        </div>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">번호</th>
                                    <th scope="col">제목</th>
                                    <th scope="col">작성자</th>
                                    <th scope="col">등록일</th>
                                    <th scope="col">조회수</th>
                                    <th scope="col">추천수</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                while ($row = mysqli_fetch_array($result)) {
                                    $link = "q_readBoard.php?number=" . $row['number'];
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $row['number']; ?>
                                        </td>
                                        <td><a href="<?php echo $link; ?>">
                                                <?php echo $row['title']; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php echo $row['nickname']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['created']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['views']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['likes']; ?>
                                        </td>
                                    </tr>
                                <?php }
                                // mysqli_stmt_close($stmt); // 연결 닫기
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="text-center">
                    <a href='/' class="btn-sort">목록으로</a>
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