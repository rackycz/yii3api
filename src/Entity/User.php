<?php

declare(strict_types=1);

namespace App\Entity;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\BelongsTo;
use DateTimeImmutable;
use Yiisoft\Security\PasswordHasher;

#[Entity(repository: UserRepository::class)]
class User
{
    /**
     * Primary key.
     * Null for new unsaved entities, positive integer after saving to database.
     */
    #[Column(type: 'primary')]
    private ?int $id = null;

    /**
     * User's first name.
     */
    #[Column(type: 'string(255)')]
    private string $name = '';

    /**
     * User's last name.
     */
    #[Column(type: 'string(255)')]
    private string $surname = '';

    /**
     * Optional username for login.
     */
    #[Column(type: 'string(255)', nullable: true)]
    private ?string $username = null;

    /**
     * Optional phone number.
     */
    #[Column(type: 'string(255)', nullable: true)]
    private ?string $phone = null;

    /**
     * User's email address (unique).
     */
    #[Column(type: 'string(255)')]
    private string $email = '';

    /**
     * Timestamp when email was verified.
     */
    #[Column(type: 'datetime', nullable: true)]
    private ?DateTimeImmutable $email_verified_at = null;

    /**
     * Default password (plain text or encrypted).
     */
    #[Column(type: 'string(255)', nullable: true)]
    private ?string $pwd_default = null;

    /**
     * Hashed password.
     */
    #[Column(type: 'string(255)', nullable: true)]
    private ?string $pwd_hash = null;

    /**
     * User status (default: 100).
     */
    #[Column(type: 'integer')]
    private int $status = 100;

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

    /**
     * Record creation timestamp.
     */
    #[Column(type: 'datetime')]
    private DateTimeImmutable $created_at;

    /**
     * Last update timestamp.
     */
    #[Column(type: 'datetime', nullable: true)]
    private ?DateTimeImmutable $updated_at = null;

    /**
     * Deletion timestamp.
     */
    #[Column(type: 'datetime', nullable: true)]
    private ?DateTimeImmutable $deleted_at = null;

    public function validatePassword(string $password): bool
    {
        return (new PasswordHasher())->validate($password, $this->password_vuejs_hash);
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getEmailVerifiedAt(): ?DateTimeImmutable
    {
        return $this->email_verified_at;
    }

    public function setEmailVerifiedAt(?DateTimeImmutable $email_verified_at): self
    {
        $this->email_verified_at = $email_verified_at;
        return $this;
    }

    public function getPwdDefault(): ?string
    {
        return $this->pwd_default;
    }

    public function setPwdDefault(?string $pwd_default): self
    {
        $this->pwd_default = $pwd_default;
        return $this;
    }

    public function getPwdHash(): ?string
    {
        return $this->pwd_hash;
    }

    public function setPwdHash(?string $pwd_hash): self
    {
        $this->pwd_hash = $pwd_hash;
        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;
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
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    public function getDeletedAt(): ?DateTimeImmutable
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?DateTimeImmutable $deleted_at): self
    {
        $this->deleted_at = $deleted_at;
        return $this;
    }


}
