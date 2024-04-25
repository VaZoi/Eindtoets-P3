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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Phone</title>
    <link rel="stylesheet" href="../style/header.css">
    <script src="../navbar.js" defer></script>
</head>
<body>
<nav id="nav" class="nav"></nav>
<?php
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo "<p>Phone successfully added!</p>";
    }
    ?>
<div class="addphone">
            <h2>Add Phone</h2>
            <form method="post" action="process_add_phone.php">

                <input type="hidden" name="csrf_token" value="<?php echo $userAuth->generateCsrfToken(); ?>">

                <label for="name">Name:</label>
                <input type="text" name="name" required><br>

                <label for="brand">Brand:</label>
                <input type="text" name="brand" required><br>

                <label for="model">Model:</label>
                <input type="text" name="model" required><br>

                <label for="storage">Storage:</label>
                <input type="text" name="storage" required><br>

                <label for="price">Price:</label>
                <input type="number" name="price" required><br>

                <input type="submit" value="Add Phone">
            </form>
        </div>
</body>
</html>