<?php
session_start();
session_unset();
session_destroy();
exit("<script>alert('Você deslogou do sistema!'); location='login.php'</script>");
?>