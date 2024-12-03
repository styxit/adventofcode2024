<?php

namespace Styxit;

use Illuminate\Contracts\Filesystem\FileNotFoundException;

class InputLoader
{
    /**
     * @var string Define path to the input or example file.
     */
    public const INPUT_ROOT = __DIR__.'/../puzzles/Day%d/input/%s';

    public static function input(int $day, ?int $inputNr = null): string
    {
        return self::loadInput($day, 'input', $inputNr);
    }

    public static function example(int $day, ?int $exampleNr = null): string
    {
        return self::loadInput($day, 'example', $exampleNr);
    }

    private static function loadInput(int $day, string $fileNameBase, ?int $nr = null): string
    {
        $fileName = $fileNameBase.$nr.'.txt';

        $path = self::getFilePath($day, $fileName);

        if (!file_exists($path) && $nr) {
            return self::loadInput($day, $fileNameBase);
        }
        if (!file_exists($path)) {
            throw new FileNotFoundException('Input file does not exists.');
        }

        $intputString = file_get_contents($path);

        if (!$intputString) {
            throw new FileNotFoundException('Input could not be loaded.');
        }

        return $intputString;
    }

    /**
     * Get full file path for an input file.
     *
     * @return string The full path where the input file is located.
     */
    private static function getFilePath(int $day, string $fileName): string
    {
        return sprintf(self::INPUT_ROOT, $day, $fileName);
    }
}
