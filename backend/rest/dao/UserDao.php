<?php
require_once __DIR__ . "/BaseDao.php"; // fixed the typo in filename

class UsersDao extends BaseDao
{
    protected $table_name;

    public function __construct()
    {
        $this->table_name = "users";
        parent::__construct($this->table_name);
    }

    public function get_all_users()
    {
        return $this->query('SELECT * FROM ' . $this->table_name, []);
    }

    public function get_user_by_id($id)
    {
        $query = "SELECT * FROM users WHERE id = :id";
        return $this->query_unique($query, ['id' => $id]);
    }

    public function get_user_by_email($email)
    {
        $query = "SELECT * FROM users WHERE email = :email";
        return $this->query_unique($query, ['email' => $email]);
    }


    // Add a new user
    public function add_user($user)
    {
        return $this->add($user);
    }

    // Update user by ID
    public function update_user($id, $user)
    {
        return $this->update($user, $id);
    }

    // Delete user by ID
    public function delete_user($id)
    {
        return $this->delete($id);
    }
}
