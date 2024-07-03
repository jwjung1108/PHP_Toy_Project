function goToLoginPage() {
    window.location.href = "/join/login.php";
}
function goToSignupPage() {
    window.location.href = "/join/signup.php";
}
function goTocommonBoardPage() {
    window.location.href = "/board/standard/list_board.php";
}
function goTonotificationBoardPage() {
    window.location.href = "/board/notification/list_nboard.php";
}
function goToQandABoardPage() {
    window.location.href = "/board/QandA/list_qboard.php";
}
function goToReferencePage() {
    window.location.href = "/board/reference/list_rboard.php";
}
function logout() {
    const data = confirm("로그아웃 하시겠습니까?");
    if (data) {
        location.href = "/join/logoutProcess.php";
    }
}

function goToMyPage() {
    window.location.href = "/MyPage/mypage.php";
}