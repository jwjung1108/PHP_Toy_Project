<?php
include '../../connect.php';
include '../../adminPage/check_admin.php';
session_start();
?>

<!DOCTYPE html>
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
                <form action="n_saveBoard.php" method="POST" enctype="multipart/form-data">
                    <h2 style="display: inline-block;">글쓰기</h2>
                    <a type="button" style="display: inline-block; float: right;" onclick="goBack()">X</a>
                    <p><input type="text" name="title" placeholder="제목 (예: 공지사항)"></p>
                    <p><textarea name="board" placeholder="본문 (경고메세지)" rows="8" style="resize: none;"></textarea></p>
                    <p>중요 공지사항<input type="checkbox" name="important" value="reference"
                            style="float:right; opacity:1; appearance: auto;"></ㅈp>
                    <p>관련 파일 첨부 (옵션): <input type="file" name="file"></p>
                    <p><input type="submit" value="작성"></p>

                </form>

                <script>
                    function goBack() {
                        window.history.back();
                    }
                </script>
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