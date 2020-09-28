<?php

class Misc
{
    private $db;

    public function __construct()
    {
        $this->db = new Databases;
    }

    public function getUserDetails($username = "Nathan Drake")
    {
        $this->db->query("SELECT * FROM admin WHERE username=?");
        $this->db->bind(1, $username);
        $result = $this->db->single();
        if ($this->db->rowCount() > 0) {
            return $result;
        }
        return false;
    }

    public function getNumPosts()
    {
        $this->db->query("SELECT * FROM posts");
        $this->db->execute();
        $data = $this->db->rowCount();
        return $data;
    }

    public function getNumUsers()
    {
        $this->db->query("SELECT * FROM admin");
        $this->db->execute();
        $data = $this->db->rowCount();
        return $data;
    }

    public function getNumCategories()
    {
        $this->db->query("SELECT * FROM categories");
        $this->db->execute();
        $data = $this->db->rowCount();
        return $data;
    }
}
