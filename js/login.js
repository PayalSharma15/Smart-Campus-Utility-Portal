// Login form validation
document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.querySelector("form");

    loginForm.addEventListener("submit", function(e) {
        const email = loginForm.email.value.trim();
        const password = loginForm.password.value.trim();

        if (email === "") {
            alert("Please enter your email.");
            e.preventDefault();
            return;
        }

        if (!validateEmail(email)) {
            alert("Please enter a valid email address.");
            e.preventDefault();
            return;
        }

        if (password === "") {
            alert("Please enter your password.");
            e.preventDefault();
            return;
        }
    });

    // Email regex validation
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
});
