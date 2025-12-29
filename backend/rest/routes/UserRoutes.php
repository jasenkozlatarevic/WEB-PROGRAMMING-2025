<?php

require_once __DIR__ . '/../services/UserService.php';
require_once __DIR__ . '/../../data/roles.php';

$userService = new UserService();
Flight::register('userService', 'UserService');

/**
 * @OA\Get(
 *     path="/users",
 *     tags={"Users"},
 *     summary="Get all users",
 *     @OA\Response(
 *         response=200,
 *         description="List of all users"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /users', function () use ($userService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json($userService->get_all_users());
});

/**
 * @OA\Get(
 *     path="/users/{id}",
 *     tags={"Users"},
 *     summary="Get user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User found"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /users/@id', function ($id) use ($userService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json($userService->get_user_by_id($id));
});

/**
 * @OA\Post(
 *     path="/users",
 *     tags={"Users"},
 *     summary="Create new user",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"username", "email", "password"},
 *             @OA\Property(property="username", type="string"),
 *             @OA\Property(property="email", type="string"),
 *             @OA\Property(property="password", type="string"),
 *             @OA\Property(property="role", type="string", enum={"user", "admin"})
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User created successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('POST /users', function () use ($userService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json($userService->create_user($data));
});

/**
 * @OA\Put(
 *     path="/users/{id}",
 *     tags={"Users"},
 *     summary="Update user",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="username", type="string"),
 *             @OA\Property(property="email", type="string"),
 *             @OA\Property(property="password", type="string"),
 *             @OA\Property(property="role", type="string", enum={"user", "admin"})
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('PUT /users/@id', function ($id) use ($userService) {
    Flight::auth_middleware()->authorizeUserOrRole($id, [Roles::ADMIN]);
    $data = Flight::request()->data->getData();
    Flight::json($userService->update_user($id, $data));
});

/**
 * @OA\Delete(
 *     path="/users/{id}",
 *     tags={"Users"},
 *     summary="Delete user",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User deleted successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('DELETE /users/@id', function ($id) use ($userService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json($userService->delete_user($id));
});

/**
 * @OA\Get(
 *     path="/users/email/{email}",
 *     tags={"Users"},
 *     summary="Get user by email",
 *     @OA\Parameter(
 *         name="email",
 *         in="path",
 *         required=true,
 *         description="User email",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User found"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /users/email/@email', function ($email) use ($userService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json($userService->get_user_by_email($email));
});