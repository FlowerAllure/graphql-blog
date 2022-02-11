<?php
$header = <<<EOF
This source file is subject to the MIT license that is bundled
with this source code in the file LICENSE.
EOF;

$finder = PhpCsFixer\Finder::create()
    ->files()
    ->name('*.php')
    ->exclude('vendor') //排除
    ->exclude('test') // 排除
    ->in(__DIR__)
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

$rules = array(
    '@Symfony'                                      => true,
    'header_comment'                                => array('header' => $header),
    'array_syntax'                                  => array('syntax' => 'short'),
    'ordered_imports'                               => true,
    'no_useless_else'                               => true,
    'no_useless_return'                             => true,
    'php_unit_construct'                            => true,
    'php_unit_strict'                               => true,
);

$config = new PhpCsFixer\Config();

return $config->setRiskyAllowed(true)
    ->setRules($rules)
    ->setFinder($finder);
