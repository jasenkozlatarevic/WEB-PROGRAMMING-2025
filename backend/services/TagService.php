<?php
require_once __DIR__ . '/../dao/TagDao.php';

class TagService {
    private $dao;

    public function __construct() {
        $this->dao = new TagDao();
    }

    public function getAllTags() {
        return $this->dao->getAll();
    }

    public function getTagById($id) {
        if (!is_numeric($id)) {
            throw new Exception("Invalid tag id");
        }
        $tag = $this->dao->getById($id);
        if (!$tag) {
            throw new Exception("Tag not found");
        }
        return $tag;
    }

    public function createTag($data) {
        if (empty($data['name'])) {
            throw new Exception("Tag name is required");
        }
        return $this->dao->add($data);
    }

    public function updateTag($id, $data) {
        if (!is_numeric($id)) {
            throw new Exception("Invalid tag id");
        }
        return $this->dao->update($id, $data);
    }

    public function deleteTag($id) {
        if (!is_numeric($id)) {
            throw new Exception("Invalid tag id");
        }
        return $this->dao->delete($id);
    }
}
