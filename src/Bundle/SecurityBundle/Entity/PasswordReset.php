<?php

namespace TheHostingTool\Bundle\SecurityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="password_resets")
 */
class PasswordReset
{
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="passwordResets")
     */
    private $user;

    /**
     * @var string
     */
    private $token;

    private $expiresAt;

    private $emailsSent;

    public function User()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;

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

    public function getExpiresAt(): \DateTime
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(\DateTime $expiresAt): self
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    public function getEmailsSent(): int
    {
        return $this->emailsSent;
    }

    public function setEmailsSent(int $emailsSent): self
    {
        $this->emailsSent = $emailsSent;

        return $this;
    }
}