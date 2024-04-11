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

try {
    $phones = $phones->getPhonestable();
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../navbar.js" defer></script>
</head>
<body>
<nav id="nav" class="nav"></nav>
    <main>
    <div class="showphones">
        <h2>All Phones</h2>
        
        <?php if (!empty($phones)): ?>
            <table border="1">
                <tr>
                    <th>Phone ID</th>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Storage</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>

                <?php foreach ($phones as $phone): ?>
                    <tr>
                        <td><?php echo $phone['phone_id']; ?></td>
                        <td><?php echo $phone['name']; ?></td>
                        <td><?php echo $phone['brand']; ?></td>
                        <td><?php echo $phone['model']; ?></td>
                        <td><?php echo $phone['storage']; ?></td>
                        <td><?php echo $phone['price']; ?></td>
                        <td>
                            <a href="admin_edit_phone.php?phone_id=<?php echo $phone['phone_id']; ?>">Edit</a>
                            |
                            <a href="admin_delete_phone.php?phone_id=<?php echo $phone['phone_id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No Phones found.</p>
        <?php endif; ?>
        </div>
    </main>
</body>
</html>