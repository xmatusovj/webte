<?php
    session_start();

    unlink($_SESSION["fileName"]);

    unset($_SESSION["fileName"]);
?>