<?php

require_once __DIR__ . '/../services/NoteService.php';
require_once __DIR__ . '/../../data/roles.php';

$noteService = new NoteService();
Flight::register('noteService', 'NoteService');

/**
 * @OA\Get(
 *     path="/notes",
 *     tags={"Notes"},
 *     summary="Get all notes",
 *     @OA\Response(
 *         response=200,
 *         description="List of all notes"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /notes', function () use ($noteService) {
    $auth = Flight::request()->getHeader('Authorization');
    if (!$auth) {
        Flight::halt(401, "Missing Authorization header");
    }
    $token = str_replace("Bearer ", "", $auth);
    Flight::auth_middleware()->verifyToken($token);

    $user = Flight::get('user');
    if ($user->role === Roles::ADMIN) {
        Flight::json($noteService->get_all_notes());
    } else {
        Flight::json($noteService->get_notes_by_user_id($user->id));
    }
});

/**
 * @OA\Get(
 *     path="/notes/{id}",
 *     tags={"Notes"},
 *     summary="Get note by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Note ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Note found"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /notes/@id', function ($id) use ($noteService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json($noteService->get_note_by_id($id));
});

/**
 * @OA\Post(
 *     path="/notes",
 *     tags={"Notes"},
 *     summary="Create new note",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"title", "user_id", "category_id"},
 *             @OA\Property(property="title", type="string"),
 *             @OA\Property(property="user_id", type="integer"),
 *             @OA\Property(property="category_id", type="integer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Note created successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('POST /notes', function () use ($noteService) {
    $auth = Flight::request()->getHeader('Authorization');
    if (!$auth) {
        Flight::halt(401, "Missing Authorization header");
    }
    $token = str_replace("Bearer ", "", $auth);
    Flight::auth_middleware()->verifyToken($token);

    $user = Flight::get('user');
    $data = Flight::request()->data->getData();
    
    // Ensure user can only create notes for themselves
    $data['user_id'] = $user->id;
    
    Flight::json($noteService->create_note($data));
});

/**
 * @OA\Put(
 *     path="/notes/{id}",
 *     tags={"Notes"},
 *     summary="Update note",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Note ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string"),
 *             @OA\Property(property="user_id", type="integer"),
 *             @OA\Property(property="category_id", type="integer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Note updated successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('PUT /notes/@id', function ($id) use ($noteService) {
    $auth = Flight::request()->getHeader('Authorization');
    if (!$auth) {
        Flight::halt(401, "Missing Authorization header");
    }
    $token = str_replace("Bearer ", "", $auth);
    Flight::auth_middleware()->verifyToken($token);

    $user = Flight::get('user');
    $existing = $noteService->get_note_by_id($id);
    if (!$existing) {
        Flight::halt(404, "Note not found");
    }
    if ($user->role !== Roles::ADMIN && $user->id != $existing['user_id']) {
        Flight::halt(403, "Forbidden");
    }

    $data = Flight::request()->data->getData();
    // Ensure required fields are set
    if (!isset($data['user_id'])) $data['user_id'] = $existing['user_id'];
    if (!isset($data['category_id'])) $data['category_id'] = $existing['category_id'];
    if (!isset($data['title'])) $data['title'] = $existing['title'];
    if (!isset($data['content'])) $data['content'] = $existing['content'];

    Flight::json($noteService->update_note($id, $data));
});

/**
 * @OA\Delete(
 *     path="/notes/{id}",
 *     tags={"Notes"},
 *     summary="Delete note",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Note ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Note deleted successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('DELETE /notes/@id', function ($id) use ($noteService) {
    $auth = Flight::request()->getHeader('Authorization');
    if (!$auth) {
        Flight::halt(401, "Missing Authorization header");
    }
    $token = str_replace("Bearer ", "", $auth);
    Flight::auth_middleware()->verifyToken($token);

    $user = Flight::get('user');
    $existing = $noteService->get_note_by_id($id);
    if (!$existing) {
        Flight::halt(404, "Note not found");
    }
    if ($user->role !== Roles::ADMIN && $user->id != $existing['user_id']) {
        Flight::halt(403, "Forbidden");
    }

    Flight::json($noteService->delete_note($id));
});