<?php
namespace FewAgency\FluentForm;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Arrayable;

class LegendElement extends AbstractLabel
{
    /**
     * @param string|Htmlable|array|Arrayable|null $legend_contents
     */
    public function __construct($legend_contents = null)
    {
        parent::__construct($legend_contents);
        $this->withHtmlElementName('legend');
    }
}