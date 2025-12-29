<?php

require_once __DIR__ . '/../services/BaseService.php';
require_once __DIR__ . '/../dao/NoteDao.php';

class NoteService extends BaseService {

    public function __construct() {
        parent::__construct(new NoteDao());
    }

    public function get_all_notes() {
        return $this->dao->get_all_notes();
    }

    public function get_notes_by_user_id($user_id) {
        return $this->dao->get_notes_by_user_id($user_id);
    }

    public function get_note_by_id($id) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid note ID.");
        }

        $note = $this->dao->get_note_by_id($id);
        if (!$note) {
            throw new Exception("Note not found.");
        }

        return $note;
    }

    public function create_note($note) {
        $this->validate_note_data($note);
        return $this->create($note);
    }

    public function update_note($id, $note) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid note ID.");
        }

        $existing = $this->dao->get_note_by_id($id);
        if (!$existing) {
            throw new Exception("Note with ID $id does not exist.");
        }

        $this->validate_note_data($note);

        return $this->dao->update_note($id, $note);
    }

    public function delete_note($id) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid note ID.");
        }

        $note = $this->dao->get_note_by_id($id);
        if (!$note) {
            throw new Exception("Note not found.");
        }

        return $this->delete($id);
    }

    private function validate_note_data($note) {
        if (empty($note['title']) || strlen(trim($note['title'])) < 1) {
            throw new Exception("Note title is required.");
        }

        if (empty($note['user_id']) || !is_numeric($note['user_id']) || $note['user_id'] <= 0) {
            throw new Exception("Valid user_id is required.");
        }

        if (empty($note['category_id']) || !is_numeric($note['category_id']) || $note['category_id'] <= 0) {
            throw new Exception("Valid category_id is required.");
        }
    }
}