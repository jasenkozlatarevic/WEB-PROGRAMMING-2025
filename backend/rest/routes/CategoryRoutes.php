<?php

require_once __DIR__ . '/../services/CategoryService.php';
require_once __DIR__ . '/../../data/roles.php';

$categoryService = new CategoryService();
Flight::register('categoryService', 'CategoryService');

/**
 * @OA\Get(
 *     path="/categories",
 *     tags={"Categories"},
 *     summary="Get all categories",
 *     @OA\Response(
 *         response=200,
 *         description="List of all categories"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /categories', function () use ($categoryService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json($categoryService->get_all_categories());
});

/**
 * @OA\Get(
 *     path="/categories/{id}",
 *     tags={"Categories"},
 *     summary="Get category by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Category ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category found"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /categories/@id', function ($id) use ($categoryService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json($categoryService->get_category_by_id($id));
});

/**
 * @OA\Post(
 *     path="/categories",
 *     tags={"Categories"},
 *     summary="Create new category",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name"},
 *             @OA\Property(property="name", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category created successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('POST /categories', function () use ($categoryService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json($categoryService->create_category($data));
});

/**
 * @OA\Put(
 *     path="/categories/{id}",
 *     tags={"Categories"},
 *     summary="Update category",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Category ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category updated successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('PUT /categories/@id', function ($id) use ($categoryService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json($categoryService->update_category($id, $data));
});

/**
 * @OA\Delete(
 *     path="/categories/{id}",
 *     tags={"Categories"},
 *     summary="Delete category",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Category ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category deleted successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('DELETE /categories/@id', function ($id) use ($categoryService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json($categoryService->delete_category($id));
});