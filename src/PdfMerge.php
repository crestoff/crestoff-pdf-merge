<?php

namespace Karriere\PdfMerge;

use Karriere\PdfMerge\Config\FooterConfig;
use Karriere\PdfMerge\Config\HeaderConfig;
use Karriere\PdfMerge\Exceptions\FileNotFoundException;
use Karriere\PdfMerge\Exceptions\NoFilesDefinedException;
use TCPDI;

class PdfMerge
{
    /**
     * @var array<int, string>
     */
    private $files = [];
    private $pdf;
    private $headerConfig;
    private $footerConfig;

    /**
     * Passed parameters override settings for header and footer by calling tcpdf.php methods:
     * setHeaderData($ln='', $lw=0, $ht='', $hs='', $tc=array(0,0,0), $lc=array(0,0,0))
     * setFooterData($tc=array(0,0,0), $lc=array(0,0,0))
     * For more info about tcpdf, please read https://tcpdf.org/docs/
     */
    public function __construct(?HeaderConfig $headerConfig = null, ?FooterConfig $footerConfig = null)
    {
        $this->pdf = new TCPDI();
        $this->headerConfig = $headerConfig;
        $this->footerConfig = $footerConfig;
        $this->configureHeaderAndFooter();
    }

    public function getPdf(): TCPDI
    {
        return $this->pdf;
    }

    /**
     * Adds a file to merge
     */
    public function add(string $file): void
    {
        if (!file_exists($file)) {
            throw new FileNotFoundException($file);
        }

        $this->files[] = $file;
    }

    /**
     * Checks if the given file is already registered for merging
     */
    public function contains(string $file): bool
    {
        return in_array($file, $this->files);
    }

    /**
     * Resets the stored files
     */
    public function reset(): void
    {
        $this->files = [];
    }

    /**
     * Generates a merged PDF file from the already stored PDF files
     */
    public function merge(string $outputFilename, string $destination = 'F'): string
    {
        if (count($this->files) === 0) {
            throw new NoFilesDefinedException();
        }

        foreach ($this->files as $file) {
            $pageCount = $this->pdf->setSourceFile($file);

            for ($i = 1; $i <= $pageCount; $i++) {
                $pageId = $this->pdf->ImportPage($i);
                $size = $this->pdf->getTemplateSize($pageId);

                $this->pdf->AddPage('', $size);
                $this->pdf->useTemplate($pageId, null, null, 0, 0, true);
            }
        }

        return $this->pdf->Output($outputFilename, $destination);
    }

    private function configureHeaderAndFooter(): void
    {
        if ($this->headerConfig) {
            $this->pdf->setHeaderData(
                $this->headerConfig->imagePath(),
                $this->headerConfig->logoWidthMM(),
                $this->headerConfig->title(),
                $this->headerConfig->text(),
                $this->headerConfig->textColor()->toArray(),
                $this->headerConfig->lineColor()->toArray()
            );
        } else {
            $this->pdf->setPrintHeader(false);
        }

        if ($this->footerConfig) {
            $this->pdf->setFooterData($this->footerConfig->textColor()->toArray(), $this->footerConfig->lineColor()->toArray());
            $this->pdf->setFooterMargin($this->footerConfig->margin());
        } else {
            $this->pdf->setPrintFooter(false);
        }
    }
}
