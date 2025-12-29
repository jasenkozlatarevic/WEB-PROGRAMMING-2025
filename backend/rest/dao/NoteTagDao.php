<?php
require_once __DIR__ . "/BaseDao.php";

class NoteTagDao extends BaseDao
{
    protected $table_name;

    public function __construct()
    {
        $this->table_name = "note_tag";
        parent::__construct($this->table_name);
    }

    public function get_all_note_tags()
    {
        return $this->query('SELECT * FROM ' . $this->table_name, []);
    }

    public function get_note_tag_by_id($id)
    {
        $query = "SELECT * FROM note_tag WHERE id = :id";
        return $this->query_unique($query, ['id' => $id]);
    }

    // Add a new note tag
    public function add_note_tag($note_tag)
    {
        return $this->add($note_tag);
    }

    // Update note tag by ID
    public function update_note_tag($id, $note_tag)
    {
        return $this->update($note_tag, $id);
    }

    // Delete note tag by ID
    public function delete_note_tag($id)
    {
        return $this->delete($id);
    }
}