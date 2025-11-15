<?php
require_once __DIR__ . '/../services/CategoryService.php';

$categoryService = new CategoryService();

Flight::route('GET /categories', function () use ($categoryService) {
    Flight::json($categoryService->getAllCategories());
});

Flight::route('GET /categories/@id', function ($id) use ($categoryService) {
    try {
        $cat = $categoryService->getCategoryById($id);
        Flight::json($cat);
    } catch (Exception $e) {
        Flight::halt(400, json_encode(['error' => $e->getMessage()]));
    }
});

Flight::route('POST /categories', function () use ($categoryService) {
    $data = get_request_data();
    try {
        $id = $categoryService->createCategory($data);
        Flight::json(['message' => 'Category created', 'id' => $id]);
    } catch (Exception $e) {
        Flight::halt(400, json_encode(['error' => $e->getMessage()]));
    }
});

Flight::route('PUT /categories/@id', function ($id) use ($categoryService) {
    $data = get_request_data();
    try {
        $categoryService->updateCategory($id, $data);
        Flight::json(['message' => 'Category updated']);
    } catch (Exception $e) {
        Flight::halt(400, json_encode(['error' => $e->getMessage()]));
    }
});

Flight::route('DELETE /categories/@id', function ($id) use ($categoryService) {
    try {
        $categoryService->deleteCategory($id);
        Flight::json(['message' => 'Category deleted']);
    } catch (Exception $e) {
        Flight::halt(400, json_encode(['error' => $e->getMessage()]));
    }
});
