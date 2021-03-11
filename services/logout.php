<?php
require 'dbconfig.php';
session_destroy();
header("Refresh: 2; ../backend/login.php");
