<?php
require_once __DIR__ . "/BaseDao.php";

class TagDao extends BaseDao
{
    protected $table_name;

    public function __construct()
    {
        $this->table_name = "tags";
        parent::__construct($this->table_name);
    }

    public function get_all_tags()
    {
        return $this->query('SELECT * FROM ' . $this->table_name, []);
    }

    public function get_tag_by_id($id)
    {
        $query = "SELECT * FROM tags WHERE id = :id";
        return $this->query_unique($query, ['id' => $id]);
    }

    // Add a new tag
    public function add_tag($tag)
    {
        return $this->add($tag);
    }

    // Update tag by ID
    public function update_tag($id, $tag)
    {
        return $this->update($tag, $id);
    }

    // Delete tag by ID
    public function delete_tag($id)
    {
        return $this->delete($id);
    }
}