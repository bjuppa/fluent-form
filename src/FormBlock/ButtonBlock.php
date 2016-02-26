<?php
namespace FewAgency\FluentForm\FormBlock;

use FewAgency\FluentForm\FormInput\ButtonElement;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;

class ButtonBlock extends FormBlock
{
    /**
     * @param string|Htmlable|array|Arrayable $button_contents
     * @param string $button_type
     */
    public function __construct($button_contents, $button_type = "submit")
    {
        parent::__construct();
        $this->afterInsertion(function () use ($button_contents, $button_type) {
            if (!$this->hasContent()) {
                $this->withButton($button_contents, $button_type);
            }
        });
    }

    /**
     * Add a button to the block.
     * @param string|Htmlable|array|Arrayable $tag_contents
     * @param string $type
     * @return $this
     */
    public function withButton($tag_contents, $type = "submit")
    {
        $this->containingButton($tag_contents, $type);

        return $this;
    }

    /**
     * Adda a button to the block and return the new button element.
     * @param string|Htmlable|array|Arrayable $tag_contents
     * @param string $type
     * @return ButtonElement
     */
    public function containingButton($tag_contents, $type = "submit")
    {
        $button = $this->createInstanceOf('FormInput\ButtonElement', [$tag_contents, $type]);
        $this->getAlignmentElement(2)->withContent($button);

        return $button;
    }

}