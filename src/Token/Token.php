<?php
namespace Nyol\Token;

class Token
{
    protected $type;
    protected $lexeme;
    protected $literal;
    protected $offset;

    public function __construct(string $type, string $lexeme, $literal, int $offset)
    {
        $this->type = $type;
        $this->lexeme = $lexeme;
        $this->literal = $literal;
        $this->offset = $offset;
    }

    public function __toString() : string
    {
        return implode(' ', [$this->type, $this->lexeme, $this->literal]);
    }

    public function getType() : string
    {
        return $this->type;
    }

    public function getLexeme() : string
    {
        return $this->lexeme;
    }

    public function getLiteral()
    {
        return $this->literal;
    }

    public function getOffset() : int
    {
        return $this->offset;
    }
}
