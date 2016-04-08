<?php
namespace FewAgency\FluentForm;

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
        $element->withAttribute('aria-describedby', function () {
            return $this->willRenderInHtml() ? $this->getId() : null;
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

    /**
     * Get the element's id string if set, or generate a new id.
     * @param null $desired_id
     * @return string
     */
    public function getId($desired_id = null)
    {
        return parent::getId($desired_id ?: ($this->getDescribedElement() ? $this->getDescribedElement()->getId() . '-' : '') . 'desc');
    }

    /**
     * Render element as html string.
     *
     * @return string containing rendered html of this element and all its descendants
     */
    public function branchToHtml()
    {
        // Description elements should always print with an id for referencing
        $this->getId();

        return parent::branchToHtml();
    }


}