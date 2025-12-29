<?php

require_once __DIR__ . '/../services/BaseService.php';
require_once __DIR__ . '/../dao/NoteTagDao.php';

class NoteTagService extends BaseService {

    public function __construct() {
        parent::__construct(new NoteTagDao());
    }

    public function get_all_note_tags() {
        return $this->dao->get_all_note_tags();
    }

    public function get_note_tag_by_id($id) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid note_tag ID.");
        }

        $note_tag = $this->dao->get_note_tag_by_id($id);
        if (!$note_tag) {
            throw new Exception("NoteTag not found.");
        }

        return $note_tag;
    }

    public function create_note_tag($note_tag) {
        $this->validate_note_tag_data($note_tag);
        return $this->create($note_tag);
    }

    public function update_note_tag($id, $note_tag) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid note_tag ID.");
        }

        $existing = $this->dao->get_note_tag_by_id($id);
        if (!$existing) {
            throw new Exception("NoteTag with ID $id does not exist.");
        }

        $this->validate_note_tag_data($note_tag);

        return $this->dao->update_note_tag($id, $note_tag);
    }

    public function delete_note_tag($id) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid note_tag ID.");
        }

        $note_tag = $this->dao->get_note_tag_by_id($id);
        if (!$note_tag) {
            throw new Exception("NoteTag not found.");
        }

        return $this->delete($id);
    }

    private function validate_note_tag_data($note_tag) {
        if (empty($note_tag['note_id']) || !is_numeric($note_tag['note_id']) || $note_tag['note_id'] <= 0) {
            throw new Exception("Valid note_id is required.");
        }

        if (empty($note_tag['tag_id']) || !is_numeric($note_tag['tag_id']) || $note_tag['tag_id'] <= 0) {
            throw new Exception("Valid tag_id is required.");
        }
    }
}