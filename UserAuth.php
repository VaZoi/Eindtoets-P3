<?php

class UserAuth 
{
    private $dbh;
    private $usertable = 'user';
    public function __construct(DataBase $dbh){
        $this->dbh = $dbh;
        session_start();
    }
    public function hash($password) : string 
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function login($email, $password): bool
    {
        $stmt = $this->dbh->run("SELECT * FROM $this->usertable WHERE email = ?", [$email]);
        $userAuth = $stmt->fetch();

        if ($userAuth && password_verify($password, $userAuth['password'])) {
            $_SESSION['user_id'] = $userAuth['user_id'];
            header('Location: ../admin/admin.php');
            exit;
        }

        return false;
    }

    public function oneUser($user_id) : array 
    {
        return $this->dbh->run("SELECT * from $this->usertable where user_id = $user_id")->fetch();
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public function logout() : void
    {
        session_destroy();
        header('Location: ../Auth/login.php');
        exit();
    }

    public function generateCsrfToken() : string
    {
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }
}
