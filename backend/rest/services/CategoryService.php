<?php

require_once __DIR__ . '/../services/BaseService.php';
require_once __DIR__ . '/../dao/CategoryDao.php';

class CategoryService extends BaseService {

    public function __construct() {
        parent::__construct(new CategoryDao());
    }

    public function get_all_categories() {
        return $this->dao->get_all_categories();
    }

    public function get_category_by_id($id) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid category ID.");
        }

        $category = $this->dao->get_category_by_id($id);
        if (!$category) {
            throw new Exception("Category not found.");
        }

        return $category;
    }

    public function create_category($category) {
        $this->validate_category_data($category);
        return $this->create($category);
    }

    public function update_category($id, $category) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid category ID.");
        }

        $existing = $this->dao->get_category_by_id($id);
        if (!$existing) {
            throw new Exception("Category with ID $id does not exist.");
        }

        $this->validate_category_data($category);

        return $this->dao->update_category($id, $category);
    }

    public function delete_category($id) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid category ID.");
        }

        $category = $this->dao->get_category_by_id($id);
        if (!$category) {
            throw new Exception("Category not found.");
        }

        return $this->delete($id);
    }

    private function validate_category_data($category) {
        if (empty($category['name']) || strlen(trim($category['name'])) < 1) {
            throw new Exception("Category name is required.");
        }
    }
}