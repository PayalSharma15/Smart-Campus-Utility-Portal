document.addEventListener("DOMContentLoaded", function() {
    const registerForm = document.querySelector("form");

    registerForm.addEventListener("submit", function(e) {

        const name = registerForm.name.value.trim();
        const email = registerForm.email.value.trim();
        const password = registerForm.password.value.trim();
        const mobile = registerForm.parent_mobile.value.trim();

        if (name === "") {
            alert("Please enter your name.");
            e.preventDefault();
            return;
        }

        if (!validateEmail(email)) {
            alert("Enter valid email.");
            e.preventDefault();
            return;
        }

        if (password.length < 4) {
            alert("Password must be at least 4 characters.");
            e.preventDefault();
            return;
        }

        // 📱 Mobile validation (10 digits)
        if (!/^[0-9]{10}$/.test(mobile)) {
            alert("Enter valid 10-digit mobile number.");
            e.preventDefault();
            return;
        }
    });

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
});