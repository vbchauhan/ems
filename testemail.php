<?php
$to = 'madhus@umd.edu,vchauhan@umd.edu';
$subject = 'Ambarish has sent you an email. Cheers for the functionality';
$body = 'This is how you send emails from PHP. All the best';
$from = 'Priddy Reserves';
mail($to, $subject, $body, $from);

?>