<?php

class Posts
{
    public static $pageno;

    public $totalPages;

    private $db;

    public function __construct()
    {
        $this->db = new Databases;
    }

    public function addPost(array $data)
    {
        $this->db->query("INSERT INTO posts
                            (title, content, category, tags, image, author, status, slug, date_added)
                            VALUES(?,?,?,?,?,?,?,?,?)
        ");

        for ($i = 0; $i < count($data); $i++) {
            $this->db->bind(($i + 1), $data[$i]);
        }

        if ($this->db->execute()) {
            return true;
        }
        return false;
    }

    public function editPost(array $data)
    {
        $this->db->query("UPDATE posts SET title=?, content=?, category=?, tags=?, image=? WHERE id=?");

        for ($i = 0; $i < count($data); $i++) {
            $this->db->bind(($i + 1), $data[$i]);
        }

        if ($this->db->execute()) {
            return true;
        }
        return false;
    }

    public function loadSingle($id)
    {
        $this->db->query("SELECT * FROM posts WHERE id=? OR slug=? AND status=true");
        $this->db->bind(1, $id);
        $this->db->bind(2, $id);
        $data = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return $data;
        }
        return false;
    }

    public function loadPosts()
    {
        $conn = mysqli_connect("localhost", "root", "", "blogging_system");
        $recordPerPage = 5;
        $offset = (Posts::$pageno - 1) * $recordPerPage;
        $totalpages = "SELECT COUNT(*) FROM posts WHERE status=true ORDER BY id DESC";
        $result = mysqli_query($conn, $totalpages);
        $totalRows = mysqli_fetch_array($result)[0];
        $this->totalPages = ceil($totalRows / $recordPerPage);

        // get records from db
        $this->db->query("SELECT * FROM posts WHERE status = true ORDER BY id DESC LIMIT $offset, $recordPerPage");
        $data = $this->db->resultset();
        if ($this->db->rowCount() > 0) {
            return $data;
        }
        return false;
    }

    public function loadTrashPosts()
    {
        $conn = mysqli_connect("localhost", "root", "", "blogging_system");
        $recordPerPage = 5;
        $offset = (Posts::$pageno - 1) * $recordPerPage;
        $totalpages = "SELECT COUNT(*) FROM posts WHERE status = false ORDER BY id DESC";
        $result = mysqli_query($conn, $totalpages);
        $totalRows = mysqli_fetch_array($result)[0];
        $this->totalPages = ceil($totalRows / $recordPerPage);

        // get records from db
        $this->db->query("SELECT * FROM posts WHERE status = false ORDER BY id DESC LIMIT $offset, $recordPerPage");
        $data = $this->db->resultset();
        if ($this->db->rowCount() > 0) {
            return $data;
        }
        return false;
    }

    public function deletePost($id, $image)
    {
        $this->db->query("DELETE FROM posts WHERE id=?");
        $this->db->bind(1, $id);
        if ($this->db->execute()) {
            unlink($image);
            return true;
        }
        return false;
    }

    public function trashPost($id)
    {
        $this->db->query("UPDATE posts SET status=false WHERE id=?");
        $this->db->bind(1, $id);
        if ($this->db->execute()) {
            return true;
        }
        return false;
    }

    public function restorePost($id)
    {
        $this->db->query("UPDATE posts SET status=true WHERE id=?");
        $this->db->bind(1, $id);
        if ($this->db->execute()) {
            return true;
        }
        return false;
    }
}
