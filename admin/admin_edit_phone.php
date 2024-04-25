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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $brand = htmlspecialchars($_POST['brand']);
    $model = htmlspecialchars($_POST['model']);
    $storage = htmlspecialchars($_POST['storage']);
    $price = htmlspecialchars($_POST['price']);

    try {
        $phones->editPhones($name, $brand, $model, $storage, $price, $phone_id);

        header("Location: admin.php");
        exit();
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Phone</title>
    <script src="../navbar.js" defer></script>
    <link rel="stylesheet" href="../style/header.css">
</head>
<body>
<nav id="nav" class="nav"></nav>
    <main>
    <h2>Edit Phone</h2>
    
    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $phoneInfo['name']; ?>" required><br>

        <label for="brand">Brand:</label>
        <input type="text" name="brand" value="<?php echo $phoneInfo['brand']; ?>" required><br>

        <label for="model">Model:</label>
        <input type="text" name="model" value="<?php echo $phoneInfo['model']; ?>" required><br>

        <label for="storage">Storage:</label>
        <input type="text" name="storage" value="<?php echo $phoneInfo['storage']; ?>" required><br>

        <label for="price">Price:</label>
        <input type="number" name="price" value="<?php echo $phoneInfo['price']; ?>" required><br>

        <input type="submit" value="Update">
    </form>

    </main>
    
</body>
</html>