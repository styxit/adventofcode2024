<?php

namespace Puzzles\Day3;

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
        // Extract valid instructions from the input.
        preg_match_all(
            self::INSTRUCTION_REGEX,
            $input->plain(),
            $matches
        );

        // Parse and execute the instructions.
        $products = collect($matches[0])->map(function ($instruction) {
            // Extract all numbers from the instruction.
            preg_match_all(
                '/\d+/',
                $instruction,
                $numbers
            );

            // Return the product of the numbers.
            return array_product($numbers[0]);
        });

        return $products->sum();
    }

    /**
     * Find the solution for part 2.
     */
    public function solution2(Input $input): int
    {
        return 0;
    }
}
