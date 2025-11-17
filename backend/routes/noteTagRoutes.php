<?php
require_once __DIR__ . '/../dao/NoteTagDao.php';

Flight::route('GET /note-tags', function() {
    $dao = new NoteTagDao();
    Flight::json($dao->getAll());
});

Flight::route('GET /note-tags/@id', function($id) {
    $dao = new NoteTagDao();
    Flight::json($dao->getById($id));
});

Flight::route('POST /note-tags', function() {
    $data = get_request_data();
    $dao = new NoteTagDao();
    $dao->add($data);
    Flight::json(['message' => 'Note-Tag relation created']);
});

Flight::route('DELETE /note-tags/@id', function($id) {
    $dao = new NoteTagDao();
    $dao->delete($id);
    Flight::json(['message' => 'Note-Tag relation deleted']);
});
