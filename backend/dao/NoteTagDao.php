<?php
require_once __DIR__ . '/BaseDao.php';

class NoteTagDao extends BaseDao {
    protected $table = 'note_tag';
    protected $fillable = ['note_id', 'tag_id'];

    public function getAll() {
        return $this->findAll('*');
    }

    public function getById($id) {
        return $this->findById($id, '*');
    }

    public function add($data) {
        return $this->insert($data);
    }

    public function delete($id) {
        return $this->deleteById($id);
    }
}
