<?php
require_once __DIR__ . '/../dao/TagDao.php';

Flight::route('GET /tags', function() {
    $dao = new TagDao();
    Flight::json($dao->getAll());
});

Flight::route('GET /tags/@id', function($id) {
    $dao = new TagDao();
    Flight::json($dao->getById($id));
});

Flight::route('POST /tags', function() {
    $data = get_request_data();
    $dao = new TagDao();
    $dao->add($data);
    Flight::json(['message' => 'Tag created']);
});

Flight::route('PUT|PATCH /tags/@id', function($id) {
    $data = get_request_data();
    $dao = new TagDao();
    $dao->update($id, $data);
    Flight::json(['message' => 'Tag updated']);
});

Flight::route('DELETE /tags/@id', function($id) {
    $dao = new TagDao();
    $dao->delete($id);
    Flight::json(['message' => 'Tag deleted']);
});
