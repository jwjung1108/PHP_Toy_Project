<?php
session_start();
include '../../connect.php';

$userid = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : '';

$tierIcons = [
    'Bronze' => '/icon/bronze.png',
    'Silver' => '/icon/silver.png',
    'Gold' => '/icon/gold.png',
    'Platinum' => '/icon/platinum.png',
    'Master' => '/icon/master.png',
    'Default' => '', // 기본 아이콘 경로
];

// SQL 쿼리문 수정
$sql = "SELECT q_board.*, users.user_rank
        FROM q_board
        JOIN users ON q_board.userid = users.id";

$result = mysqli_query($conn, $sql);
?>

<!doctype html>
<html lang="ko">

<?php include '../../header.php'; ?>

<body class="is-preload">

    <!-- Wrapper -->
    <div id="wrapper" class="fade-in">



        <?php
        $currentPage = 'QandA';
        include '../../nav.php'; ?>
        <!-- Main -->
        <div id="main">



            <!-- Posts -->
            <section class="post">
                <h1>토론관</h1>

                <!-- 검색 -->
                <div>
                    <form class="box-form" action="q_search_result.php" method="get">
                        <select style="width:20%" name="catgo">
                            <option value="title">제목</option>
                            <option value="nickname">글쓴이</option>
                            <option value="board">내용</option>
                        </select>
                        <input type="text" name="search" required="required" />
                        <button>검색</button>
                    </form>
                </div>
                <div>
                    <table>
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
                                // 비밀글인 경우, authority가 2인 사용자나 작성자만 볼 수 있도록 체크
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
                                <tr>
                                    <th scope="row">
                                        <?php echo $i++; ?>
                                    </th>
                                    <?php
                                    if ($row['isSecret'] == 1) {
                                        if ($row['userid'] != $userid && $row['authority'] != 'admin') {
                                            ?>
                                            <td>
                                                <?php echo "비밀글입니다."; ?>
                                            </td>
                                            <?php
                                        } else {
                                            ?>
                                            <td><a href="q_readBoard.php?number=<?php echo $row['number']; ?>">
                                                    <?php echo $row['title']; ?>
                                                </a>
                                            </td>
                                        <?php }
                                    } else {
                                        ?>
                                        <td><a href="q_readBoard.php?number=<?php echo $row['number']; ?>">
                                                <?php echo $row['title']; ?>
                                            </a>
                                        </td>
                                    <?php } ?>
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
                    <a class="btn-sort" href="q_writeForm.php">작성</a>
                    <a class="btn-sort" href="/">목록으로 돌아가기</a>
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