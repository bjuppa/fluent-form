<?php
namespace FewAgency\FluentForm;

use FewAgency\FluentForm\Support\CheckableControlContract;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;

class CheckboxBlock extends AbstractControlBlock implements CheckableControlContract
{
    /**
     * @var CheckboxInputElement
     */
    private $main_checkbox;

    protected $checkbox_wrapper_classname = 'form-block__checkbox-wrapper';

    /**
     * @param string $name of input
     */
    public function __construct($name)
    {
        $this->withInputName($name);
        parent::__construct();
        $this->containingCheckbox($this->getInputName());
    }

    /**
     * Add a checkbox to the block.
     * @param string $name
     * @return $this
     */
    public function withCheckbox($name)
    {
        $this->containingCheckbox($name);

        return $this;
    }

    /**
     * Add a checkbox to the block and return the new checkbox element.
     * @param string $name
     * @return CheckboxInputElement
     */
    public function containingCheckbox($name)
    {
        $checkbox = $this->createInstanceOf('CheckboxInputElement', [$name]);
        //Create description
        $this->getDescriptionElement()->forElement($checkbox);
        //Configure input
        $checkbox->invalid(function () {
            return $this->hasError();
        })->disabled(function () {
            return $this->isDisabled();
        })->required(function () {
            return $this->isRequired();
        });
        //Wrap in label and insert input element
        $this->getAlignmentElement(2)->withContent($checkbox->wrappedInLabel()->wrappedInElement(function () {
            return $this->isInline() ? 'span' : 'div';
        })->withClass($this->checkbox_wrapper_classname));

        if (empty($this->main_checkbox)) {
            $this->main_checkbox = $checkbox;
        }

        return $checkbox;
    }

    /**
     * Get the first added checkbox element in this block.
     * @return CheckboxInputElement
     */
    public function getMainCheckboxElement()
    {
        return $this->main_checkbox;
    }

    /**
     * Set input value.
     * @param $value string|callable
     * @return $this
     */
    public function withInputValue($value)
    {
        $this->getMainCheckboxElement()->withValue($value);

        return $this;
    }

    /**
     * @param string|callable|array|Arrayable $attributes Attribute name as string, can also be an array of names and values, or a callable returning such an array.
     * @param string|bool|callable|array|Arrayable $value to set, only used if $attributes is a string
     * @return $this
     */
    public function withInputAttribute($attributes, $value = true)
    {
        $this->getMainCheckboxElement()->withAttribute($attributes, $value);

        return $this;
    }

    /**
     * Make input selected.
     * @param bool|callable $checked
     * @return $this
     */
    public function checked($checked = true)
    {
        $this->getMainCheckboxElement()->checked($checked);

        return $this;
    }

    /**
     * Make input not selected.
     * @return $this
     */
    public function unchecked()
    {
        $this->getMainCheckboxElement()->unchecked();

        return $this;
    }

    /**
     * Check if input is selected.
     * @return bool
     */
    public function isChecked()
    {
        return $this->getMainCheckboxElement()->isChecked();
    }

    /**
     * Add label content.
     * @param string|Htmlable|callable|array|Arrayable $html_contents,...
     * @return $this
     */
    public function withLabel($html_contents)
    {
        $this->getMainCheckboxElement()->getParent()->withAppendedContent(func_get_args());

        return $this;
    }
}