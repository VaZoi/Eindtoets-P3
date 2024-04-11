<?php
require_once '../Database.php'; 
require_once '../UserAuth.php';

$Database = new Database();
$userAuth = new UserAuth($Database);

$userAuth->logout();