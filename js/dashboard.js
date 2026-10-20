// Dashboard page JS
document.addEventListener("DOMContentLoaded", function() {
    // Welcome alert
    const welcome = document.querySelector("#welcome");
    if (welcome) {
        const username = sessionStorage.getItem("username");
        welcome.textContent = `Welcome, ${username || "Student"}!`;
    }

    // Logout confirmation
    const logoutLink = document.querySelector("#logout");
    if (logoutLink) {
        logoutLink.addEventListener("click", function(e) {
            const confirmLogout = confirm("Are you sure you want to logout?");
            if (!confirmLogout) {
                e.preventDefault();
            }
        });
    }
});
