<?php
namespace Nyol;

use Nyol\Error\ErrorReporter;

class Nyol
{
    public function run(string $source) : void
    {
        $errorReporter = new ErrorReporter();
        $scanner = new Scanner($errorReporter, $source);
        $tokens = $scanner->scanTokens();

        foreach ($tokens as $token) {
            echo "Token: ${token}\n";
        }

        if ($errorReporter->hadErrors()) {
            echo "Detected the following errors:\n";
            foreach ($errorReporter->getErrors() as $error) {
                echo "Error: ${error}\n";
            }
        }
    }
}
