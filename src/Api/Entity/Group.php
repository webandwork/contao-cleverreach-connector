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

class Group
{
    /** @var int */
    protected $id;

    /** @var string */
    protected $name;

    /** @var int */
    protected $tstamp;

    /** @var int */
    protected $last_mailing;

    /** @var int */
    protected $last_changed;

    /** @var bool */
    protected $isLocked;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getTstamp(): int
    {
        return $this->tstamp;
    }

    public function setTstamp(int $tstamp): void
    {
        $this->tstamp = $tstamp;
    }

    public function getLastMailing(): int
    {
        return $this->last_mailing;
    }

    public function setLastMailing(int $last_mailing): void
    {
        $this->last_mailing = $last_mailing;
    }

    public function getLastChanged(): int
    {
        return $this->last_changed;
    }

    public function setLastChanged(int $last_changed): void
    {
        $this->last_changed = $last_changed;
    }

    public function isLocked(): bool
    {
        return $this->isLocked;
    }

    public function setIsLocked(bool $isLocked): void
    {
        $this->isLocked = $isLocked;
    }
}
