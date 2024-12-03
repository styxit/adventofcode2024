<?php

namespace Styxit;

interface PuzzleSolutionInterface
{
    public function solution1(Input $input): int;

    public function solution2(Input $input): int;
}
