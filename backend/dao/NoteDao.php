<?php
// backend/dao/NoteDao.php
require_once __DIR__ . '/../config.php';

class NoteDao {
    private $conn;
    public function __construct() { global $conn; $this->conn = $conn; }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM notes");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM notes WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function add($data) {
        $stmt = $this->conn->prepare("INSERT INTO notes (title, content, user_id, category_id) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data['title'] ?? None,
            $data['content'] ?? None,
            $data['user_id'] ?? None,
            $data['category_id'] ?? None
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE notes SET title=?, content=?, category_id=? WHERE id=?");
        return $stmt->execute([
            $data['title'] ?? None,
            $data['content'] ?? None,
            $data['category_id'] ?? None,
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM notes WHERE id=?");
        return $stmt->execute([$id]);
    }
}
