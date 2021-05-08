<?php

declare(strict_types=1);

use ObjectCalisthenics\Sniffs\Classes\ForbiddenPublicPropertySniff;
use ObjectCalisthenics\Sniffs\CodeAnalysis\OneObjectOperatorPerLineSniff;
use ObjectCalisthenics\Sniffs\ControlStructures\NoElseSniff;
use ObjectCalisthenics\Sniffs\Files\FunctionLengthSniff;
use ObjectCalisthenics\Sniffs\Metrics\MaxNestingLevelSniff;
use ObjectCalisthenics\Sniffs\Metrics\MethodPerClassLimitSniff;
use ObjectCalisthenics\Sniffs\Metrics\PropertyPerClassLimitSniff;
use ObjectCalisthenics\Sniffs\NamingConventions\ElementNameMinimalLengthSniff;
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->set(ArraySyntaxFixer::class)
        ->call('configure', [[
            'syntax' => 'short',
        ]]);

    // Object Calisthenics rules. See: https://github.com/object-calisthenics/phpcs-calisthenics-rules
    $services->set(MaxNestingLevelSniff::class);
    $services->set(NoElseSniff::class);
    $services->set(OneObjectOperatorPerLineSniff::class);
    $services->set(ElementNameMinimalLengthSniff::class);
    $services->set(FunctionLengthSniff::class);
    $services->set(MethodPerClassLimitSniff::class);
    $services->set(PropertyPerClassLimitSniff::class);
    $services->set(ForbiddenPublicPropertySniff::class);

    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    $parameters->set(Option::SETS, [
        SetList::ARRAY,
        SetList::DOCBLOCK,
        SetList::NAMESPACES,
        SetList::CLEAN_CODE,
        SetList::PSR_12,
    ]);

    $parameters->set(Option::SKIP, [
        __DIR__ . '/src/Game/Infrastructure/Repository',
        __DIR__ . '/src/Dictionary/Infrastructure/Repository',
        __DIR__ . '/src/Crossword/Infrastructure/Repository',
        __DIR__ . '/src/Game/Infrastructure/Dao',
        __DIR__ . '/src/Crossword/Infrastructure/Dao',
        __DIR__ . '/src/Dictionary/Infrastructure/Dao',
        __DIR__ . '/src/SharedKernel/Infrastructure/HttpClient',
    ]);
};
