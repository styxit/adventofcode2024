<?php

namespace Puzzles\Day2;

use Styxit\Input;
use Styxit\PuzzleSolutionInterface;

class Solution implements PuzzleSolutionInterface
{
    /**
     * Find the solution for part 1.
     */
    public function solution1(Input $input)
    {
        $reports = $input->collection()
            ->map(fn ($report) => array_map(fn ($nr) => (int) $nr, explode(' ', $report)))
            ->filter($this->reportIsSafe(...))
        ;

        return $reports->count();
    }

    /**
     * Find the solution for part 2.
     */
    public function solution2(Input $input)
    {
        // Group reports in safe and unsafe.
        [$safeReports, $unsafeReports] = $input->collection()
            ->map(fn ($report) => array_map(fn ($nr) => (int) $nr, explode(' ', $report)))
            ->partition($this->reportIsSafe(...))
        ;

        // Try to fix the unsafe reports by removing a level and see if that makes it safe.
        $fixedReports = $unsafeReports->filter(function (array $report) {
            // Remove a value and check again.
            foreach ($report as $key => $level) {
                $reportWithoutValue = $report;
                unset($reportWithoutValue[$key]);
                $reportWithoutValue = array_values($reportWithoutValue);

                if ($this->reportIsSafe($reportWithoutValue)) {
                    return true;
                }
            }

            return false;
        });

        return $safeReports->count() + $fixedReports->count();
    }

    private function reportIsSafe(array $report): bool
    {
        // Use the first two levels to determine if this is an increasing or decreasing report.
        // All other pairs should follow the same pattern.
        $increasing = $report[1] > $report[0];

        for ($i = 0; $i < (count($report) - 1); ++$i) {
            $currentLevel = $report[$i];
            $nextLevel = $report[$i + 1];
            $diff = abs($currentLevel - $nextLevel);

            if ($diff > 3 || $diff < 1) {
                return false;
            }

            // Make sure the levels are all increasing or decreasing.
            if ($increasing && $currentLevel > $nextLevel) {
                return false;
            }
            if (!$increasing && $currentLevel < $nextLevel) {
                return false;
            }
        }

        return true;
    }
}
