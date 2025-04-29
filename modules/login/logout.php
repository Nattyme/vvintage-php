<?php
session_destroy();
setcookie(session_name(), '', time() - 60);

header("Location: " . HOST);