<?php
session_start();
session_destroy();
header('Location: /dreamclass/login?mensaje=Has cerrado sesión correctamente.');
exit;
?>