<?php
// backend/dao/UserDao.php
require_once __DIR__ . '/../config.php';

class UserDao {
    private $conn;
    public function __construct() { global $conn; $this->conn = $conn; }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT id, username, email, role FROM users");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT id, username, email, role FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function add($data) {
        $stmt = $this->conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data['username'] ?? null,
            $data['email'] ?? null,
            password_hash($data['password'] ?? '', PASSWORD_BCRYPT),
            $data['role'] ?? 'user'
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE users SET username=?, email=?, role=? WHERE id=?");
        return $stmt->execute([
            $data['username'] ?? null,
            $data['email'] ?? null,
            $data['role'] ?? 'user',
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id=?");
        return $stmt->execute([$id]);
    }
}
