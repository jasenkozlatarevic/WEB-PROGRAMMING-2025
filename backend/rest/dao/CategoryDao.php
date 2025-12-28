<?php
require_once __DIR__ . "/BaseDao.php";

class CategoryDao extends BaseDao
{
    protected $table_name;

    public function __construct()
    {
        $this->table_name = "categories";
        parent::__construct($this->table_name);
    }

    public function get_all_categories()
    {
        return $this->query('SELECT * FROM ' . $this->table_name, []);
    }

    public function get_category_by_id($id)
    {
        $query = "SELECT * FROM categories WHERE id = :id";
        return $this->query_unique($query, ['id' => $id]);
    }

    // Add a new category
    public function add_category($category)
    {
        return $this->add($category);
    }

    // Update category by ID
    public function update_category($id, $category)
    {
        return $this->update($category, $id);
    }

    // Delete category by ID
    public function delete_category($id)
    {
        return $this->delete($id);
    }
}