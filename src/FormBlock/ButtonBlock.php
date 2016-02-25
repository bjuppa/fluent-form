<?php
namespace FewAgency\FluentForm\FormBlock;

use FewAgency\FluentHtml\FluentHtmlElement;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;

class ButtonBlock extends FormBlock
{
    /**
     * @var array|Arrayable|Htmlable|string
     */
    private $button_contents;

    /**
     * @var string
     */
    private $button_type = "submit";

    /**
     * @param string|Htmlable|array|Arrayable $button_contents
     * @param string $button_type
     */
    public function __construct($button_contents, $button_type = "submit")
    {
        parent::__construct();
        $this->button_contents = $button_contents;
        $this->button_type = $button_type;
    }

    /**
     * Add a button to the block.
     * @param string|Htmlable|array|Arrayable $tag_contents
     * @param string $type
     * @return $this
     */
    public function withButton($tag_contents, $type = "submit")
    {
        $button = $this->createInstanceOf('FormInput\ButtonElement', [$tag_contents, $type]);
        $this->getAlignmentElement(2)->withContent($button);

        return $this;
    }

    /**
     * Set this element's parent element.
     *
     * @param FluentHtmlElement|null $parent
     */
    protected function setParent(FluentHtmlElement $parent = null)
    {
        parent::setParent($parent);
        //TODO: set this as afterInsertion callback in constructor
        if (!$this->hasContent()) {
            $this->withButton($this->button_contents, $this->button_type);
        }
    }


}