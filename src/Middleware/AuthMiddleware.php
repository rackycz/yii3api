<?php

namespace App\Middleware;

use App\Entity\UserTokenRepository;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Yiisoft\DataResponse\DataResponse;
use Yiisoft\Http\Status;

final class AuthMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly UserTokenRepository      $tokenRepository,
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly StreamFactoryInterface   $streamFactory,
    )
    {
    }

    public function process(
        ServerRequestInterface  $request,
        RequestHandlerInterface $handler
    ): ResponseInterface
    {
        $token = $this->extractToken($request);

        if ($token === null) {
            return new DataResponse(
                ['error' => 'No token provided'],
                Status::UNAUTHORIZED,
                '',
                $this->responseFactory,
                $this->streamFactory
            );
        }

        $userToken = $this->tokenRepository->findByToken($token);

        if ($userToken === null) {
            return new DataResponse(
                ['error' => 'Invalid or expired token'],
                Status::UNAUTHORIZED,
                '',
                $this->responseFactory,
                $this->streamFactory
            );
        }

        // Add user token to request attributes for later use
        $request = $request->withAttribute('token', $userToken);

        return $handler->handle($request);
    }

    private function extractToken(ServerRequestInterface $request): ?string
    {
        $header = $request->getHeaderLine('Authorization');
        if (preg_match('/Bearer\s+(.*)$/i', $header, $matches)) {
            return $matches[1];
        }
        return null;
    }
}
