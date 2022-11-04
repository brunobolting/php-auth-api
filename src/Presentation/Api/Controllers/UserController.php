<?php

declare(strict_types=1);

namespace Presentation\Api\Controllers;

use Domain\UseCases\User\UserManagerInterface;
use Psr\Http\Message\{
    ServerRequestInterface as Request,
    ResponseInterface as Response
};

class UserController extends Controller
{
    private UserManagerInterface $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function ping(Request $request, Response $response): Response
    {
        return $response->withStatus(200);
    }

    public function create(Request $request, Response $response): Response
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

    public function get(Response $response, int|string $id): Response
    {
        $user = $this->userManager->getUser($id);

        if ($user === null) {
            return $this->response($response, 404, [
                'message' => 'user not found'
            ]);
        }

        $payload = [
            'ID' => $user->getID(),
            'email' => $user->getEmail(),
            'nickname' => $user->getNickname(),
            'createdAt' => ($user->getCreatedAt())->format('Y-m-d H:i:s'),
            'updatedAt' => ($user->getUpdatedAt())->format('Y-m-d H:i:s'),
        ];

        return $this->response($response, 200, $payload);
    }

    public function list(Response $response): Response
    {
        $users = $this->userManager->findUser([]);

        $payload = [];

        foreach ($users as $user) {
            $payload[] = [
                'ID' => $user->getID(),
                'email' => $user->getEmail(),
                'nickname' => $user->getNickname(),
                'createdAt' => ($user->getCreatedAt())->format('Y-m-d H:i:s'),
                'updatedAt' => ($user->getUpdatedAt())->format('Y-m-d H:i:s'),
            ];
        }

        return $this->response($response, 200, $payload);
    }

    public function update(Request $request, Response $response, int|string $id): Response
    {
        $user = $this->userManager->getUser($id);

        if ($user === null) {
            return $this->response($response, 404, [
                'message' => 'user not found'
            ]);
        }

        $json = (string) $request->getBody();

        $payload = json_decode($json);
        if ($payload === null) {
            return $this->response($response, 400, [
                'message' => 'invalid arguments'
            ]);
        }

        if (isset($payload->nickname)) {
            $user->setNickname($payload->nickname);
        }

        if (isset($payload->email)) {
            $user->setEmail($payload->email);
        }

        $user = $this->userManager->updateUser($user);
        if ($user->hasErrors()) {
            return $this->response($response, 400, [
                'errors' => $user->getErrors()
            ]);
        }

        return $this->response($response, 200, ['message' => 'user updated successfully']);
    }

    public function delete(Response $response, int|string $id): Response
    {
        $user = $this->userManager->getUser($id);

        if ($user === null) {
            return $this->response($response, 404, [
                'message' => 'user not found'
            ]);
        }

        $deleted = $this->userManager->deleteUser($id);

        if (!$deleted) {
            return $this->response($response, 500, ['message' => 'user not deleted']);
        }

        return $this->response($response, 200, ['message' => 'user deleted successfully']);
    }
}
