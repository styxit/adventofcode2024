<?php

namespace Puzzles\Day1;

use Styxit\Input;
use Styxit\PuzzleSolutionInterface;

class Solution implements PuzzleSolutionInterface
{
    /**
     * Find the solution for part 1.
     */
    public function solution1(Input $input): int
    {
        $lists = $input->collection()
            ->map(fn ($row) => collect(array_map(fn ($nr) => (int) $nr, explode(' ', $row)))->filter());

        // Sorted lists.
        $listOne = $lists->map->first()->sort()->values();
        $listTwo = $lists->map->last()->sort()->values();

        // Combine the lists.
        return $listOne->zip($listTwo)
            // Calculate the spread between the pairs.
            ->map(fn ($pair) => abs(($pair->first() ?: 0) - ($pair->last() ?: 0)))
            // Sum the spread.
            ->sum();
    }

    /**
     * Find the solution for part 2.
     */
    public function solution2(Input $input): int
    {
        $lists = $input->collection()
            ->map(fn ($row) => collect(array_map(fn ($nr) => (int) $nr, explode(' ', $row)))->filter());

        // Lists, not sorted.
        $listOne = $lists->map->first()->values();
        $listTwo = $lists->map->last()->values();

        // Each number in the left list, multiplied by the times it appears in the right list.
        $similarityScores = $listOne->map(fn ($number) => $number * $listTwo->filter(fn ($numberTwo) => $numberTwo === $number)->count());

        return $similarityScores->sum();
    }
}
