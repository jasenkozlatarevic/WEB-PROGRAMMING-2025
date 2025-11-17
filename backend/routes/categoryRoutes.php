<?php
require_once __DIR__ . '/../dao/CategoryDao.php';

Flight::route('GET /categories', function() {
    $dao = new CategoryDao();
    Flight::json($dao->getAll());
});

Flight::route('GET /categories/@id', function($id) {
    $dao = new CategoryDao();
    Flight::json($dao->getById($id));
});

Flight::route('POST /categories', function() {
    $data = get_request_data();
    $dao = new CategoryDao();
    $dao->add($data);
    Flight::json(['message' => 'Category created']);
});

Flight::route('PUT|PATCH /categories/@id', function($id) {
    $data = get_request_data();
    $dao = new CategoryDao();
    $dao->update($id, $data);
    Flight::json(['message' => 'Category updated']);
});

Flight::route('DELETE /categories/@id', function($id) {
    $dao = new CategoryDao();
    $dao->delete($id);
    Flight::json(['message' => 'Category deleted']);
});
