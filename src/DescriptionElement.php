<?php
namespace FewAgency\FluentForm;

use FewAgency\FluentForm\FormLabel\AbstractLabel;
use FewAgency\FluentHtml\FluentHtmlElement;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Arrayable;

class DescriptionElement extends AbstractLabel
{
    /**
     * @var FluentHtmlElement referenced by this description
     */
    private $for_element;

    /**
     * @param string|Htmlable|array|Arrayable|null $html_contents
     */
    public function __construct($html_contents = null)
    {
        parent::__construct($html_contents);
        $this->withHtmlElementName('div');
    }

    /**
     * Set the element to describe.
     * @param FluentHtmlElement $element that this description should describe
     * @return $this
     */
    public function forElement(FluentHtmlElement $element)
    {
        $this->for_element = $element;
        $description_element_id = $this->getId($element->getId() . '-desc');
        $element->withAttribute('aria-describedby', function () use ($description_element_id) {
            return $this->willRenderInHtml() ? $description_element_id : null;
        });

        return $this;
    }

    /**
     * Get described element.
     * @return FluentHtmlElement the element this description describes
     */
    public function getDescribedElement()
    {
        return $this->for_element;
    }
}