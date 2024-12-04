<?php

namespace Puzzles\Day3;

use Puzzles\Day3\Instructions\Dont;
use Puzzles\Day3\Instructions\Doo;
use Puzzles\Day3\Instructions\InstructionInterface;
use Puzzles\Day3\Instructions\Multiply;

class InstructionFactory
{
    public static function make(string $instruction): InstructionInterface
    {
        $instructionName = preg_replace('/[^a-z]+/', '', $instruction);
        $arguments = explode(',', preg_replace(
            ['/.+\(/', '/\)/'],
            '',
            $instruction
        ));

        return match (InstructionType::from($instructionName)) {
            InstructionType::MULTIPLY => new Multiply($arguments),
            InstructionType::DO => new Doo(),
            InstructionType::DONT => new Dont(),
        };
    }
}
