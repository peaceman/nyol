<?php
namespace Nyol\Error;

class ErrorReporter
{
    protected $errors = [];

    public function trackError(int $line, string $where, string $message) : void
    {
        $error = new Error($line, $where, $message);
        $this->errors[] = $error;
    }

    public function hadErrors() : bool
    {
        return !empty($this->errors);
    }

    public function getErrors() : array
    {
        return $this->errors;
    }
}
