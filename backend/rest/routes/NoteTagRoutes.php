<?php

require_once __DIR__ . '/../services/NoteTagService.php';
require_once __DIR__ . '/../../data/roles.php';

$noteTagService = new NoteTagService();
Flight::register('noteTagService', 'NoteTagService');

/**
 * @OA\Get(
 *     path="/note-tags",
 *     tags={"NoteTags"},
 *     summary="Get all note tags",
 *     @OA\Response(
 *         response=200,
 *         description="List of all note tags"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /note-tags', function () use ($noteTagService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json($noteTagService->get_all_note_tags());
});

/**
 * @OA\Get(
 *     path="/note-tags/{id}",
 *     tags={"NoteTags"},
 *     summary="Get note tag by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="NoteTag ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="NoteTag found"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /note-tags/@id', function ($id) use ($noteTagService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json($noteTagService->get_note_tag_by_id($id));
});

/**
 * @OA\Post(
 *     path="/note-tags",
 *     tags={"NoteTags"},
 *     summary="Create new note tag",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"note_id", "tag_id"},
 *             @OA\Property(property="note_id", type="integer"),
 *             @OA\Property(property="tag_id", type="integer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="NoteTag created successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('POST /note-tags', function () use ($noteTagService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json($noteTagService->create_note_tag($data));
});

/**
 * @OA\Put(
 *     path="/note-tags/{id}",
 *     tags={"NoteTags"},
 *     summary="Update note tag",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="NoteTag ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="note_id", type="integer"),
 *             @OA\Property(property="tag_id", type="integer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="NoteTag updated successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('PUT /note-tags/@id', function ($id) use ($noteTagService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json($noteTagService->update_note_tag($id, $noteTagService));
});

/**
 * @OA\Delete(
 *     path="/note-tags/{id}",
 *     tags={"NoteTags"},
 *     summary="Delete note tag",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="NoteTag ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="NoteTag deleted successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('DELETE /note-tags/@id', function ($id) use ($noteTagService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json($noteTagService->delete_note_tag($id));
});