<?php
declare(strict_types=1);

namespace PumlParser\Tests\Parser;

use PHPUnit\Framework\TestCase;
use PumlParser\Lexer\Lexer;
use PumlParser\Lexer\PumlTokenizer;
use PumlParser\Parser\Parser;

class ParserTest extends TestCase
{
    public function testParse(): void
    {
        $lexer  = new Lexer(new PumlTokenizer());
        $parser = new Parser($lexer);
        $ast    = $parser->parse(__DIR__ . '/test.puml');

        self::assertSame([
            [
                'interface' => [
                    'Name' => 'Tokenizeable',
                    'Package' => 'Lexer',
                    'Parents' => [],
                    'Interfaces' => []
                ]
            ],
            [
                'abstract class' => [
                    'Name' => 'ArrowTokenizer',
                    'Package' => 'Lexer/Arrow',
                    'Parents' => [],
                    'Interfaces' => [
                        [
                            'interface' => [
                                'Name' => 'Tokenizeable',
                                'Package' => 'Lexer',
                                'Parents' => [],
                                'Interfaces' => []
                            ]
                        ]
                    ]
                ]
            ],
            [
                'class' => [
                    'Name' => 'LeftArrowTokenizer',
                    'Package' => 'Lexer/Arrow',
                    'Parents' => [
                        [
                            'abstract class' => [
                                'Name' => 'ArrowTokenizer',
                                'Package' => 'Lexer/Arrow',
                                'Parents' => [],
                                'Interfaces' => [
                                    [
                                        'interface' => [
                                            'Name' => 'Tokenizeable',
                                            'Package' => 'Lexer',
                                            'Parents' => [],
                                            'Interfaces' => [],
                                        ]
                                    ],
                                ]
                            ]
                        ]
                    ],
                    'Interfaces' => []
                ]
            ],
            [
                'abstract class' => [
                    'Name' => 'CurlyBracketTokenizer',
                    'Package' => 'Lexer/CurlyBracket',
                    'Parents' => [],
                    'Interfaces' => [
                        [
                            'interface' => [
                                'Name' => 'Tokenizeable',
                                'Package' => 'Lexer',
                                'Parents' => [],
                                'Interfaces' => []
                            ]
                        ]
                    ]
                ]
            ],
            [
                'class' => [
                    'Name' => 'OpenCurlyBracketToken',
                    'Package' => 'Lexer/CurlyBracket',
                    'Parents' => [
                        [
                            'abstract class' => [
                                'Name' => 'CurlyBracketTokenizer',
                                'Package' => 'Lexer/CurlyBracket',
                                'Parents' => [],
                                'Interfaces' => [
                                    [
                                        'interface' => [
                                            'Name' => 'Tokenizeable',
                                            'Package' => 'Lexer',
                                            'Parents' => [],
                                            'Interfaces' => []
                                        ]
                                    ]
                                ]
                            ]
                        ],
                    ],
                    'Interfaces' => []
                ]
            ],
            [
                'class' => [
                    'Name' => 'NoneDefinitionClass',
                    'Package' => 'Lexer',
                    'Parents' => [],
                    'Interfaces' => [
                        [
                            'interface' => [
                                'Name' => 'Tokenizeable',
                                'Package' => 'Lexer',
                                'Parents' => [],
                                'Interfaces' => []
                            ]
                        ]
                    ]
                ]
            ]
        ], $ast->toArray());
    }
}
