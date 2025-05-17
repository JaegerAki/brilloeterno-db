<?php
namespace Nagan\BrilloeternoDbSetup;
use Nagan\BrilloeternoDbSetup\ConsoleColor;
class Output
{
    public static function color(string $text, ConsoleColor $color): string
    {
        return $color->value . $text . ConsoleColor::RESET->value;
    }
}

