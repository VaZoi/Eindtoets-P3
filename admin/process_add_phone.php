<?php
require '../Database.php';
require '../phones.php';
require '../UserAuth.php';
$phones = new Phones($Database);
$userAuth = new UserAuth($Database);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed");
    }

    $name = htmlspecialchars($_POST['name']);
    $brand = htmlspecialchars($_POST['brand']);
    $model = htmlspecialchars($_POST['model']);
    $storage = htmlspecialchars($_POST['storage']);
    $price = htmlspecialchars($_POST['price']);

    try {
        $lastUserId = $phones->addPhones($name, $brand, $model, $storage, $price);

        header("Location: admin_add_phone.php?success=1");
        exit();
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    header("Location: admin_add_phone.php");
    exit();
}