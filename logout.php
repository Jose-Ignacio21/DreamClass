<?php
session_start();
session_destroy();
header('Location: login.php?mensaje=Has cerrado sesión correctamente.');
exit;
?>