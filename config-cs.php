<?php

$header = <<<'EOF'

EOF;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules(array(
        '@Symfony' => true,
        '@PHP74Migration' => true,
        '@PHP74Migration:risky' => true,
        //'@Symfony' => true,
        '@PSR12' => true,
        //'@PhpCsFixer' => true,
        // '@Symfony:risky' => true,
        'array_syntax' => array('syntax' => 'short'),
        'blank_line_before_statement' => true,
        'combine_consecutive_unsets' => true,
        'declare_strict_types' => false,
        // one should use PHPUnit methods to set up expected exception instead of annotations
        'general_phpdoc_annotation_remove' => ['annotations' => ['access', 'category', 'copyright', 'throws']],
        'header_comment' => array('header' => $header, 'comment_type' => 'PHPDoc'),
        'heredoc_to_nowdoc' => true,
        'concat_space' => ['spacing'=>'one'],
        //'no_extra_blank_lines' => array('break', 'continue', 'extra', 'return', 'throw', 'use', 'parenthesis_brace_block', 'square_brace_block', 'curly_brace_block'),
        'no_extra_blank_lines' => [
            'tokens' => [
                'break',
                'case',
                'continue',
                'curly_brace_block',
                'default',
                'extra',
                'parenthesis_brace_block',
                'return',
                'square_brace_block',
                'switch',
                'throw',
                'use',
                'use_trait',
            ],
        ],
        'echo_tag_syntax' => true,
        'no_unreachable_default_argument_value' => false,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'ordered_class_elements' => ['order'=>['use_trait','constant_public','constant_protected','constant_private','property_public','property_protected','property_private','construct','destruct','magic','phpunit','method_public','method_protected','method_private']],
        'ordered_imports' => true,
        'php_unit_strict' => false,
        'global_namespace_import' => false,
        'phpdoc_add_missing_param_annotation' => true,
        'phpdoc_order' => true,
        'semicolon_after_instruction' => true,
        'whitespace_after_comma_in_array' => true,
        'logical_operators' => true,
        'ternary_to_null_coalescing' => true,
        'standardize_not_equals' => true,
        'strict_comparison' => false,
        'standardize_increment' => true,
        'void_return' => true,
        'no_empty_phpdoc' => true,
        //'strict_param' => true,
        'phpdoc_separation' => true,
        'phpdoc_trim' => true,
    ))
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('tests/Fixtures')
            ->in(__DIR__)
    );