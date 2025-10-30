<?php
// backend/dao/TagDao.php
require_once __DIR__ . '/../config.php';

class TagDao {
    private $conn;
    public function __construct() { global $conn; $this->conn = $conn; }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM tags");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM tags WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function add($data) {
        $stmt = $this->conn->prepare("INSERT INTO tags (name) VALUES (?)");
        return $stmt->execute([$data['name'] ?? null]);
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE tags SET name=? WHERE id=?");
        return $stmt->execute([$data['name'] ?? null, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM tags WHERE id=?");
        return $stmt->execute([$id]);
    }
}
