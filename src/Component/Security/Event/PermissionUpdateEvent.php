<?php

namespace TheHostingTool\Component\Security\Event;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * This event is dispatched when the permissions of an object have been updated.
 */
class PermissionUpdateEvent extends Event
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
    private $securityIdentifier;

    /**
     * PermissionUpdateEvent constructor.
     *
     * @param string $type
     * @param string $identifier
     * @param string $securityIdentifier
     */
    public function __construct(string $type, string $identifier, string $securityIdentifier)
    {
        $this->type = $type;
        $this->identifier = $identifier;
        $this->securityIdentifier = $securityIdentifier;
    }

    /**
     * Returns the type of object for which the permissions have been updated.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Returns the identifier of the object for which the permissions have been updated.
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * Returns the security identifier for which the permissions have been updated.
     * @return string
     */
    public function getSecurityIdentifier(): string
    {
        return $this->securityIdentifier;
    }
}