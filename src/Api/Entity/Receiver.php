<?php
/**
 * bundle.cleverreach-connect for Contao Open Source CMS
 *
 * Copyright (C) 2020 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
 */


namespace Webandwork\ContaoCleverreachConnectorBundle\Api\Entity;


class Receiver
{
    /** @var int */
    protected $id;

    /** @var string */
    protected $email;

    /** @var int */
    protected $activated;

    /** @var int */
    protected $registered;

    /** @var int */
    protected $deactivated;

    /** @var bool */
    protected $active;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getActivated(): int
    {
        return $this->activated;
    }

    /**
     * @param int $activated
     */
    public function setActivated(int $activated): void
    {
        $this->activated = $activated;
    }

    /**
     * @return int
     */
    public function getRegistered(): int
    {
        return $this->registered;
    }

    /**
     * @param int $registered
     */
    public function setRegistered(int $registered): void
    {
        $this->registered = $registered;
    }

    /**
     * @return int
     */
    public function getDeactivated(): int
    {
        return $this->deactivated;
    }

    /**
     * @param int $deactivated
     */
    public function setDeactivated(int $deactivated): void
    {
        $this->deactivated = $deactivated;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }
}
