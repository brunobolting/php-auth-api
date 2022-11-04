<?php

declare(strict_types=1);

namespace Presentation\Api\Controllers;

use BrunoBolting\AuthApi\Domain\Entities\SecretKeyInterface;
use Domain\UseCases\User\UserManagerInterface;
use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthController extends Controller implements SecretKeyInterface
{
    private UserManagerInterface $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function register(Request $request, Response $response): Response
    {
        $json = (string) $request->getBody();
        $payload = json_decode($json);
        if ($payload === null) {
            return $this->response($response, 400, [
                'message' => 'invalid arguments'
            ]);
        }

        $user = $this->userManager->createUser($payload->email, $payload->nickname, $payload->password);
        if ($user->hasErrors()) {
            return $this->response($response, 500, [
                'message' => $user->getErrors()
            ]);
        }

        return $this->response($response, 200, [
            'message' => 'user created successfully'
        ]);
    }

    public function login(Request $request, Response $response): Response
    {
        $json = (string) $request->getBody();
        $payload = json_decode($json);
        if ($payload === null) {
            return $this->response($response, 400, [
                'message' => 'invalid arguments'
            ]);
        }

        if (!isset($payload->email) || !isset($payload->password)) {
            return $this->response($response, 400, [
                'message' => 'invalid arguments'
            ]);
        }

        if (!$this->userManager->authorize($payload->email, $payload->password)) {
            return $this->response($response, 401, [
                'message' => 'email or password is invalid'
            ]);
        }

        return $this->response($response, 200, [
            'token' => $this->generateToken($payload->email)
        ]);
    }

    private function generateToken(string $reference): string
    {
        $issuedAt = new \DateTimeImmutable();
        $key = self::JWT_SECRET_KEY;
        $payload = [
            'jti' => $reference,
            'iat' => $issuedAt->format('U'),
            'exp' => $issuedAt->modify("+1 hour")->format('U')
        ];

        return JWT::encode($payload, $key, 'HS256');
    }

}
