<?php
    function toPersianDigits($number) {
        $western = ['0','1','2','3','4','5','6','7','8','9',','];
        $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','٬'];
        return str_replace($western, $persian, $number);
    }
?>
