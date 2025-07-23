<?php

declare(strict_types=1);

namespace DevTools\tests\PhpStanExtension;

use DevTools\PhpStanExtension\EntityPropertyOnlyReadIgnoreExtension;
use PHPStan\Rules\DeadCode\UnusedPrivatePropertyRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<EntityPropertyOnlyReadIgnoreExtension>
 */
class EntityPropertyOnlyReadIgnoreExtensionTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(UnusedPrivatePropertyRule::class);
    }

    public function testRule(): void
    {
        $this->analyse(
            [__DIR__ . '/../data/EntityPropertyOnlyReadIgnoreExtension/NoEntity.php'],
            [
                [
                    'Property DevTools\tests\data\EntityPropertyOnlyReadIgnoreExtension\NoEntity::$accountNumber is never written, only read.',
                    9,
                    'See: https://phpstan.org/developing-extensions/always-read-written-properties'
                ],
                [
                    'Property DevTools\tests\data\EntityPropertyOnlyReadIgnoreExtension\NoEntity2::$accountNumber is never written, only read.',
                    26,
                    'See: https://phpstan.org/developing-extensions/always-read-written-properties'
                ],
            ],
        );
    }

    public function testEntity(): void
    {
        $this->analyse(
            [__DIR__ . '/../data/EntityPropertyOnlyReadIgnoreExtension/PhpStanExtensionEntityTestData.php'],
            [],
        );
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/../../phpstan.dist.neon'];
    }
}
