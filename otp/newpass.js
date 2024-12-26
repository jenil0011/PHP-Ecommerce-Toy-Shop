document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("changePasswordForm").addEventListener("submit", function(event) {
        const password = document.querySelector("[name='newPassword']").value;
        const confirmPassword = document.querySelector("[name='confirmPassword']").value;

        /*const password=document.getElementsByName("password").value;
        const confirmPassword=document.getElementsByName("confirm_password").value;*/
        
        
        if (password !== confirmPassword) {
            alert("Passwords do not match.");
            event.preventDefault();
        }
    });
});
