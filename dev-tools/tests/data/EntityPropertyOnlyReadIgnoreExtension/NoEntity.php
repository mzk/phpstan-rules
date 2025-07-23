<?php

declare(strict_types=1);

namespace DevTools\tests\data\EntityPropertyOnlyReadIgnoreExtension;

class NoEntity
{
    private string $accountNumber; // Property NoEntity::$accountNumber is never written, only read.

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

abstract class NoEntity2
{
    private string $accountNumber; // Property NoEntity::$accountNumber is never written, only read.

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
