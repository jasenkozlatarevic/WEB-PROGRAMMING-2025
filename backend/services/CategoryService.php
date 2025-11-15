<?php
require_once __DIR__ . '/../dao/CategoryDao.php';

class CategoryService {
    private $dao;

    public function __construct() {
        $this->dao = new CategoryDao();
    }

    public function getAllCategories() {
        return $this->dao->getAll();
    }

    public function getCategoryById($id) {
        if (!is_numeric($id)) {
            throw new Exception("Invalid category id");
        }
        $cat = $this->dao->getById($id);
        if (!$cat) {
            throw new Exception("Category not found");
        }
        return $cat;
    }

    public function createCategory($data) {
        if (empty($data['name'])) {
            throw new Exception("Category name is required");
        }
        return $this->dao->add($data);
    }

    public function updateCategory($id, $data) {
        if (!is_numeric($id)) {
            throw new Exception("Invalid category id");
        }
        return $this->dao->update($id, $data);
    }

    public function deleteCategory($id) {
        if (!is_numeric($id)) {
            throw new Exception("Invalid category id");
        }
        return $this->dao->delete($id);
    }
}
