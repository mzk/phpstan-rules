<?php

declare(strict_types=1);

namespace DevTools\Rules;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\ClassPropertiesNode;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<ClassPropertiesNode>
 */
class ProtectedPropertyCanBePrivateRule implements Rule
{
    public function getNodeType(): string
    {
        return ClassPropertiesNode::class;
    }

    /**
     * @param ClassPropertiesNode $node
     * @return list<RuleError>
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $classReflection = $scope->getClassReflection();
        if ($classReflection === null) {
            return [];
        }
        if ($classReflection->isAbstract()) { // allow protected properties for abstract class
            return [];
        }
        if (!$this->isEntity($classReflection)) {
            return [];
        }
        $errors = [];
        foreach ($node->getProperties() as $propertyNode) {
            if (!$propertyNode->isProtected()) {
                continue;
            }
            $propertyName = $propertyNode->getName();
            $className = $classReflection->getNativeReflection()->getShortName();
            $errors[] = RuleErrorBuilder::message("Protected property {$propertyName} on Entity class {$className} can be private.")
                ->addTip('Class properties should use the strictest access level possible.')
                ->identifier('packeta.entityCanBePrivate')
                ->line($propertyNode->getLine())
                ->build();
        }
        return $errors;
    }

    private function isEntity(ClassReflection $classReflection): bool
    {
        if ($classReflection->isInterface()) {
            return false;
        }
        $resolvePhpDoc = $classReflection->getResolvedPhpDoc();
        if ($resolvePhpDoc === null) {
            return false;
        }

        $phpDocString = $resolvePhpDoc->getPhpDocString();
        return str_contains($phpDocString, '@ORM\Entity') || str_contains($phpDocString, '@ORM\Table');
    }
}
