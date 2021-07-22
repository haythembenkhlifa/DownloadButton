<?php

namespace Haythem\DownloadButton;

use Laravel\Nova\Fields\Field;

class DownloadButton extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'download-button';

    public function url($url)
    {
        return $this->withMeta(["url"=>$url]);
    }

    public function downloadButtonText($downloadButtonText = "Download")
    {
        return $this->withMeta(["downloadButtonText"=>$downloadButtonText]);
    }

    public function showViewButtonText($viewButtonText = "View")
    {
        return $this->withMeta(["viewButtonText"=>$viewButtonText]);
    }

    public function showPrintButtonText($printButtonText = "Print")
    {
        return $this->withMeta(["printButtonText"=>$printButtonText]);
    }

}
