<?php

require_once 'BaseService.php';
require_once __DIR__ . '/../dao/AuthDao.php';

use Firebase\JWT\JWT;

class AuthService extends BaseService {

    private $auth_dao;

    public function __construct() {
        $this->auth_dao = new AuthDao();
        parent::__construct(new AuthDao());
    }

    /* ================= REGISTER ================= */
    public function register($entity) {

        if (
            empty($entity['username']) ||
            empty($entity['email']) ||
            empty($entity['password']) ||
            empty($entity['role'])
        ) {
            Flight::halt(400, "Username, email, password and role are required.");
        }

        if ($this->auth_dao->get_user_by_email($entity['email'])) {
            Flight::halt(409, "Email already registered.");
        }

        $entity['password'] = password_hash($entity['password'], PASSWORD_BCRYPT);

        $user = parent::create($entity);

        unset($user['password']);

        return $user;
    }

    /* ================= LOGIN ================= */
    public function login($entity) {

        if (empty($entity['email']) || empty($entity['password'])) {
            Flight::halt(400, "Email and password are required.");
        }

        $user = $this->auth_dao->get_user_by_email($entity['email']);

        if (!$user || !password_verify($entity['password'], $user['password'])) {
            Flight::halt(401, "Invalid username or password.");
        }

        unset($user['password']);

        $jwt_payload = [
            'user' => $user,
            'iat'  => time(),
            'exp'  => time() + (60 * 60 * 24) // 24h
        ];

        $token = JWT::encode(
            $jwt_payload,
            Config::JWT_SECRET(),
            'HS256'
        );

        return [
            'token' => $token,
            'user'  => $user
        ];
    }

    /* ================= HELPER ================= */
    public function get_user_by_email($email) {
        return $this->auth_dao->get_user_by_email($email);
    }
}
