<?php

declare(strict_types=1);

namespace DevTools\tests\data\ProtectedPropertyCanBePrivateRule;

class NoEntity
{
    private int $id0;
    protected string $id1;

    public int $id2;

    protected ?string $id3;

    protected int $id4;
    protected int $id5;

    public function setId4(int $id4): void
    {
        $this->id4 = $id4;
    }

    public function getId5(): int
    {
        return $this->id5;
    }
}
