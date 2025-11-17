<?php
require_once __DIR__ . '/BaseDao.php';

class UserDao extends BaseDao {
    protected $table = 'users';
    protected $fillable = ['username', 'email', 'password', 'role'];

    public function getAll() {
        return $this->findAll('id, username, email, role');
    }

    public function getById($id) {
        return $this->findById($id, 'id, username, email, role');
    }

    public function add($data) {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }
        return $this->insert($data);
    }

    public function update($id, $data) {
        unset($data['password']);
        return $this->updateById($id, $data);
    }

    public function delete($id) {
        return $this->deleteById($id);
    }
}
