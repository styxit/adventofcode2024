<?php

namespace Puzzles\Day3\Instructions;

class Multiply implements InstructionInterface
{
    /**
     * @param string[] $arguments
     */
    public function __construct(private array $arguments) {}

    public function handle(): ?int
    {
        return array_product($this->arguments);
    }
}
