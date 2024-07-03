document.addEventListener("DOMContentLoaded", function() {
    const signupForm = document.querySelector("#signup-form");
    const signupButton = document.querySelector("#signup-button");
    const password = document.querySelector("#password");
    const passwordCheck = document.querySelector("#password-check");

    function validatePassword(password) {
        const minLength = 8;
        const hasUppercase = /[A-Z]/.test(password);
        const hasLowercase = /[a-z]/.test(password);
        const hasNumber = /[0-9]/.test(password);
        const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);

        return password.length >= minLength && hasUppercase && hasLowercase && hasNumber && hasSpecialChar;
    }

    signupButton.addEventListener("click", function(e) {
        if (!validatePassword(password.value)) {
            alert("비밀번호는 8자 이상, 대문자, 소문자, 숫자 및 특수 문자를 포함해야 합니다.");
            e.preventDefault(); // 폼 제출을 막습니다.
            return;
        }

        if (password.value && password.value === passwordCheck.value) {
            // 유효성 검사 통과 및 비밀번호 확인 일치 시 폼 제출
            signupForm.submit();
        } else {
            alert("비밀번호가 서로 일치하지 않습니다.");
            e.preventDefault(); // 폼 제출을 막습니다.
        }
    });
});

