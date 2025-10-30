<?php
// backend/dao/NoteTagDao.php
require_once __DIR__ . '/../config.php';

class NoteTagDao {
    private $conn;
    public function __construct() { global $conn; $this->conn = $conn; }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM note_tag");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM note_tag WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function add($data) {
        $stmt = $this->conn->prepare("INSERT INTO note_tag (note_id, tag_id) VALUES (?, ?)");
        return $stmt->execute([$data['note_id'] ?? null, $data['tag_id'] ?? null]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM note_tag WHERE id=?");
        return $stmt->execute([$id]);
    }
}
