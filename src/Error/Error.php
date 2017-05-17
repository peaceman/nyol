<?php
namespace Nyol\Error;

class Error
{
    protected $line;
    protected $where;
    protected $message;

    public function __construct(int $line, string $where, string $message)
    {
        $this->line = $line;
        $this->where = $where;
        $this->message = $message;
    }

    public function __toString() : string
    {
        return sprintf('[line %d] Error (%s): %s', $this->line, $this->where, $this->message);
    }
}
