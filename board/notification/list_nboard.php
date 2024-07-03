<?php
session_start();
include '../../connect.php';

$tierIcons = [
    'Bronze' => '/icon/bronze.png',
    'Silver' => '/icon/silver.png',
    'Gold' => '/icon/gold.png',
    'Platinum' => '/icon/platinum.png',
    'Master' => '/icon/master.png',
    'Default' => '', // 기본 아이콘 경로
];


$UserID = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : '';

// 정렬 방식 설정
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'number'; // 기본값은 순번
$sortIcon = ($sort == 'number') ? '▲' : '▼';

// 정렬 기준 설정
$orderBy = '';
switch ($sort) {
    case 'views':
        $orderBy = 'views';
        break;
    default:
        $orderBy = 'number';
        break;
}

$sql = "SELECT n_board.*, users.user_rank
        FROM n_board
        JOIN users ON n_board.userid = users.id
        ORDER BY n_board.important DESC, n_board.$orderBy DESC";

$result = mysqli_query($conn, $sql);

?>

<!doctype html>
<html lang="ko">

<?php include '../../header.php' ?>

<body class="is-preload">

    <!-- Wrapper -->
    <div id="wrapper" class="fade-in">



        <?php
        $currentPage = 'notification';
        include '../../nav.php';
        ?>

        <!-- Main -->
        <div id="main">



            <!-- Posts -->
            <section class="post">
                <h1>알림</h1>
                <div class="text-end mb-3">
                    <a href="?sort=views" class=" btn-sort <?php echo ($sort == 'views') ? 'active' : ''; ?>">조회수</a>
                    <a href="?sort=number" class=" btn-sort <?php echo ($sort == 'number') ? 'active' : ''; ?>">순번</a>
                </div>


                <!-- 검색 -->
                <div>
                    <form class="box-form" action="n_search_result.php" method="get">
                        <select style="width:20%" name="catgo">
                            <option value="title">제목</option>
                            <option value="nickname">글쓴이</option>
                            <option value="board">내용</option>
                        </select>
                        <input type="text" name="search" required="required" />
                        <button>검색</button>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">번호</th>
                                <th scope="col">제목</th>
                                <th scope="col">작성자</th>
                                <th scope="col">등록일</th>
                                <th scope="col">조회수</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            while ($row = mysqli_fetch_array($result)) {
                                $class = '';
                                if ($row['important'] == 1) {
                                    $class = 'important';
                                } elseif ($row['important'] == 0) {
                                    $class = 'generic';
                                }
                                $authorRank = $row['user_rank'];
                                $tierIconPath = isset($tierIcons[$authorRank]) ? $tierIcons[$authorRank] : $tierIcons['Default'];

                                // Determine color based on rank
                                switch ($authorRank) {
                                    case 'Bronze':
                                        $color = 'color: #cd7f32;'; // Bronze color (e.g., brown)
                                        break;
                                    case 'Silver':
                                        $color = 'color: #c0c0c0;'; // Silver color (e.g., silver)
                                        break;
                                    case 'Gold':
                                        $color = 'color: #ffd700;'; // Gold color (e.g., gold)
                                        break;
                                    case 'Platinum':
                                        $color = 'color: #ff4500;'; // Platinum color (e.g., orange)
                                        break;
                                    case 'Master':
                                        $color = 'color: #ff8c00;'; // Master color (e.g., orange)
                                        break;
                                    default:
                                        $color = 'color: black;'; // Default color (e.g., black)
                                        break;
                                }

                                ?>
                                <tr class='<?php echo $class; ?>'>
                                    <th scope="row">
                                        <?php echo $i++; ?>
                                    </th>
                                    <td><a href="n_readBoard.php?number=<?php echo $row['number']; ?>">
                                            <?php echo $row['title']; ?>
                                        </a>
                                    </td>
                                    <td style="<?php echo $color; ?>">
                                        <img src="<?php echo $tierIconPath; ?>" alt="tier" class="tier-icon" />
                                        <?php echo $row['nickname']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['created']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['views']; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div>
                    <?php
                    if ($_SESSION['authority'] == 'admin') {
                        ?><a class="btn-sort" href="n_writeForm.php">작성</a>
                        <?php
                    }
                    ?>

                    <a class="btn-sort" href="/">목록으로 돌아가기</a>
                </div>


            </section>
        </div>
        <?php include '../../footer.php' ?>

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