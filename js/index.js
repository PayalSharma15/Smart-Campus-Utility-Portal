document.addEventListener("DOMContentLoaded", function () {

    const form = document.querySelector("form");

    if(form){
        form.addEventListener("submit", function (e) {

            const email = document.querySelector("input[name='email']").value;
            const password = document.querySelector("input[name='password']").value;

            if (email === "" || password === "") {
                e.preventDefault();
                alert("Please fill all fields");
            }
        });
    }

});
