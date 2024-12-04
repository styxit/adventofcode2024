<?php

namespace Puzzles\Day3;

use Illuminate\Support\Collection;
use Puzzles\Day3\Instructions\Dont;
use Puzzles\Day3\Instructions\Doo;
use Puzzles\Day3\Instructions\InstructionInterface;
use Styxit\Input;
use Styxit\PuzzleSolutionInterface;

class Solution implements PuzzleSolutionInterface
{
    public const INSTRUCTION_REGEX = '/mul\(\d{1,3},\d{1,3}\)/';

    /**
     * Find the solution for part 1.
     */
    public function solution1(Input $input): int
    {
        $instructions = $this->getInstructions($input->plain());

        $results = $instructions
            ->map(fn (InstructionInterface $instruction) => $instruction->handle());

        return (int) array_sum($results->toArray());
    }

    /**
     * Find the solution for part 2.
     */
    public function solution2(Input $input): int
    {
        $instructions = $this->getInstructions($input->plain());

        $doInstruction = true;

        // Only keep instructions that come after a "do" instruction.
        $instructions = $instructions->filter(function ($instruction) use (&$doInstruction) {
            if (is_a($instruction, Doo::class)) {
                $doInstruction = true;

                return false;
            }
            if (is_a($instruction, Dont::class)) {
                $doInstruction = false;

                return false;
            }

            return $doInstruction;
        });

        $results = $instructions
            ->map(fn (InstructionInterface $instruction) => $instruction->handle());

        return (int) array_sum($results->toArray());
    }

    /**
     * Undocumented function.
     *
     * @param string $input
     *
     * @return Collection<int, InstructionInterface>
     */
    private function getInstructions(string $input): Collection
    {
        preg_match_all(
            '/mul\(\d{1,3},\d{1,3}\)|do\(\)|don\'t\(\)/',
            $input,
            $matches
        );

        return collect($matches[0])->map(function ($instruction) {
            return InstructionFactory::make($instruction);
        });
    }
}
