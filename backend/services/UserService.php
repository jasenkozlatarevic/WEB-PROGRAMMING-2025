<?php
require_once __DIR__ . '/../dao/UserDao.php';

class UserService {
    private $dao;

    public function __construct() {
        $this->dao = new UserDao();
    }

    public function getAllUsers() {
        return $this->dao->getAll();
    }

    public function getUserById($id) {
        if (!is_numeric($id)) {
            throw new Exception("Invalid user id");
        }
        $user = $this->dao->getById($id);
        if (!$user) {
            throw new Exception("User not found");
        }
        return $user;
    }

    public function createUser($data) {
        if (empty($data['username']) || empty($data['email']) || empty($data['password'])) {
            throw new Exception("username, email and password are required");
        }
        if (strlen($data['password']) < 4) {
            throw new Exception("Password must be at least 4 characters long");
        }
        if (empty($data['role'])) {
            $data['role'] = 'user';
        }

        return $this->dao->add($data);
    }

    public function updateUser($id, $data) {
        if (!is_numeric($id)) {
            throw new Exception("Invalid user id");
        }
        return $this->dao->update($id, $data);
    }

    public function deleteUser($id) {
        if (!is_numeric($id)) {
            throw new Exception("Invalid user id");
        }
        return $this->dao->delete($id);
    }
}
