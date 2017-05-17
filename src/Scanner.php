<?php
namespace Nyol;

use Nyol\Error\ErrorReporter;
use Nyol\Token\TokenType as TT;
use Nyol\Token\Token;

class Scanner
{
    protected $errorReporter;
    protected $source;
    protected $tokens = [];

    protected $start = 0;
    protected $current = 0;
    protected $line = 1;

    public function __construct(ErrorReporter $errorReporter, string $source)
    {
        $this->errorReporter = $errorReporter;
        $this->source = $source;
    }

    public function scanTokens() : iterable
    {
        while (!$this->isAtEnd()) {
            $this->start = $this->current;
            $this->scanToken();
        }

        $this->tokens[] = new Token(TT::T_EOF, '', null, $this->current);
        return $this->tokens;
    }

    protected function scanToken() : void
    {
        $char = $this->advance();

        switch ($char) {
            // Single character lexemes
            case '(': $this->addToken(TT::T_LEFT_PAREN); break;
            case ')': $this->addToken(TT::T_RIGHT_PAREN); break;
            case '{': $this->addToken(TT::T_LEFT_BRACE); break;
            case '}': $this->addToken(TT::T_RIGHT_BRACE); break;
            case ',': $this->addToken(TT::T_COMMA); break;
            case '.': $this->addToken(TT::T_DOT); break;
            case '-': $this->addToken(TT::T_MINUS); break;
            case '+': $this->addToken(TT::T_PLUS); break;
            case ';': $this->addToken(TT::T_SEMICOLON); break;
            case '*': $this->addToken(TT::T_STAR); break;

            // One or two character lexemes
            case '!': $this->addToken($this->match('=') ? TT::T_BANG_EQUAL : TT::T_BANG); break;
            case '=': $this->addToken($this->match('=') ? TT::T_EQUAL_EQUAL : TT::T_EQUAL); break;
            case '<': $this->addToken($this->match('=') ? TT::T_LESS_EQUAL : TT::T_LESS); break;
            case '>': $this->addToken($this->match('=') ? TT::T_GREATER_EQUAL : TT::T_GREATER); break;
            case '/':
                if ($this->match('/')) {
                    // It's a comment, consume the rest of the line
                    while ($this->peek() != "\n" && !$this->isAtEnd()) $this->advance();
                } else {
                    $this->addToken(TT::T_SLASH);
                }
                break;

            // Whitespace
            case ' ':
            case "\r":
            case "\t";
                break;
            case "\n";
                $this->line++;
                break;

            case '"': $this->string(); break;
            default:
                if ($this->isDigit($char)) {
                    $this->number();
                } else {
                    $this->errorReporter->trackError($this->line, $char, 'Unexpected character.');
                }
                break;
        }
    }

    protected function isAtEnd() : bool
    {
        return $this->current >= strlen($this->source);
    }

    protected function advance() : string
    {
        $this->current++;

        return $this->source[$this->current - 1];
    }

    protected function addToken(string $tokenType, $literal = null) : void
    {
        $text = substr($this->source, $this->start, $this->current - $this->start);
        $token = new Token($tokenType, $text, $literal, $this->start);

        $this->tokens[] = $token;
    }

    protected function match(string $expected) : bool
    {
        if ($this->isAtEnd()) return false;
        if ($this->source[$this->current] !== $expected) return false;

        $this->current++;
        return true;
    }

    protected function peek() : string
    {
        if ($this->isAtEnd()) return "\0";
        return $this->source[$this->current];
    }

    protected function peekNext() : string
    {
        if ($this->current + 1 >= strlen($this->source)) return "\0";
        return $this->source[$this->current + 1];
    }

    protected function string() : void
    {
        // Advance the current text pointer until we find the closing quote or EOF
        while ($this->peek() !== '"' && !$this->isAtEnd()) {
            if ($this->peek() == "\n") $this->line++;
            $this->advance();
        }

        // If we are at EOF before we can consume the closing quote, this is an unterminated string
        if ($this->isAtEnd()) {
            $this->errorReporter->trackError($this->line, '', 'Unterminated string.');
            return;
        }

        // Consume the closing quote
        $this->advance();

        // Extract the token and produce the literal value
        $value = substr($this->source, $this->start + 1, $this->current - $this->start - 2);
        $this->addToken(TT::T_STRING, $value);
    }

    protected function isDigit(string $char) : bool
    {
        return $char >= '0' && $char <= '9';
    }

    protected function number() : void
    {
        // Advance as long as the current character is a digit
        while ($this->isDigit($this->peek())) $this->advance();

        // Look if we found a fraction (point followed by more digits)
        if ($this->peek() === '.' && $this->isDigit($this->peekNext())) {
            // Consume the point
            $this->advance();

            while ($this->isDigit($this->peek())) $this->advance();
        }

        $value = substr($this->source, $this->start, $this->current - $this->start);
        $this->addToken(TT::T_NUMBER, (float)$value);
    }
}
