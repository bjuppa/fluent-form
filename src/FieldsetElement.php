<?php
namespace FewAgency\FluentForm;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;

class FieldsetElement extends AbstractControlBlockContainer
{
    /**
     * @var LegendElement
     */
    private $legend_element;

    public function __construct()
    {
        parent::__construct();
        $this->withHtmlElementName('fieldset');
        $this->withContent(function () {
            return $this->getLegendElement();
        });
    }

    /**
     * Add legend content.
     * @param string|Htmlable|callable|array|Arrayable $html_contents,...
     * @return $this
     */
    public function withLegend($html_contents)
    {
        $this->getLegendElement()->withContent(func_get_args());

        return $this;
    }

    /**
     * Get the legend element of this fieldset.
     * @return LegendElement
     */
    private function getLegendElement()
    {
        if (empty($this->legend_element)) {
            $this->legend_element = $this->createInstanceOf('LegendElement');
        }

        return $this->legend_element;
    }

    public function withPrependedContent($html_contents)
    {
        throw new \Exception(__FUNCTION__ . ' disabled because <legend> should be kept the first element of <fieldset>');
    }

    public function startingWithElement($html_element_name, $tag_contents = [], $tag_attributes = [])
    {
        throw new \Exception(__FUNCTION__ . ' disabled because <legend> should be kept the first element of <fieldset>');
    }


}