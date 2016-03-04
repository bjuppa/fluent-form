<?php
namespace FewAgency\FluentForm\FormLabel;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Arrayable;

class LegendElement extends FormLabel
{
    /**
     * LegendElement constructor.
     * @param string|Htmlable|array|Arrayable|null $legend_contents
     */
    public function __construct($legend_contents = null)
    {
        parent::__construct($legend_contents);
        $this->withHtmlElementName('legend');
    }
}