<?php
namespace FewAgency\FluentForm\FormLabel;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Arrayable;

class LegendElement extends FormLabel
{
    /**
     * LegendElement constructor.
     * @param string|Htmlable|array|Arrayable|null $label_contents
     */
    public function __construct($label_contents = null)
    {
        parent::__construct('legend', $label_contents);
    }
}