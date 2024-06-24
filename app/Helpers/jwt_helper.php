<?php

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

function generateJWT($data)
{
    $key = getenv('JWT_SECRET');

    if (!$key) {
        throw new InvalidArgumentException('JWT secret key is not set.');
    }

    $payload = [
        'iat' => time(),
        'exp' => time() + 3600, // 1 hora de validade
        'data' => $data,
    ];

    return JWT::encode($payload, $key, 'HS256');
}

function validateJWT($token)
{
    $key = getenv('JWT_SECRET');

    if (!$key) {
        throw new InvalidArgumentException('JWT secret key is not set.');
    }

    try {
        $decoded = JWT::decode($token, new Key($key, 'HS256'));
        return (array) $decoded->data;
    } catch (Exception $e) {
        return null;
    }
}
