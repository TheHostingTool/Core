<?php


namespace TheHostingTool\Component\Security\Authentication;

use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;

/**
 * The UserInterface for TheHostingTool, extends the Symfony UserInterface with an ID.
 */
interface UserInterface extends BaseUserInterface
{

    /**
     * Returns the ID of the user.
     *
     * @return int
     */
    public function getId(): int;

    /**
     * Returns the locale of the user.
     *
     * @return string Users locale
     */
    public function getLocale(): string;

    /**
     * Returns the full name of the user.
     *
     * @return string
     */
    public function getFullName(): string;

    /**
     * Returns true if user is locked, false otherwise
     *
     * @return bool
     */
    public function isLocked(): bool;

    /**
     * Gets the reason the user is locked
     *
     * @return string|null
     */
    public function getLockedReason(): ?string;

    /**
     * Returns true if user is activated, false otherwise
     *
     * @return bool
     */
    public function isActivated(): bool;

    /**
     * Returns true if user is enabled, false otherwise
     * @return bool
     */
    public function isEnabled(): bool;
}