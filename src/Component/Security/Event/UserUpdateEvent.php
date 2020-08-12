<?php

namespace TheHostingTool\Component\Security\Event;

/**
 * This event is dispatched when a user logs in/out, updates email/password,
 * there is a failed login attempt, or initiates a password reset.
 */
class UserUpdateEvent
{

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $ip_address;

    /**
     * UserUpdateEvent constructor.
     *
     * @param string $type
     * @param string $identifier
     * @param string|null $ip_address
     */
    public function __construct(string $type, string $identifier, string $ip_address = null)
    {
        $this->type = $type;
        $this->identifier = $identifier;
        $this->ip_address = $ip_address;
    }

    /**
     * Gets the event type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Gets the identifier of the user for which the event was recorded
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * Gets the ip address from which the event happened, null if initiated by backend.
     *
     * @return string|null
     */
    public function getIpAddress(): ?string
    {
        return $this->ip_address;
    }
}