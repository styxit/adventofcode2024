<?php

namespace Puzzles\Day3\Instructions;

interface InstructionInterface
{
    public function handle(): ?int;
}
