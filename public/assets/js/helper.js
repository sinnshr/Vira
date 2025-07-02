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

function toPersianDate(date) {
    if (!(date instanceof Date)) {
        date = new Date(date);
    }

    return new Intl.DateTimeFormat('fa-IR-u-ca-persian', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    }).format(date);
}
  