<?php
include '../../connect.php';
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
                <form id="boardForm" action="saveBoard.php" method="POST" enctype="multipart/form-data">
                    <h2 style="display: inline-block;">글쓰기</h2>
                    <a type="button" style="display: inline-block; float: right;" onclick="goBack()">X</a>
                    <p><input type="text" name="title" id="titleInput" placeholder="제목 (예: 효율적인 시간 관리 방법)"></p>
                    <p><textarea name="board" id="boardInput" placeholder="본문 (학업 노하우, 공부 팁, 대외활동 경험 등을 공유해 주세요)"
                            rows="8" style="resize: none;"></textarea></p>
                    <p>관련 파일 첨부 (옵션): <input type="file" name="file"></p>
                    <p><input type="submit" value="작성" onclick="return validateForm()"></p>
                </form>

                <script>
                    function validateForm() {
                        var title = document.getElementById("titleInput").value;
                        var board = document.getElementById("boardInput").value;

                        if (title.trim() === '' || board.trim() === '') {
                            alert("제목과 본문을 모두 작성해주세요.");
                            return false; // 제출 방지
                        }
                        return true; // 제출 허용
                    }

                    document.getElementById("boardForm").addEventListener("submit", function (event) {
                        if (!validateForm()) {
                            event.preventDefault(); // 제출 방지
                        }
                    });

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