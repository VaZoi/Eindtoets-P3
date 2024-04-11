<?php
require '../Database.php';
require '../phones.php';
require '../UserAuth.php';
$phones = new Phones($Database);
$userAuth = new UserAuth($Database);
if (!$userAuth->isLoggedIn()) {
    header("Location: ../Auth/login.php");
    exit();
}

if (!isset($_GET['phone_id'])) {
    echo "Phone ID not provided.";
    exit();
}

$phone_id = intval($_GET['phone_id']);

try {
    $phoneInfo = $phones->onePhone($phone_id);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

if (empty($phoneInfo)) {
    echo "Phone not found.";
    exit();
}


try {

    $phones->deletePhones($phone_id);

    header("Location: admin.php");
    exit();
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

