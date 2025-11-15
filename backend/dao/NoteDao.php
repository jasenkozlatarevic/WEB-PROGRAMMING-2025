<?php
require_once __DIR__ . '/BaseDao.php';

class NoteDao extends BaseDao {
    protected $table = 'notes';
    protected $fillable = ['title', 'content', 'user_id', 'category_id'];

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
