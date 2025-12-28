<?php
require_once __DIR__ . '/../services/BaseService.php';
require_once __DIR__ . '/../dao/TagDao.php';

class TagService extends BaseService {

    public function __construct() {
        parent::__construct(new TagDao());
    }

    public function get_all_tags() {
        return $this->dao->get_all_tags();
    }

    public function get_tag_by_id($id) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid tag ID.");
        }

        $tag = $this->dao->get_tag_by_id($id);
        if (!$tag) {
            throw new Exception("Tag not found.");
        }

        return $tag;
    }

    public function create_tag($tag) {
        $this->validate_tag_data($tag);
        return $this->create($tag);
    }

    public function update_tag($id, $tag) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid tag ID.");
        }

        $existing = $this->dao->get_tag_by_id($id);
        if (!$existing) {
            throw new Exception("Tag with ID $id does not exist.");
        }

        $this->validate_tag_data($tag);

        return $this->dao->update_tag($id, $tag);
    }

    public function delete_tag($id) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid tag ID.");
        }

        $tag = $this->dao->get_tag_by_id($id);
        if (!$tag) {
            throw new Exception("Tag not found.");
        }

        return $this->delete($id);
    }

    private function validate_tag_data($tag) {
        if (empty($tag['name']) || strlen(trim($tag['name'])) < 1) {
            throw new Exception("Tag name is required.");
        }
    }
}