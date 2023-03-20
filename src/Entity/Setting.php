<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
#[ORM\Table('`setting`')]
#[ORM\Index(name: 'key_idx', columns: ['key_name'])]
class Setting
{

    #[ORM\Id]
    #[ORM\Column()]
    private ?string $keyName = '';

    #[ORM\Column(type: Types::TEXT)]
    private ?string $value = '';

    public function getId(): string
    {
        return $this->getKeyName();
    }

    /**
     * Get the value of key
     */
    public function getKeyName(): string
    {
        return $this->keyName;
    }

    /**
     * Set the value of key
     */
    public function setKeyName(string $keyName): self
    {
        $this->keyName = $keyName;

        return $this;
    }

    /**
     * Get the value of value
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Set the value of value
     */
    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }
}