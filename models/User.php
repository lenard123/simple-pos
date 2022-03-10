<?php

require_once __DIR__.'/../_init.php';

class User
{
    public $id;
    public $name;
    public $email;
    public $role;
    public $password;


    public function getHomePage() {
        if ($this->role === ROLE_ADMIN) {
            return 'admin_home.php';
        }
        return 'index.php';
    }

    private static $currentUser = null;

    public function __construct($user)
    {
        $this->id = intval($user['id']);
        $this->name = $user['name'];
        $this->email = $user['email'];
        $this->role = $user['role'];
        $this->password = $user['password'];
    }

    public static function getAuthenticatedUser()
    {
        if (!isset($_SESSION['user_id'])) return null;

        if (!static::$currentUser) {
            static::$currentUser = static::find($_SESSION['user_id']);
        }

        return static::$currentUser;
    }

    public static function find($user_id) 
    {
        global $connection;

        $stmt = $connection->prepare("SELECT * FROM `users` WHERE id=:id");
        $stmt->bindParam("id", $user_id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
        $result = $stmt->fetchAll();

        if (count($result) >= 1) {
            return new User($result[0]);
        }

        return null;
    }

    public static function findByEmail($email) 
    {
        global $connection;

        $stmt = $connection->prepare("SELECT * FROM `users` WHERE email=:email");
        $stmt->bindParam("email", $email);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
        $result = $stmt->fetchAll();

        if (count($result) >= 1) {
            return new User($result[0]);
        }

        return null;
    }

    public static function login($email, $password) {
        if (empty($email)) throw new Exception("The email is required");
        if (empty($password)) throw new Exception("The password is required");

        $user = static::findByEmail($email);

        if ($user && $user->password == $password) {
            return $user;
        }

        throw new Exception('Wrong email or password.');
    } 
}