<?php

/*
 * WebAndWork GmbH Contao Cleverreach Connector
 *
 * @copyright  Copyright (c) 2019-2020, WebAndWork GmbH
 * @author     Holger Neuner <holger.neuner@webandwork.de>
 *
 * @license LGPL-3.0-or-later
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

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getActivated(): int
    {
        return $this->activated;
    }

    public function setActivated(int $activated): void
    {
        $this->activated = $activated;
    }

    public function getRegistered(): int
    {
        return $this->registered;
    }

    public function setRegistered(int $registered): void
    {
        $this->registered = $registered;
    }

    public function getDeactivated(): int
    {
        return $this->deactivated;
    }

    public function setDeactivated(int $deactivated): void
    {
        $this->deactivated = $deactivated;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }
}
