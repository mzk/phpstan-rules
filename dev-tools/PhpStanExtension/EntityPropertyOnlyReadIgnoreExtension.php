<?php

declare(strict_types=1);

namespace DevTools\PhpStanExtension;

use PhpParser\Node;
use PHPStan\Analyser\Error;
use PHPStan\Analyser\IgnoreErrorExtension;
use PHPStan\Analyser\Scope;
use PHPStan\Node\ClassPropertiesNode;

use function str_contains;

class EntityPropertyOnlyReadIgnoreExtension implements IgnoreErrorExtension
{
    public function shouldIgnore(Error $error, Node $node, Scope $scope): bool
    {
        if ($error->getIdentifier() !== 'property.onlyRead') {
            return false;
        }
        if (!$node instanceof ClassPropertiesNode) {
            return false;
        }
        $resolvedPhpDoc = $node->getClassReflection()->getResolvedPhpDoc();
        if ($resolvedPhpDoc === null) {
            return false;
        }
        if (str_contains($resolvedPhpDoc->getPhpDocString(), '@ORM\Entity') || str_contains($resolvedPhpDoc->getPhpDocString(), '@ORM\Table')) {
            return true;
        }
        return false;
    }
}
