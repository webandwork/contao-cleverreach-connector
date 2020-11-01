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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getTstamp(): int
    {
        return $this->tstamp;
    }

    /**
     * @param int $tstamp
     */
    public function setTstamp(int $tstamp): void
    {
        $this->tstamp = $tstamp;
    }

    /**
     * @return int
     */
    public function getLastMailing(): int
    {
        return $this->last_mailing;
    }

    /**
     * @param int $last_mailing
     */
    public function setLastMailing(int $last_mailing): void
    {
        $this->last_mailing = $last_mailing;
    }

    /**
     * @return int
     */
    public function getLastChanged(): int
    {
        return $this->last_changed;
    }

    /**
     * @param int $last_changed
     */
    public function setLastChanged(int $last_changed): void
    {
        $this->last_changed = $last_changed;
    }

    /**
     * @return bool
     */
    public function isLocked(): bool
    {
        return $this->isLocked;
    }

    /**
     * @param bool $isLocked
     */
    public function setIsLocked(bool $isLocked): void
    {
        $this->isLocked = $isLocked;
    }
}
