<?php
require_once __DIR__ . '/../config.php';

abstract class BaseDao {
    protected $conn;
    protected $table;
    protected $fillable = [];
    protected $pk = 'id';

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    protected function filterData(array $data): array {
        return array_intersect_key($data, array_flip($this->fillable));
    }


    public function findAll($columns = '*') {
        $sql = "SELECT $columns FROM {$this->table}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id, $columns = '*') {
        $sql = "SELECT $columns FROM {$this->table} WHERE {$this->pk} = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert(array $data) {
        $data = $this->filterData($data);
        if (empty($data)) return false;

        $cols = array_keys($data);
        $placeholders = array_map(fn($c) => ':' . $c, $cols);

        $sql = "INSERT INTO {$this->table} (" . implode(",", $cols) . ")
                VALUES (" . implode(",", $placeholders) . ")";
        $stmt = $this->conn->prepare($sql);

        foreach ($data as $k => $v) {
            $stmt->bindValue(':' . $k, $v);
        }

        $ok = $stmt->execute();
        return $ok ? $this->conn->lastInsertId() : false;
    }

    public function updateById($id, array $data) {
        $data = $this->filterData($data);
        if (empty($data)) return false;

        $sets = [];
        foreach ($data as $k => $v) {
            $sets[] = "$k = :$k";
        }

        $sql = "UPDATE {$this->table} SET " . implode(", ", $sets) . " WHERE {$this->pk} = :__id";
        $stmt = $this->conn->prepare($sql);

        foreach ($data as $k => $v) {
            $stmt->bindValue(':' . $k, $v);
        }
        $stmt->bindValue(':__id', $id);

        return $stmt->execute();
    }

    public function deleteById($id) {
        $sql = "DELETE FROM {$this->table} WHERE {$this->pk} = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
