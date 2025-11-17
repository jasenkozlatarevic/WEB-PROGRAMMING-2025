<?php
require_once __DIR__ . '/../services/TagService.php';

$tagService = new TagService();

Flight::route('GET /tags', function () use ($tagService) {
    Flight::json($tagService->getAllTags());
});

Flight::route('GET /tags/@id', function ($id) use ($tagService) {
    try {
        $tag = $tagService->getTagById($id);
        Flight::json($tag);
    } catch (Exception $e) {
        Flight::halt(400, json_encode(['error' => $e->getMessage()]));
    }
});

Flight::route('POST /tags', function () use ($tagService) {
    $data = get_request_data();
    try {
        $id = $tagService->createTag($data);
        Flight::json(['message' => 'Tag created', 'id' => $id]);
    } catch (Exception $e) {
        Flight::halt(400, json_encode(['error' => $e->getMessage()]));
    }
});

Flight::route('PUT /tags/@id', function ($id) use ($tagService) {
    $data = get_request_data();
    try {
        $tagService->updateTag($id, $data);
        Flight::json(['message' => 'Tag updated']);
    } catch (Exception $e) {
        Flight::halt(400, json_encode(['error' => $e->getMessage()]));
    }
});

Flight::route('DELETE /tags/@id', function ($id) use ($tagService) {
    try {
        $tagService->deleteTag($id);
        Flight::json(['message' => 'Tag deleted']);
    } catch (Exception $e) {
        Flight::halt(400, json_encode(['error' => $e->getMessage()]));
    }
});
