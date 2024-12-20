<?php

namespace Tests\Solutions;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use PHPUnit\Framework\TestCase;
use Styxit\Input;
use Styxit\InputLoader;
use Styxit\PuzzleSolutionInterface;

abstract class AbstractDayTester extends TestCase
{
    public const SOLUTION_CLASS = 'Puzzles\Day%d\Solution';

    protected int $solutionPart1 = 0;
    protected int $solutionPart2 = 0;

    protected int $exampleSolution1 = 0;
    protected int $exampleSolution2 = 0;

    public function testExample1(): void
    {
        $this->executeAndAssert(1, true);
    }

    public function testExample2(): void
    {
        $this->executeAndAssert(2, true);
    }

    public function testSolution1(): void
    {
        $this->executeAndAssert(1);
    }

    public function testSolution2(): void
    {
        $this->executeAndAssert(2);
    }

    private function executeAndAssert(int $part, bool $example = false): void
    {
        $puzzleSolution = $this->getSolutionClass();
        $input = $this->getPuzzleInput($part, $example);

        // Run the solution with the input.
        $solution = $puzzleSolution->{'solution'.$part}($input);

        if ($example) {
            $expectedSolution = $this->{'exampleSolution'.$part};
            $message = sprintf('Example part %d failed.', $part);
        } else {
            $expectedSolution = $this->{'solutionPart'.$part};
            $message = sprintf('Part %d failed.', $part);
        }

        $this->assertSame($expectedSolution, $solution, $message);
    }

    private function getPuzzleInput(int $part, bool $example = false): Input
    {
        try {
            if ($example) {
                $inputTxt = InputLoader::example($this->getPuzzleDay(), $part);
            } else {
                $inputTxt = InputLoader::input($this->getPuzzleDay(), $part);
            }
        } catch (FileNotFoundException $exception) {
            $this->markTestSkipped('Skipping test; Input unavailable.');
        }

        return new Input($inputTxt);
    }

    private function getPuzzleDay(): int
    {
        preg_match('/\d+/', $this::class, $matches);

        return (int) reset($matches);
    }

    private function getSolutionClass(): PuzzleSolutionInterface
    {
        $solutionClass = sprintf(self::SOLUTION_CLASS, $this->getPuzzleDay());

        if (!is_a($solutionClass, PuzzleSolutionInterface::class, true)) {
            throw new \InvalidArgumentException('The puzzle solution does not implement PuzzleSolutionInterface');
        }

        return new $solutionClass();
    }
}
