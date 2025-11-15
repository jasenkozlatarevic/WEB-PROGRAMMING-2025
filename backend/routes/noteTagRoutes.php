<?php
require_once __DIR__ . '/../services/NoteTagService.php';

$noteTagService = new NoteTagService();

Flight::route('GET /note-tags', function () use ($noteTagService) {
    Flight::json($noteTagService->getAllNoteTags());
});

Flight::route('GET /note-tags/@id', function ($id) use ($noteTagService) {
    try {
        $nt = $noteTagService->getNoteTagById($id);
        Flight::json($nt);
    } catch (Exception $e) {
        Flight::halt(400, json_encode(['error' => $e->getMessage()]));
    }
});

Flight::route('POST /note-tags', function () use ($noteTagService) {
    $data = get_request_data();
    try {
        $id = $noteTagService->createNoteTag($data);
        Flight::json(['message' => 'NoteTag created', 'id' => $id]);
    } catch (Exception $e) {
        Flight::halt(400, json_encode(['error' => $e->getMessage()]));
    }
});

Flight::route('DELETE /note-tags/@id', function ($id) use ($noteTagService) {
    try {
        $noteTagService->deleteNoteTag($id);
        Flight::json(['message' => 'NoteTag deleted']);
    } catch (Exception $e) {
        Flight::halt(400, json_encode(['error' => $e->getMessage()]));
    }
});
