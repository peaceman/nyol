<?php
namespace Nyol\Token;

class TokenType
{
    // Single-character tokens
    const T_LEFT_PAREN = 'left-paren';
    const T_RIGHT_PAREN = 'right-paren';
    const T_LEFT_BRACE = 'left-brace';
    const T_RIGHT_BRACE = 'right-brace';
    const T_COMMA = 'comma';
    const T_DOT = 'dot';
    const T_MINUS = 'minus';
    const T_PLUS = 'plus';
    const T_SEMICOLON = 'semicolon';
    const T_SLASH = 'slash';
    const T_STAR = 'star';

    // One or two character tokens
    const T_BANG = 'bang';
    const T_BANG_EQUAL = 'bang-equal';
    const T_EQUAL = 'equal';
    const T_EQUAL_EQUAL = 'equal-equal';
    const T_GREATER = 'greater';
    const T_GREATER_EQUAL = 'greater-equal';
    const T_LESS = 'less';
    const T_LESS_EQUAL = 'less-equal';

    // Literals
    const T_IDENTIFIER = 'identifier';
    const T_STRING = 'string';
    const T_NUMBER = 'number';

    // Keywords
    const T_AND = 'and';
    const T_CLASS = 'class';
    const T_ELSE = 'else';
    const T_FALSE = 'false';
    const T_FUN = 'fun';
    const T_FOR = 'for';
    const T_IF = 'if';
    const T_NIL = 'nil';
    const T_OR = 'or';
    const T_PRINT = 'print';
    const T_RETURN = 'return';
    const T_SUPER = 'super';
    const T_THIS = 'this';
    const T_TRUE = 'true';
    const T_VAR = 'var';
    const T_WHILE = 'while';

    const T_EOF = 'eof';
}
