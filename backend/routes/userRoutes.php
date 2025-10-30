<?php
require_once __DIR__ . '/../dao/UserDao.php';

Flight::route('GET /users', function() {
    $dao = new UserDao();
    Flight::json($dao->getAll());
});

Flight::route('GET /users/@id', function($id) {
    $dao = new UserDao();
    Flight::json($dao->getById($id));
});

Flight::route('POST /users', function() {
    $data = get_request_data();
    $dao = new UserDao();
    $dao->add($data);
    Flight::json(['message' => 'User created']);
});

Flight::route('PUT|PATCH /users/@id', function($id) {
    $data = get_request_data();
    $dao = new UserDao();
    $dao->update($id, $data);
    Flight::json(['message' => 'User updated']);
});

Flight::route('DELETE /users/@id', function($id) {
    $dao = new UserDao();
    $dao->delete($id);
    Flight::json(['message' => 'User deleted']);
});
