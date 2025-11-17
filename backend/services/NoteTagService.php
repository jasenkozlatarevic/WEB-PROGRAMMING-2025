<?php
require_once __DIR__ . '/../dao/NoteTagDao.php';

class NoteTagService {
    private $dao;

    public function __construct() {
        $this->dao = new NoteTagDao();
    }

    public function getAllNoteTags() {
        return $this->dao->getAll();
    }

    public function getNoteTagById($id) {
        if (!is_numeric($id)) {
            throw new Exception("Invalid note_tag id");
        }
        $nt = $this->dao->getById($id);
        if (!$nt) {
            throw new Exception("NoteTag not found");
        }
        return $nt;
    }

    public function createNoteTag($data) {
        if (empty($data['note_id']) || !is_numeric($data['note_id'])) {
            throw new Exception("Valid note_id is required");
        }
        if (empty($data['tag_id']) || !is_numeric($data['tag_id'])) {
            throw new Exception("Valid tag_id is required");
        }
        return $this->dao->add($data);
    }

    public function deleteNoteTag($id) {
        if (!is_numeric($id)) {
            throw new Exception("Invalid note_tag id");
        }
        return $this->dao->delete($id);
    }
}
