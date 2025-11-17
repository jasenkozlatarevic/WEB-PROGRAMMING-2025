<?php
require_once __DIR__ . '/../dao/NoteDao.php';

Flight::route('GET /notes', function() {
    $dao = new NoteDao();
    Flight::json($dao->getAll());
});

Flight::route('GET /notes/@id', function($id) {
    $dao = new NoteDao();
    Flight::json($dao->getById($id));
});

Flight::route('POST /notes', function() {
    $data = get_request_data();
    $dao = new NoteDao();
    $dao->add($data);
    Flight::json(['message' => 'Note created']);
});

Flight::route('PUT|PATCH /notes/@id', function($id) {
    $data = get_request_data();
    $dao = new NoteDao();
    $dao->update($id, $data);
    Flight::json(['message' => 'Note updated']);
});

Flight::route('DELETE /notes/@id', function($id) {
    $dao = new NoteDao();
    $dao->delete($id);
    Flight::json(['message' => 'Note deleted']);
});
