<?php
require_once __DIR__ . '/../services/NoteService.php';

$noteService = new NoteService();

Flight::route('GET /notes', function () use ($noteService) {
    Flight::json($noteService->getAllNotes());
});

Flight::route('GET /notes/@id', function ($id) use ($noteService) {
    try {
        $note = $noteService->getNoteById($id);
        Flight::json($note);
    } catch (Exception $e) {
        Flight::halt(400, json_encode(['error' => $e->getMessage()]));
    }
});

Flight::route('POST /notes', function () use ($noteService) {
    $data = get_request_data();
    try {
        $id = $noteService->createNote($data);
        Flight::json(['message' => 'Note created', 'id' => $id]);
    } catch (Exception $e) {
        Flight::halt(400, json_encode(['error' => $e->getMessage()]));
    }
});

Flight::route('PUT /notes/@id', function ($id) use ($noteService) {
    $data = get_request_data();
    try {
        $noteService->updateNote($id, $data);
        Flight::json(['message' => 'Note updated']);
    } catch (Exception $e) {
        Flight::halt(400, json_encode(['error' => $e->getMessage()]));
    }
});

Flight::route('DELETE /notes/@id', function ($id) use ($noteService) {
    try {
        $noteService->deleteNote($id);
        Flight::json(['message' => 'Note deleted']);
    } catch (Exception $e) {
        Flight::halt(400, json_encode(['error' => $e->getMessage()]));
    }
});
