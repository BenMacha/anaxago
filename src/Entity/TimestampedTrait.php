<?php

/**
 * PHP version 8.2 & Symfony 6.4.
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * https://www.php.net/license/3_01.txt.
 *
 * developed by Ben Macha.
 *
 * @category   Symfony Project ANAXAGOS
 *
 * @author     Ali BEN MECHA       <contact@benmacha.tn>
 *
 * @copyright  Ⓒ 2024 benmacha.tn
 *
 * @see       https://www.benmacha.tn
 *
 *
 */

namespace App\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
trait TimestampedTrait
{
    #[ORM\Column(name: 'created_at', type: Types::DATETIME_MUTABLE, nullable: false)]
    protected $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_MUTABLE, nullable: false)]
    protected $updatedAt;

    public function getClassName()
    {
        return __CLASS__;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        if (null == $this->createdAt) {
            $this->createdAt = new DateTime();
        }
        $this->updatedAt = new DateTime();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        if (null == $this->createdAt) {
            $this->createdAt = new DateTime();
        }
        $this->updatedAt = new DateTime();
    }

    /**
     * Get createdAt.
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt.
     *
     * @param DateTime $createdAt
     *
     * @return DateTime|TimestampedTrait
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set updatedAt.
     *
     * @param DateTime $updatedAt
     *
     * @return DateTime|TimestampedTrait
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
