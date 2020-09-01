<?php

class Authentication
{
    private $db;

    public function __construct()
    {
        $this->db = new Databases();
    }

    public function register(array $data)
    {
        $this->db->query("INSERT INTO admin (username, email, password) VALUES(?, ?, ?)");
        for ($i = 0; $i < count($data); $i++) {
            $this->db->bind(($i + 1), $data[$i]);
        }
        if ($this->db->execute()) {
            return true;
        }
        return false;
    }

    public function login(array $data)
    {
        $this->db->query("SELECT * FROM admin where email=?");
        $this->db->bind(1, $data[0]);
        $result = $this->db->single();
        $db_pass = $result->password;

        if (password_verify($data[1], $db_pass)) {
            return $result;
        }
        return false;
    }

    public function hasUser()
    {
        $this->db->query("SELECT * FROM admin");
        $this->db->execute();

        if ($this->db->rowCount() > 0) {
            return true;
        }
        return false;
    }
}