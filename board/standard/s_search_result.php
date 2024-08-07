<?php
include '../../connect.php';
session_start();
// 정렬 방식 설정
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'number'; // 기본값은 순번
$search_con = isset($_GET['search']) ? $_GET['search'] : '';

// 정렬 기준 설정
$allowedSorts = ['number', 'views', 'likes'];
if (!in_array($sort, $allowedSorts)) {
    echo "잘못된 정렬 기준입니다.";
    exit();
}

$orderBy = '';
switch ($sort) {
    case 'views':
        $orderBy = 'views';
        break;
    case 'likes':
        $orderBy = 'likes';
        break;
    default:
        $orderBy = 'number';
        break;
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['catgo']) ? $_GET['catgo'] : '';

// 허용된 카테고리 값 검증
$allowedCategories = ['title', 'nickname', 'board'];
if (!in_array($category, $allowedCategories)) {
    echo "잘못된 검색 카테고리입니다.";
    exit();
}

// SQL 쿼리문 준비 및 실행
$sql = "SELECT * FROM s_board WHERE $category LIKE ? ORDER BY $orderBy";

$stmt = mysqli_prepare($conn, $sql);
if ($stmt === false) {
    echo "SQL 준비에 실패했습니다: " . mysqli_error($conn);
    exit();
}

$searchParam = '%' . $search . '%';
mysqli_stmt_bind_param($stmt, 's', $searchParam);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result === false) {
    echo "쿼리 실행에 실패했습니다: " . mysqli_error($conn);
    exit();
}



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
                        <div>
                            <form class="box-form" action="s_search_result.php" method="get">
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
                                while ($row = mysqli_fetch_array($result)) {
                                    $link = "s_readBoard.php?number=" . $row['number'];
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo htmlspecialchars($row['number']); ?>
                                        </td>
                                        <td><a href="<?php echo htmlspecialchars($link); ?>">
                                                <?php echo htmlspecialchars($row['title']); ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($row['nickname']); ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($row['created']); ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($row['views']); ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($row['likes']); ?>
                                        </td>
                                    </tr>
                                <?php }
                                mysqli_stmt_close($stmt); // 연결 닫기
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div>
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