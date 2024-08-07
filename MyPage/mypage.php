<?php
include '../connect.php';
session_start();
// 로그인 검증
$userid = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : '';

if ($userid == '') {
    ?>
    <script>
        alert("로그인을 해주세요");
        location.href = "../../index.php";
    </script>
    <?php
    exit();
}


$nickname = $_SESSION['UserName'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>내 정보</title>
    <link rel="stylesheet" href="/css/mypage_style.css">
</head>

<body class="page"> <!-- 페이지 전체에 배경 이미지 적용 -->

    <div class="header">
        <button onclick="goBack()" class="back-button">이전</button>
    </div>

    <div class="container">
        <div>
            <h1 class="page-title">정보</h1>
            <h2 class="welcome-message">어서오세요
                <?php echo $nickname; ?>님
            </h2>

            <?php
            $sql = "select * from users where id = '$userid'";
            $result = mysqli_fetch_array(mysqli_query($conn, $sql));

            echo "<div class='user-info'>";
            echo "<p class='user-info-item'>아이디 : " . $result['id'] . "</p>";
            echo "<p class='user-info-item'>닉네임 : " . $result['nickname'] . "</p>";
            echo "<p class='user-info-item'>이메일 : " . $result['email'] . "</p>";
            echo "<p class='user-info-item'>랭크 : " . $result['user_rank'] . "</p>";
            echo "<p class='user-info-item'>포인트 : " . $result['point'] . "</p>";

            if ($result['user_rank'] != 'CH') {
                echo "<button onclick='requestRankUp()' class='rank-up-button button'>등급 업 신청</button>";
            }

            echo "</div>";
            ?>
        </div>
        <div class="image-container">
            <img src="/image/cha.jpg" alt="Character Image" class="character-image">
        </div>
    </div>
    <script>

        document.addEventListener("DOMContentLoaded", () => {
            const rankUpBtn = document.querySelector('.rank-up-button');
            rankUpBtn.addEventListener('mouseover', () => {
                rankUpBtn.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
            });
            rankUpBtn.addEventListener('mouseout', () => {
                rankUpBtn.style.boxShadow = 'none';
            });
        });

        function goBack() {
            window.history.back();
        }
        function requestRankUp() {
            // 등급 업 신청 처리 로직 (예: rank_up_request.php로 요청을 보냄)
            window.location.href = 'rank_up_request.php';
        }
        document.addEventListener("DOMContentLoaded", () => {
            const button = document.querySelector('.button');
            const character = document.querySelector('.character');

            if (button && character) {
                button.addEventListener('mouseover', () => {
                    character.classList.add('animate');
                });

                button.addEventListener('mouseout', () => {
                    character.classList.remove('animate');
                });
            }
        });

    </script>
</body>

</html>