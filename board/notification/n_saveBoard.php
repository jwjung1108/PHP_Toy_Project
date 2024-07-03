<?php
session_start();
$userid = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : '';
include '../../connect.php';

if (empty($userid)) {
    ?>
    <script>
        alert("로그인 후 작성이 가능합니다.");
        location.href = "../../index.php";
    </script>
    <?php
    exit();
}

$view = 0;
$like = 0;

$title = isset($_POST['title']) ? $_POST['title'] : '';
$board = isset($_POST['board']) ? $_POST['board'] : '';
$nickname = $_SESSION['UserName'];

if ($title === '' || $board === '') { ?>
    <script>
        alert('제목과 본문을 모두 작성해주세요.');
        window.history.back(-1);
    </script>
<?php
    exit();
}

$uploadDir = '/home/upload/notification/';
$maxFileSize = 5 * 1024 * 1024; // 5MB

$fileDestination = '';

if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['file'];

    // 파일 정보 가져오기
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];

    $allowedExtensions = ["jpg", "jpeg", "png", "gif"];

    // 파일 확장자 추출
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (in_array($fileExtension, $allowedExtensions)) {
        if ($fileSize <= $maxFileSize) {
            $newFileName = uniqid() . "." . $fileExtension;
            $uploadPath = $uploadDir . $newFileName;

            // 파일 이동
            if (move_uploaded_file($fileTmpName, $uploadPath)) {
                $fileDestination = $uploadPath;
                $fileName = $newFileName;
            } else {
                ?>
                <script>
                    alert("파일 업로드에 실패하였습니다.");
                    location.href = "list_nboard.php";
                </script>
                <?php
                exit();
            }
        } else {
            ?>
            <script>
                alert("파일 크기가 너무 큽니다.");
                location.href = "list_nboard.php";
            </script>
            <?php
            exit();
        }
    } else {
        ?>
        <script>
            alert("허용되지 않는 파일 형식입니다.");
            location.href = "list_nboard.php";
        </script>
        <?php
        exit();
    }
} else {
    $fileDestination = '';
    $fileName = '';
}

$sql = "
    INSERT INTO n_board
    (title, board, userid, nickname, views, likes, created, filepath, filename)
    VALUES (?, ?, ?, ?, ?, ?, NOW(), ?, ?)
";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    echo "SQL 준비에 실패했습니다: ";
    echo "<script> location.href = 'list_nboard.php'; </script>";
    exit();
}

mysqli_stmt_bind_param($stmt, 'ssssisss', $title, $board, $userid, $nickname, $view, $like, $fileDestination, $fileName);

if (mysqli_stmt_execute($stmt)) {
    // 글 작성시 포인트 상승
    include '../point/WriteBoPoint.php';
    ?>
    <script>
        alert("게시글이 작성되었습니다.");
        location.href = "list_nboard.php";
    </script>
    <?php
} else {
    echo "저장에 문제가 생겼습니다. 관리자에게 문의해주세요.";
    echo "<script>location.href = 'list_nboard.php'; </script>";
}

mysqli_stmt_close($stmt);
?>
