<?php
require_once __DIR__ . '/BaseDao.php';

class CategoryDao extends BaseDao {
    protected $table = 'categories';
    protected $fillable = ['name', 'description'];

    public function getAll() {
        return $this->findAll('*');
    }

    public function getById($id) {
        return $this->findById($id, '*');
    }

    public function add($data) {
        return $this->insert($data);
    }

    public function update($id, $data) {
        return $this->updateById($id, $data);
    }

    public function delete($id) {
        return $this->deleteById($id);
    }
}
