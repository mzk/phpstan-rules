<?php

declare(strict_types=1);

namespace DevTools\tests\Rules;

use DevTools\Rules\ProtectedPropertyCanBePrivateRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ProtectedPropertyCanBePrivateRule>
 */
class ProtectedPropertyCanBePrivateRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new ProtectedPropertyCanBePrivateRule();
    }

    public function testRuleNoEntity(): void
    {
        $this->analyse(
            [
                __DIR__ . '/../data/ProtectedPropertyCanBePrivateRule/NoEntity.php',
            ],
            [],
        );
    }

    public function testRuleEntity(): void
    {
        $hint = 'Class properties should use the strictest access level possible.';
        $this->analyse(
            [
                __DIR__ . '/../data/ProtectedPropertyCanBePrivateRule/Entity.php',
            ],
            [
                [
                    'Protected property id1 on Entity class Entity can be private.',
                    16,
                    $hint,
                ],
                [
                    'Protected property id3 on Entity class Entity can be private.',
                    20,
                    $hint,
                ],
                [
                    'Protected property id4 on Entity class Entity can be private.',
                    22,
                    $hint,
                ],
                [
                    'Protected property id5 on Entity class Entity can be private.',
                    23,
                    $hint,
                ],
            ],
        );
    }
}
