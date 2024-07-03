<header id="header">
    <a href="/index.php" class="logo">사칙연산</a>
</header>

<!-- Nav -->
<nav id="nav">
    <ul class="links">
        <li <?php echo $currentPage === 'index' ? 'class="active"' : ''; ?>><a href="/index.php">대문</a></li>
        <li <?php echo $currentPage === 'notification' ? 'class="active"' : ''; ?>><a
                href="/board/notification/list_nboard.php">알림</a></li>
        <li <?php echo $currentPage === 'board' ? 'class="active"' : ''; ?>><a
                href="/board/standard/list_board.php">광장</a></li>
        <li <?php echo $currentPage === 'reference' ? 'class="active"' : ''; ?>><a
                href="/board/reference/list_rboard.php">보관소</a></li>
        <li <?php echo $currentPage === 'QandA' ? 'class="active"' : ''; ?>><a href="/board/QandA/list_qboard.php">토론관</a>
        </li>
    </ul>

    <ul class="links" style="flex-grow:0;">
        <?php if (isset($_SESSION['UserID'])) { ?>
            <?php if ($_SESSION['authority'] == 'admin') { ?>
                <li><a href="/adminPage/adminpage.php">관리</a></li>
            <?php } else { ?>
                <li><a href="/MyPage/mypage.php">내 정보</a></li>
            <?php } ?>
            <li><a onclick="logout()">퇴장하기</a></li>
        <?php } else { ?>
            <li><a href="/join/login.php">입장하기</a></li>
            <li><a href="/join/signup.php">등록하기</a></li>
        <?php } ?>
    </ul>
</nav>