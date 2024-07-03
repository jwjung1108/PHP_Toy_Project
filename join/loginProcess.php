<?php
include '../connect.php';
// 오류 디버깅 코드
// error_reporting();
// ini_set('display_errors', 1);


// 아이디와 비밀번호 가져오기
$id = trim($_POST['id']);
$password = trim($_POST['password']);

// 최대 로그인 시도 횟수 및 잠금 시간 설정
$max_attempts = 5; // 최대 시도 횟수
$lockout_duration = 300; // 5분 동안 잠금 (초 단위)

// 아이디가 입력되었는지 확인
if ($id == null) {
    ?>
    <script>
        alert('아이디를 다시 입력해 주세요');
        location.href = "../index.php";
    </script>
    <?php
    exit();
} else {
    // 사용자 정보 가져오기
    $sql = "SELECT id, password, nickname, authority, failed_attempts, last_failed_attempt FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $db_id, $hashedPassword, $nickname, $authority, $failed_attempts, $last_failed_attempt);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // 아이디가 존재하지 않는 경우
    if ($db_id == null) {
        ?>
        <script>
            alert("아이디 / 비밀번호를 확인해주세요.");
            location.href = "./login.php";
        </script>
        <?php
        exit();
    }

    $current_time = time();
    $lockout_time_remaining = strtotime($last_failed_attempt) + $lockout_duration - $current_time;
    if ($failed_attempts >= $max_attempts && $lockout_time_remaining > 0) {
        ?>
        <script>
            alert("로그인 시도가 너무 많습니다. 잠시 후 다시 시도해주세요.");
            location.href = "./login.php";
        </script>
        <?php
        exit();
    }

    // 비밀번호 검증
    $passwordResult = password_verify($password, $hashedPassword);
    if ($passwordResult === true) {


        // 로그인 성공
        session_start();
        $_SESSION['UserID'] = $db_id;
        $_SESSION['UserName'] = $nickname;
        $_SESSION['authority'] = $authority == 2 ? 'admin' : 'nomal';

        // 성공 시 로그인 시도 횟수 초기화
        $sql_reset_attempts = "UPDATE users SET failed_attempts = 0, last_failed_attempt = NULL WHERE id = ?";
        $stmt_reset_attempts = mysqli_prepare($conn, $sql_reset_attempts);
        mysqli_stmt_bind_param($stmt_reset_attempts, 's', $id);
        mysqli_stmt_execute($stmt_reset_attempts);
        mysqli_stmt_close($stmt_reset_attempts);

        ?>
        <script>
            alert("로그인에 성공하였습니다.");
            location.href = "../index.php";
        </script>
        <?php
    } else {
        // 비밀번호가 일치하지 않는 경우
        // 실패 시 로그인 시도 횟수 증가 및 시간 기록
        $failed_attempts++;
        $current_time = date("Y-m-d H:i:s");
        $sql_update_attempts = "UPDATE users SET failed_attempts = ?, last_failed_attempt = ? WHERE id = ?";
        $stmt_update_attempts = mysqli_prepare($conn, $sql_update_attempts);
        mysqli_stmt_bind_param($stmt_update_attempts, 'iss', $failed_attempts, $current_time, $id);
        mysqli_stmt_execute($stmt_update_attempts);
        mysqli_stmt_close($stmt_update_attempts);

        // 최대 시도 횟수에 도달하면 사용자 계정 잠금
        if ($failed_attempts >= $max_attempts) {
            ?>
            <script>
                alert("로그인 시도가 너무 많습니다. 잠시 후 다시 시도해주세요.");
                location.href = "./login.php";
            </script>
            <?php
            exit();
        }
        // 비밀번호가 일치하지 않는 경우
        ?>
        <script>
            alert("로그인에 실패하였습니다.");
            location.href = "./login.php";
        </script>
        <?php
    }
}
?>