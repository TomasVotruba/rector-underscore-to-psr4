<?php

declare(strict_types=1);

namespace Utils\Rector\Rector;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class UnwrapUnderscoreClassToNamespacedClassRector extends AbstractRector
{
    public function getRuleDefinition(): \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
    }

    public function getNodeTypes(): array
    {
        return [Class_::class];
    }

    /**
     * @param Class_ $node
     * @return Node|Node[]|void|null
     */
    public function refactor(Node $node)
    {
        $scope = $node->getAttribute(AttributeKey::SCOPE);
        if (! $scope instanceof Scope) {
            return null;
        }

        // already namespace? skip it
        if ($scope->getNamespace() !== null) {
            return null;
        }

        $className = $this->getName($node->name);
        if (! str_contains($className, '_')) {
            return null;
        }

        $classNameParts = explode('_', $className);

        $shortClasName = array_pop($classNameParts);
        $namespaceName = implode('\\', $classNameParts);

        $node->name = new Node\Name($shortClasName);
        $namespace = new Node\Stmt\Namespace_(new Node\Name($namespaceName), [$node]);

        return $namespace;
    }
}
