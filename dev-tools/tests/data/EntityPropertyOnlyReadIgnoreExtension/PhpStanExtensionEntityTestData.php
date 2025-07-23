<?php

declare(strict_types=1);

namespace DevTools\tests\data\EntityPropertyOnlyReadIgnoreExtension;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="table_name")
 */
class PhpStanExtensionEntityTestData
{
    /**
     * @ORM\Column(type="string")
     */
    private string $accountNumber; // Property PhpStanExtensionEntityTestData::$accountNumber is never written, only read.

    /**
     * @ORM\Column(type="string")
     */
    protected string $accountNumber2; // protected fields are not checked by this PHPStan rule

    public function getAccountNumber(): string
    {
        return $this->accountNumber;
    }

    public function getAccountNumber2(): string
    {
        return $this->accountNumber2;
    }
}
