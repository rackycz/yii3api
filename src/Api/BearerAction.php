<?php
declare(strict_types=1);

namespace App\Api;

use App\Api\Shared\ResponseFactory;
use App\Entity\UserRepository;
use App\Entity\UserTokenRepository;
use App\Shared\ApplicationParams;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class BearerAction
{
    public function __construct(
        private UserRepository      $userRepository,
        private UserTokenRepository $userTokenRepository,
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
        return $responseFactory->success([1, 2, 3]);
    }

}
