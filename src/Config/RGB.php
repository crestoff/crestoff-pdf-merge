<?php

namespace Karriere\PdfMerge\Config;

class RGB
{
    private $red;
    private $green;
    private $blue;

    public function __construct(int $red = 0, int $green = 0, int $blue = 0)
    {
        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
    }

    /**
     * @return array<int>
     */
    public function toArray(): array
    {
        return [$this->red, $this->green, $this->blue];
    }
}
