<?php
class Signup extends Dbh {
    private $username;
    private $password;
    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    private function getUsername () {
        return $this->username;
    }
    private function getPassword () {
        return $this->password;
    }

    private function setUsername ($username) {
        $this->username = $username;
    }
    private function setPassword ($password) {
        $this->password = $password;
    }

    private function insertUser () {
        $query = "INSERT INTO users ('username', 'pwd') VALUES
        (:username, :pwd);";
        // $stmt = $pdo->connect()->prepare($query);
        // $stmt = $this->connect()->prepare($query);
        $stmt = parent::connect()->prepare($query);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":pwd", $this->password);
        $stmt->execute();
    }

    private function isEmptySubmit () {
        if (isset($this->username) && isset($this->password)) {
            return false;
        }
        return true;
    }

    public function signupUser () {
        // Error handler
        if ($this->isEmptySubmit()) {
            header("location: " . $_SERVER['DOCUMENT_ROOT'] . '/index.php');
            die();
        }
        $this->insertUser();
    }
}
?>