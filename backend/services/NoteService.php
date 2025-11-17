<?php
require_once __DIR__ . '/../dao/NoteDao.php';

class NoteService {
    private $dao;

    public function __construct() {
        $this->dao = new NoteDao();
    }

    public function getAllNotes() {
        return $this->dao->getAll();
    }

    public function getNoteById($id) {
        if (!is_numeric($id)) {
            throw new Exception("Invalid note id");
        }
        $note = $this->dao->getById($id);
        if (!$note) {
            throw new Exception("Note not found");
        }
        return $note;
    }

    public function createNote($data) {
        if (empty($data['title'])) {
            throw new Exception("Note title is required");
        }
        if (empty($data['user_id']) || !is_numeric($data['user_id'])) {
            throw new Exception("Valid user_id is required");
        }
        if (empty($data['category_id']) || !is_numeric($data['category_id'])) {
            throw new Exception("Valid category_id is required");
        }
        return $this->dao->add($data);
    }

    public function updateNote($id, $data) {
        if (!is_numeric($id)) {
            throw new Exception("Invalid note id");
        }
        return $this->dao->update($id, $data);
    }

    public function deleteNote($id) {
        if (!is_numeric($id)) {
            throw new Exception("Invalid note id");
        }
        return $this->dao->delete($id);
    }
}
