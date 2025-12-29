<?php
require_once __DIR__ . '/../services/TagService.php';
require_once __DIR__ . '/../../data/roles.php';

$tagService = new TagService();
Flight::register('tagService', 'TagService');

/**
 * @OA\Get(
 *     path="/tags",
 *     tags={"Tags"},
 *     summary="Get all tags",
 *     @OA\Response(
 *         response=200,
 *         description="List of all tags"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /tags', function () use ($tagService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json($tagService->get_all_tags());
});

/**
 * @OA\Get(
 *     path="/tags/{id}",
 *     tags={"Tags"},
 *     summary="Get tag by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Tag ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Tag found"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /tags/@id', function ($id) use ($tagService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json($tagService->get_tag_by_id($id));
});

/**
 * @OA\Post(
 *     path="/tags",
 *     tags={"Tags"},
 *     summary="Create new tag",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name"},
 *             @OA\Property(property="name", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Tag created successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('POST /tags', function () use ($tagService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json($tagService->create_tag($data));
});

/**
 * @OA\Put(
 *     path="/tags/{id}",
 *     tags={"Tags"},
 *     summary="Update tag",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Tag ID",
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
 *         description="Tag updated successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('PUT /tags/@id', function ($id) use ($tagService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json($tagService->update_tag($id, $data));
});

/**
 * @OA\Delete(
 *     path="/tags/{id}",
 *     tags={"Tags"},
 *     summary="Delete tag",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Tag ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Tag deleted successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('DELETE /tags/@id', function ($id) use ($tagService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json($tagService->delete_tag($id));
});