<?php
    function toPersianDigits($number) {
        $western = ['0','1','2','3','4','5','6','7','8','9',','];
        $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','٬'];
        return str_replace($western, $persian, $number);
    }
?>
<script>
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
</script>