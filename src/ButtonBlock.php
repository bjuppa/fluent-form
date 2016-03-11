<?php
namespace FewAgency\FluentForm;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;

class ButtonBlock extends AbstractControlBlock
{
    /**
     * @var ButtonElement
     */
    private $main_button;

    /**
     * @param string|Htmlable|array|Arrayable $button_contents
     * @param string $button_type
     */
    public function __construct($button_contents, $button_type = "submit")
    {
        parent::__construct();
        $this->afterInsertion(function () use ($button_contents, $button_type) {
            if (!$this->getAlignmentElement(2)->hasContent()) {
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
        $button = $this->createInstanceOf('ButtonElement', [$tag_contents, $type]);
        $button->withName(function () {
            return $this->getInputName();
        })->disabled(function () {
            return $this->isDisabled();
        });
        $this->getAlignmentElement(2)->withContent($button);

        if (empty($this->main_button)) {
            $this->main_button = $button;
        }

        return $button;
    }

    /**
     * Get the first set button element in this block.
     * @return ButtonElement
     */
    public function getMainButtonElement()
    {
        return $this->main_button;
    }

    /**
     * Set input value.
     * @param $value string|callable
     * @return $this
     */
    public function withInputValue($value)
    {
        $this->getMainButtonElement()->withValue($value);

        return $this;
    }

    /**
     * @param string|callable|array|Arrayable $attributes Attribute name as string, can also be an array of names and values, or a callable returning such an array.
     * @param string|bool|callable|array|Arrayable $value to set, only used if $attributes is a string
     * @return $this
     */
    public function withInputAttribute($attributes, $value = true)
    {
        $this->getMainButtonElement()->withAttribute($attributes, $value);

        return $this;
    }

}