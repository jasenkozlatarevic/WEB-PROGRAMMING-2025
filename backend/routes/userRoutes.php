<?php
require_once __DIR__ . '/../services/UserService.php';

$userService = new UserService();

Flight::route('GET /users', function () use ($userService) {
    Flight::json($userService->getAllUsers());
});

Flight::route('GET /users/@id', function ($id) use ($userService) {
    try {
        $user = $userService->getUserById($id);
        Flight::json($user);
    } catch (Exception $e) {
        Flight::halt(400, json_encode(['error' => $e->getMessage()]));
    }
});

Flight::route('POST /users', function () use ($userService) {
    $data = get_request_data();
    try {
        $id = $userService->createUser($data);
        Flight::json(['message' => 'User created', 'id' => $id]);
    } catch (Exception $e) {
        Flight::halt(400, json_encode(['error' => $e->getMessage()]));
    }
});

Flight::route('PUT /users/@id', function ($id) use ($userService) {
    $data = get_request_data();
    try {
        $userService->updateUser($id, $data);
        Flight::json(['message' => 'User updated']);
    } catch (Exception $e) {
        Flight::halt(400, json_encode(['error' => $e->getMessage()]));
    }
});

Flight::route('DELETE /users/@id', function ($id) use ($userService) {
    try {
        $userService->deleteUser($id);
        Flight::json(['message' => 'User deleted']);
    } catch (Exception $e) {
        Flight::halt(400, json_encode(['error' => $e->getMessage()]));
    }
});
Flight::route('GET /users-page', function () use ($userService) {
    $users = $userService->getAllUsers();
    include __DIR__ . '/../views/users.php';
});
