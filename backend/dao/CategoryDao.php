<?php
// backend/dao/CategoryDao.php
require_once __DIR__ . '/../config.php';

class CategoryDao {
    private $conn;
    public function __construct() { global $conn; $this->conn = $conn; }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM categories");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function add($data) {
        $stmt = $this->conn->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
        return $stmt->execute([$data['name'] ?? null, $data['description'] ?? null]);
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE categories SET name=?, description=? WHERE id=?");
        return $stmt->execute([$data['name'] ?? null, $data['description'] ?? null, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM categories WHERE id=?");
        return $stmt->execute([$id]);
    }
}
