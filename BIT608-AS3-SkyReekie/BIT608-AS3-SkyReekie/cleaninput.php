<!--Sky Reekie SN#3809237 BIT608 Assesment 3-->
<?php
function clean_input($data) {
    // Remove extra spaces, slashes, and convert special characters to HTML entities
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>