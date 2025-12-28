<?php

/**
 * @OA\Post(
 *     path="/auth/login",
 *     summary="Login user",
 *     tags={"Auth"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email","password"},
 *             @OA\Property(property="email", type="string", example="test@test.com"),
 *             @OA\Property(property="password", type="string", example="test123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Login successful"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Invalid credentials"
 *     )
 * )
 */
Flight::route('POST /auth/login', function () {
    $payload = Flight::request()->data->getData();

    $result = Flight::auth_service()->login($payload);

    Flight::json($result);
});


/**
 * @OA\Post(
 *     path="/auth/register",
 *     summary="Register user",
 *     tags={"Auth"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"username","email","password","role"},
 *             @OA\Property(property="username", type="string"),
 *             @OA\Property(property="email", type="string"),
 *             @OA\Property(property="password", type="string"),
 *             @OA\Property(property="role", type="string", example="user")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User registered"
 *     )
 * )
 */
Flight::route('POST /auth/register', function () {
    $payload = Flight::request()->data->getData();

    $result = Flight::auth_service()->register($payload);

    Flight::json($result);
});
