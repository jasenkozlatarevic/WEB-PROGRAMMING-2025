<?php
require_once __DIR__ . "/BaseDao.php";

class NoteDao extends BaseDao
{
    protected $table_name;

    public function __construct()
    {
        $this->table_name = "notes";
        parent::__construct($this->table_name);
    }

    public function get_all_notes()
    {
        return $this->query('SELECT * FROM ' . $this->table_name, []);
    }

    public function get_notes_by_user_id($user_id)
    {
        $query = "SELECT * FROM notes WHERE user_id = :user_id";
        return $this->query($query, ['user_id' => $user_id]);
    }

    public function get_note_by_id($id)
    {
        $query = "SELECT * FROM notes WHERE id = :id";
        return $this->query_unique($query, ['id' => $id]);
    }

    // Add a new note
    public function add_note($note)
    {
        return $this->add($note);
    }

    // Update note by ID
    public function update_note($id, $note)
    {
        return $this->update($note, $id);
    }

    // Delete note by ID
    public function delete_note($id)
    {
        return $this->delete($id);
    }
}