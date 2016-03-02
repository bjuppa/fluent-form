<?php
namespace FewAgency\FluentForm\FormBlockContainer;


use FewAgency\FluentHtml\FluentHtmlElement;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;

class FieldsetElement extends FormBlockContainer
{
    /**
     * @var FluentHtmlElement
     */
    private $legend_element;

    public function __construct()
    {
        parent::__construct();
        $this->withHtmlElementName('fieldset');
        $this->legend_element = $this->createFluentHtmlElement('legend')->onlyDisplayedIfHasContent();
        $this->withContent($this->legend_element);
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
        return $this->legend_element;
    }
}