<?php
include '../connect.php';

// XSS 필터링 함수
function filterXSS($input, $limit = null, $offset = 0) {
    // Force input to be a string
    $x = (string) $input;

    // Allow alphanumeric characters, whitespace, and specific characters
    $x = preg_replace("/[^a-zA-Z0-9 -:,.!?\/|]/", "",$x);

    // Limit characters
    if ($limit) {
        $x = substr($x, $offset, $limit);
    }

    // Convert characters to HTML entities and return the sanitized string
    return htmlentities($x, ENT_QUOTES, 'UTF-8');
}

// 사용자 입력 값을 가져옵니다.
$id = trim($_POST['id']);
$password = trim($_POST['password']);
$passwordCheck = trim($_POST['passwordCheck']);
$nickname = trim($_POST['nickname']);
$email = trim($_POST['email']);
$authority = 1; // 사용자 일반 권한 부여

// XSS 필터링
$id = filterXSS($id);
$nickname = filterXSS($nickname);
$email = filterXSS($email);

// 비밀번호 검증 함수
function validatePassword($password) {
    $minLength = 8;
    $hasUppercase = preg_match('/[A-Z]/', $password);
    $hasLowercase = preg_match('/[a-z]/', $password);
    $hasNumber = preg_match('/[0-9]/', $password);
    $hasSpecialChar = preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password);

    return strlen($password) >= $minLength && $hasUppercase && $hasLowercase && $hasNumber && $hasSpecialChar;
}

// 비밀번호 일치 여부 확인 및 검증
if ($password !== $passwordCheck) {
    ?>
    <script>
        alert("비밀번호가 서로 일치하지 않습니다.");
        location.href = "../index.php";
    </script>
    <?php
    exit();
} elseif (!validatePassword($password)) {
    ?>
    <script>
        alert("비밀번호는 8자 이상, 대문자, 소문자, 숫자 및 특수 문자를 포함해야 합니다.");
        location.href = "../index.php";
    </script>
    <?php
    exit();
}

// 아이디 검증
if ($id == '') {
    ?>
    <script>
        alert("아이디를 다시 입력해 주세요");
        location.href = "../index.php";
    </script>
    <?php
    exit();
}

// 데이터베이스에서 아이디 중복 확인
$sql_check_id = "SELECT id FROM users WHERE id = ?";
$stmt_check_id = mysqli_prepare($conn, $sql_check_id);
mysqli_stmt_bind_param($stmt_check_id, 's', $id);
mysqli_stmt_execute($stmt_check_id);
mysqli_stmt_store_result($stmt_check_id);

if (mysqli_stmt_num_rows($stmt_check_id) > 0) {
    ?>
    <script>
        alert("다시 시도해주세요!");
        location.href = "../index.php";
    </script>
    <?php
    exit();
}

// 비밀번호 해시
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// 준비된 문장을 작성합니다.
$sql_insert_user = "INSERT INTO users (id, password, nickname, email, created, authority) VALUES (?, ?, ?, ?, NOW(), ?)";

// SQL 문을 준비합니다.
$stmt_insert_user = mysqli_prepare($conn, $sql_insert_user);
mysqli_stmt_bind_param($stmt_insert_user, 'ssssi', $id, $hashedPassword, $nickname, $email, $authority);

// SQL 문을 실행합니다.
$result_insert = mysqli_stmt_execute($stmt_insert_user);

if ($result_insert === false) {
    ?>
    <script>
        alert("문제가 생겼습니다.");
        location.href = "../index.php";
    </script>
    <?php
} else {
    ?>
    <script>
        alert("회원가입이 완료되었습니다");
        location.href = "../index.php";
    </script>
    <?php
}

// 준비된 문장을 닫습니다.
mysqli_stmt_close($stmt_insert_user);

// 데이터베이스 연결을 닫습니다.
mysqli_close($conn);
?>

