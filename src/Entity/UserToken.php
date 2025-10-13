<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;

#[Table(name: 'user_token')]
final class UserToken
{
    #[Column(type: 'primary')]
    private ?int $id = null;

    #[Column(type: 'integer', notNull: true)]
    private int $id_user;

    #[Column(type: 'string', notNull: true, unique: true)]
    private string $token;

    #[Column(type: 'datetime', notNull: true)]
    private DateTimeImmutable $expires_at;

    /**
     * Reference to user who created this record.
     */
    #[Column(type: 'integer', nullable: true)]
    private ?int $created_by = null;

    /**
     * Reference to user who last updated this record.
     */
    #[Column(type: 'integer', nullable: true)]
    private ?int $updated_by = null;

    /**
     * Reference to user who deleted this record.
     */
    #[Column(type: 'integer', nullable: true)]
    private ?int $deleted_by = null;

    #[Column(type: 'datetime', notNull: true, defaultExpression: 'CURRENT_TIMESTAMP')]
    private DateTimeImmutable $created_at;

    #[Column(type: 'datetime', notNull: false)]
    private ?DateTimeImmutable $updated_at = null;

    #[Column(type: 'datetime', notNull: false)]
    private ?DateTimeImmutable $deleted_at = null;

    public static function create(int $userId, string $token, DateTimeImmutable $expiresAt = null): UserToken
    {
        $userToken = new UserToken();
        $userToken->id_user = $userId;
        $userToken->token = $token;
        $userToken->expires_at = $expiresAt;
        return $userToken;
    }

    public function toArray(): array
    {
        return [
            'id_user' => $this->id_user ?? null,
            'token' => $this->token,
            'expires_at' => $this->expires_at->format('Y-m-d H:i:s'),
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getIdUser(): int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): self
    {
        $this->idUser = $idUser;
        return $this;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }

    public function getExpiresAt(): DateTimeImmutable
    {
        return $this->expires_at;
    }

    public function setExpiresAt(DateTimeImmutable $expiresAt): self
    {
        $this->expires_at = $expiresAt;
        return $this;
    }

    public function getCreatedBy(): ?int
    {
        return $this->created_by;
    }

    public function setCreatedBy(?int $created_by): self
    {
        $this->created_by = $created_by;
        return $this;
    }

    public function getUpdatedBy(): ?int
    {
        return $this->updated_by;
    }

    public function setUpdatedBy(?int $updated_by): self
    {
        $this->updated_by = $updated_by;
        return $this;
    }

    public function getDeletedBy(): ?int
    {
        return $this->deleted_by;
    }

    public function setDeletedBy(?int $deleted_by): self
    {
        $this->deleted_by = $deleted_by;
        return $this;
    }
    
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getDeletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?DateTimeImmutable $deletedAt): self
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }

    public function isExpired(): bool
    {
        return $this->expires_at < new DateTimeImmutable();
    }
}
