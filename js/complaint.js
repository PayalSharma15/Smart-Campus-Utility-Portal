document.addEventListener("DOMContentLoaded", function() {

    const form = document.getElementById("complaintForm");

    form.addEventListener("submit", function(e) {

        const title = form.title.value.trim();
        const description = form.description.value.trim();

        if (title === "") {
            alert("Enter complaint title");
            e.preventDefault();
            return;
        }

        if (description === "") {
            alert("Enter complaint description");
            e.preventDefault();
            return;
        }
    });

});