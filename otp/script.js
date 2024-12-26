document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("registration-form").addEventListener("submit", function(event) {
        const password = document.querySelector("[name='password']").value;
        const confirmPassword = document.querySelector("[name='confirm_password']").value;

        /*const password=document.getElementsByName("password").value;
        const confirmPassword=document.getElementsByName("confirm_password").value;*/
        
        
        if (password !== confirmPassword) {
            alert("Passwords do not match.");
            event.preventDefault();
        }
    });
});

