<?php

include './User.class.php';

User::log_out();

header('Location: index.php');