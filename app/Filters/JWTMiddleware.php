<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\Response;
use CodeIgniter\Config\Services;
use Exception;

class JWTMiddleware implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $header = $request->getServer('HTTP_AUTHORIZATION');

        if (!$header) {
            return Services::response()
                ->setStatusCode(Response::HTTP_UNAUTHORIZED, 'Token não fornecido.');
        }

        $token = null;
        if (strpos($header, 'Bearer ') !== false) {
            $token = str_replace('Bearer ', '', $header);
        }

        try {
            $decoded = validateJWT($token);
            if (!$decoded) {
                return Services::response()
                    ->setStatusCode(Response::HTTP_UNAUTHORIZED, 'Token inválido.');
            }
        } catch (Exception $e) {
            return Services::response()
                ->setStatusCode(Response::HTTP_UNAUTHORIZED, 'Token inválido.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // 
    }
}
