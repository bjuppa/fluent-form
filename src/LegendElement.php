<?php
namespace FewAgency\FluentForm;

use FewAgency\FluentHtml\FluentHtmlElement;
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

    public function precededBy($html_siblings)
    {
        throw new \Exception(__METHOD__ . ' disabled because <legend> should be kept the first element of <fieldset>');
    }

    public function precededByElement($html_element_name, $tag_contents = [], $tag_attributes = [])
    {
        throw new \Exception(__METHOD__ . ' disabled because <legend> should be kept the first element of <fieldset>');
    }

    /**
     * @inheritDoc
     */
    protected function setParent(FluentHtmlElement $parent = null)
    {
        if (is_null($parent) or $parent->getHtmlElementName() == 'fieldset') {
            parent::setParent($parent);
        } else {
            throw new \Exception('<legend> should only be inserted into <fieldset>, not <' . $parent->getHtmlElementName() . '>');
        }
    }


}