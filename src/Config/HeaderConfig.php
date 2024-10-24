<?php

namespace Karriere\PdfMerge\Config;

class HeaderConfig
{
    /**
     * @param string $imagePath header image logo
     * @param int $logoWidthMM header image logo width in mm
     * @param string $title string to print as title on document header
     * @param string $text string to print on document header
     * @param ?RGB $textColor RGB array color for text
     * @param ?RGB $lineColor RGB array color for line
     */
    public function __construct(
        private $imagePath = '',
        private $logoWidthMM = 0,
        private $title = '',
        private $text = '',
        private $textColor = null,
        private $lineColor = null,
    ) {
    }

    public function imagePath(): string
    {
        return $this->imagePath;
    }

    public function logoWidthMM(): int
    {
        return $this->logoWidthMM;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function text(): string
    {
        return $this->text;
    }

    public function textColor(): RGB
    {
        return $this->textColor ?: new RGB();
    }

    public function lineColor(): RGB
    {
        return $this->lineColor ?: new RGB();
    }
}
