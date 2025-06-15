function seePassword(inputId, iconId) {
    var input = document.getElementById(inputId);
    var icon = document.getElementById(iconId);

    if (input.type === "password") {
        input.type = "text";
    icon.classList.remove("fa-eye");
    icon.classList.add("fa-eye-slash");
        } else {
        input.type = "password";
    icon.classList.remove("fa-eye-slash");
    icon.classList.add("fa-eye");
        }
}
