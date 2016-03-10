<?php
namespace FewAgency\FluentForm\FormBlockContainer;


use FewAgency\FluentHtml\FluentHtmlElement;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;

class FieldsetElement extends AbstractFormBlockContainer
{
    /**
     * @var FluentHtmlElement
     */
    private $legend_element;

    public function __construct()
    {
        parent::__construct();
        $this->withHtmlElementName('fieldset');
        $this->withPrependedContent(function () {
            return $this->getLegendElement();
        });
    }

    /**
     * Add legend content.
     * @param string|Htmlable|callable|array|Arrayable $html_contents,...
     * @return $this|FluentHtmlElement can be method-chained to modify the current element
     */
    public function withLegend($html_contents)
    {
        $this->getLegendElement()->withContent(func_get_args());

        return $this;
    }

    /**
     * Get the legend element of this fieldset.
     * @return FluentHtmlElement
     */
    private function getLegendElement()
    {
        if (!$this->legend_element) {
            $this->legend_element = $this->createInstanceOf('FormLabel\LegendElement');
        }

        return $this->legend_element;
    }
}