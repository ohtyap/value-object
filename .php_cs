<?php

$header = <<<'EOF'
This file is part of the ohtyap/value-object library

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.

@copyright Copyright (c) Thomas Payer <me@tpa.codes>
@license http://opensource.org/licenses/MIT MIT
EOF;

$dirs = [
    'src',
    'tests',
];

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        '@PHP73Migration' => true,
        '@PHP71Migration:risky' => true,
        '@PHPUnit75Migration:risky' => true,
        'header_comment' => [
            'header' => $header,
            'commentType' => 'comment',
            'location' => 'after_open',
            'separate' => 'bottom',
        ],
        'yoda_style' => false,
        'phpdoc_align' => [
            'align' => 'left'
        ],
        'blank_line_after_opening_tag' => false,
        'concat_space' => ['spacing' => 'one'],
        'native_function_invocation' => [
            'scope' => 'all',
        ],
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()->in($dirs)
    );
