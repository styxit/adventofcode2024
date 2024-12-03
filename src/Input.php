<?php

namespace Styxit;

use Illuminate\Support\Collection;

class Input
{
    /**
     * @var string The plain text input.
     */
    private string $plain = '';

    /**
     * @var string[] Array with the lines from the input.
     */
    private array $lines = [];

    /**
     * Loader constructor.
     */
    public function __construct(string $inputString)
    {
        $this->plain = trim($inputString, "\n\r\t\v\x00");
        $this->lines = explode(PHP_EOL, $this->plain);
    }

    /**
     * Input as an array.
     *
     * @return string[] The input separated by line.
     */
    public function lines()
    {
        return $this->lines;
    }

    /**
     * Get the input as a collection.
     *
     * @return Collection<int, string> Collection with each line as an item.
     */
    public function collection()
    {
        return new Collection($this->lines());
    }

    /**
     * Get plain text input.
     *
     * @return string
     */
    public function plain()
    {
        return $this->plain;
    }
}
