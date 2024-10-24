<?php

namespace Karriere\PdfMerge\Config;

class FooterConfig
{
    private $textColor;
    private $lineColor;
    private $margin;

    /**
     * @param ?RGB $textColor RGB array color for text
     * @param ?RGB $lineColor RGB array color for line
     * @param int $margin minimum distance (in "user units") between footer and bottom page margin
     */
    public function __construct($textColor = null, $lineColor = null, $margin = 0)
    {
        $this->textColor = $textColor;
        $this->lineColor = $lineColor;
        $this->margin = $margin;
    }

    public function textColor(): RGB
    {
        return $this->textColor ?: new RGB();
    }

    public function lineColor(): RGB
    {
        return $this->lineColor ?: new RGB();
    }

    public function margin(): int
    {
        return $this->margin;
    }
}
