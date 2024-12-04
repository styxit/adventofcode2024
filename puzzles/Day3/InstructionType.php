<?php

namespace Puzzles\Day3;

enum InstructionType: string
{
    case MULTIPLY = 'mul';
    case DO = 'do';
    case DONT = 'dont';
}
