<?php

declare(strict_types=1);

// composer require --dev symplify/easy-coding-standard
// vendor/bin/ecs init

// symplify/easy-coding-standard
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\AssignmentInConditionSniff;
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    // https://tomasvotruba.com/blog/introducing-up-to-16-times-faster-easy-coding-standard/
    // if there are memory problems disable this line first
    $parameters->set(Option::PARALLEL, true); // requires 9.4.70+

    // Laravel app setup
    $parameters->set(Option::PATHS, [
        __DIR__ . '/app',
        //        __DIR__ . '/src',
        __DIR__ . '/bootstrap',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/public',
        __DIR__ . '/resources',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
        __DIR__ . '/ecs.php',  // check this file too!
    ]);

    $parameters->set(Option::SKIP, [

        // Ignore: Variable assignment found within a condition in index.php, it's not a conditional!
        AssignmentInConditionSniff::class => [
            __DIR__ . '/public/index.php',
        ],

        // I don't want to remove unused imports, at the beginning of the app, then the app is close to
        // production these unused imports can be removed and files cleaned up.
        PhpCsFixer\Fixer\Import\NoUnusedImportsFixer::class,
        // I can remove return types from doc blocks later, keep in for now.
        PhpCsFixer\Fixer\Phpdoc\PhpdocNoEmptyReturnFixer::class,

    ]);

    $services = $containerConfigurator->services();

    $services->set(ArraySyntaxFixer::class)
        ->call('configure', [
            [
                'syntax' => 'short',
            ],
        ]);

    // add declare(strict_types=1); to all php files:
    $services->set(DeclareStrictTypesFixer::class);

    // run and fix, one by one
    $containerConfigurator->import(SetList::SPACES);
    $containerConfigurator->import(SetList::ARRAY);
    $containerConfigurator->import(SetList::DOCBLOCK);
    $containerConfigurator->import(SetList::NAMESPACES);
    $containerConfigurator->import(SetList::CONTROL_STRUCTURES);
    $containerConfigurator->import(SetList::CLEAN_CODE);
    $containerConfigurator->import(SetList::STRICT);
    $containerConfigurator->import(SetList::PSR_12);
    $containerConfigurator->import(SetList::PHPUNIT);

    // This is my opinionated rule to automatically align key value pairs, I think they are easier to read.
    // $array [
    //    'name'    => 'Fred',
    //    'address' => '123 high street',
    // ];
    $services->set(BinaryOperatorSpacesFixer::class)
        ->call('configure', [
            [
                // My preference is to line up arrays (mostly), it's easier to read 😉
                // if other operators are affected, change 'default' => 'single'
                'default'   => 'align_single_space_minimal',
                'operators' => [
                    '|'  => 'no_space',
                    '=>' => 'align_single_space_minimal',
                ],
            ],
        ]);

    $parameters->set(Option::INDENTATION, 'spaces');

    $parameters->set(Option::LINE_ENDING, "\n");
};
