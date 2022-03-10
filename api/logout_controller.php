<?php

require_once __DIR__ . '/../_init.php';

unset($_SESSION['user_id']);

redirect('../login.php');