<?php
declare(strict_types=1);

namespace App\Api;

use App\Api\Shared\ResponseFactory;
use App\Entity\UserRepository;
use App\Entity\UserTokenRepository;
use App\Shared\ApplicationParams;
use DateTimeImmutable;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Yiisoft\DataResponse\DataResponse;
use Yiisoft\Http\Status;

final class LoginAction
{
    public function __construct(
        private UserRepository                    $userRepository,
        private UserTokenRepository               $userTokenRepository,
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly StreamFactoryInterface   $streamFactory,
    )
    {
    }

    public function __invoke(
        ResponseFactory        $responseFactory,
        ApplicationParams      $applicationParams,
        ContainerInterface     $container,
        ServerRequestInterface $request
    ): ResponseInterface
    {
        $data = json_decode((string) $request->getBody(), true);

        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        $user = $this->userRepository->findByUsername($username);

        if (!$user || !$user->validatePassword($password)) {
            return new DataResponse(['error' => 'Invalid credentials'],
                Status::UNAUTHORIZED,
                '',
                $this->responseFactory,
                $this->streamFactory
            );
        }

        $this->userTokenRepository->deleteByUserId($user->getId());
        $userToken = $this->userTokenRepository->create($user->getId());

        return $responseFactory->success([
            'token' => $userToken->getToken(),
            'expires_at' => $userToken->getExpiresAt()->format(DateTimeImmutable::ATOM),
        ]);
    }

}
