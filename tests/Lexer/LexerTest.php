<?php
declare(strict_types=1);

namespace PumlParser\Tests\Lexer;

use PHPUnit\Framework\TestCase;
use PumlParser\Lexer\Lexer;
use PumlParser\Lexer\Token\Arrow\LeftArrowToken;
use PumlParser\Lexer\Token\Arrow\RightArrowToken;
use PumlParser\Lexer\Token\CurlyBracket\CloseCurlyBracketToken;
use PumlParser\Lexer\Token\CurlyBracket\OpenCurlyBracketToken;
use PumlParser\Lexer\Token\Element\ElementToken;
use PumlParser\Lexer\Token\ElementValue\ElementValueToken;
use PumlParser\Lexer\Token\EofToken;
use PumlParser\Lexer\Token\Token;

class LexerTest extends TestCase
{
    public function test2(): void
    {
        $lexer = Lexer::fromSourceFile(__DIR__ . '/test.puml');

        $this->assertToken($lexer->getNextToken(), ElementToken::class, 'class');
        $this->assertToken($lexer->getNextToken(), ElementValueToken::class, 'Class');

        $this->assertToken($lexer->getNextToken(), ElementToken::class, 'abstract class');
        $this->assertToken($lexer->getNextToken(), ElementValueToken::class, 'AbstractClass');

        $this->assertToken($lexer->getNextToken(), ElementToken::class, 'interface');
        $this->assertToken($lexer->getNextToken(), ElementValueToken::class, 'Interface');

        $this->assertToken($lexer->getNextToken(), ElementValueToken::class, 'AbstractClass');
        $this->assertToken($lexer->getNextToken(), LeftArrowToken::class, '<|--');
        $this->assertToken($lexer->getNextToken(), ElementValueToken::class, 'Class');

        $this->assertToken($lexer->getNextToken(), ElementValueToken::class, 'AbstractClass');
        $this->assertToken($lexer->getNextToken(), RightArrowToken::class, '..|>');
        $this->assertToken($lexer->getNextToken(), ElementValueToken::class, 'Interface');

        $this->assertToken($lexer->getNextToken(), ElementToken::class, 'package');
        $this->assertToken($lexer->getNextToken(), ElementValueToken::class, 'Package');
        $this->assertToken($lexer->getNextToken(), OpenCurlyBracketToken::class, '{');
        $this->assertToken($lexer->getNextToken(), ElementToken::class, 'class');
        $this->assertToken($lexer->getNextToken(), ElementValueToken::class, 'ClassInPackage');
        $this->assertToken($lexer->getNextToken(), CloseCurlyBracketToken::class, '}');

        self::assertInstanceOf(EofToken::class, $lexer->getNextToken());
    }

    private function assertToken(Token $token, string $class, string $value): void
    {
        self::assertInstanceOf($class, $token);
        self::assertSame($value, $token->getValue());
    }
}
