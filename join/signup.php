<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js" integrity="sha384-BOsAfwzjNJHrJ8cZidOg56tcQWfp6y72vEJ8xQ9w6Quywb24iOsW913URv1IS4GD" crossorigin="anonymous"></script>
</head>

<body>
    <form action="/join/signupProcess.php" method="POST" id="signup-form">
        <div class="w-50 ml-auto mr-auto mt-5">
            <div class="mb-3">
                <label for="id" class="form-label">아이디</label>
                <input type="text" name="id" class="form-control" id="id" placeholder="아이디를 입력해 주세요." required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">비밀번호</label>
                <input name="password" type="password" class="form-control" id="password" placeholder="비밀번호를 입력해 주세요." required>
                <small id="passwordHelp" class="form-text text-muted">비밀번호는 8자 이상, 대문자, 소문자, 숫자 및 특수 문자를 포함해야 합니다.</small>
            </div>
            <div class="mb-3">
                <label for="passwordCheck" class="form-label">비밀번호 체크</label>
                <input name="passwordCheck" type="password" class="form-control" id="password-check" placeholder="비밀번호를 입력해 주세요." required>
            </div>
            <div class="mb-3">
                <label for="nickname" class="form-label">닉네임</label>
                <input name="nickname" type="text" class="form-control" id="nickname" placeholder="닉네임을 입력해 주세요." required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">이메일</label>
                <input name="email" type="email" class="form-control" id="email" placeholder="이메일을 입력해 주세요." required>
            </div>

            <button type="submit" id="signup-button" class="btn btn-primary mb-3">회원가입</button>
        </div>
    </form>

    <script src="signup.js"></script>
</body>

</html>
