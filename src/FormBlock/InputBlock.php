<?php
namespace FewAgency\FluentForm\FormBlock;

use FewAgency\FluentForm\FormInput\FormInputElement;
use Illuminate\Contracts\Support\Arrayable;
use FewAgency\FluentHtml\FluentHtmlElement;

class InputBlock extends FormBlock
{
    /**
     * @var string
     */
    private $input_type = 'text';

    /**
     * @var FormInputElement
     */
    private $input_element;

    /**
     * InputBlock constructor.
     * @param string $name of input
     * @param string $type of input or fully qualified classname
     */
    public function __construct($name, $type = 'text')
    {
        $this->withInputName($name);
        $this->input_type = $type;
        parent::__construct();
    }

    /**
     * Set input value.
     * @param $value string|callable
     * @return $this
     */
    public function withInputValue($value)
    {
        $this->getInputElement()->withValue($value);

        return $this;
    }

    /**
     * @param string|callable|array|Arrayable $attributes Attribute name as string, can also be an array of names and values, or a callable returning such an array.
     * @param string|bool|callable|array|Arrayable $value to set, only used if $attributes is a string
     * @return $this
     */
    public function withInputAttribute($attributes, $value = true)
    {
        $this->getInputElement()->withAttribute($attributes, $value);

        return $this;
    }

    /**
     * Set the input element of the block.
     * @param FormInputElement $input_element
     * @return FormBlock
     */
    protected function withInputElement(FormInputElement $input_element)
    {
        $this->input_element = $input_element;
        $this->withLabelElement($this->createInstanceOf('FormLabel\LabelElement'));
        $this->getLabelElement()->forInput($this->input_element);
        $this->getInputElement()->withAttribute('aria-describedby', function (FormInputElement $input_element) {
            return $this->getDescriptionElement()->hasContent() ? $this->getDescriptionElement()->getId($input_element->getId() . '-desc') : null;
        });
        $this->getInputElement()->invalid(function () {
            return $this->hasError();
        });
        $this->getAlignmentElement(2)->withContent($this->getInputElement());

        return $this;
    }

    /**
     * Get the input element of the block.
     * @return FormInputElement
     */
    public function getInputElement()
    {
        return $this->input_element;
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
        if (!$this->getInputElement()) {
            try {
                //Look for a type Input class
                $classname = 'FormInput\\' . ucfirst($this->input_type) . 'InputElement';
                $input_element = $this->createInstanceOf($classname, [$this->getInputName()]);
            } catch (\Exception $e) {
                try {
                    //Look for a type class
                    $classname = 'FormInput\\' . ucfirst($this->input_type) . 'Element';
                    $input_element = $this->createInstanceOf($classname, [$this->getInputName()]);
                } catch (\Exception $e) {
                    try {
                        //Look for a full classname
                        $input_element = $this->createInstanceOf($this->input_type, [$this->getInputName()]);
                    } catch (\Exception $e) {
                        //Fallback to an input with type attribute set
                        $input_element = $this->createInstanceOf('FormInput\\TextInputElement',
                            [$this->getInputName(), $this->input_type]);
                    }
                }
            }
            $input_element->disabled(function () {
                return $this->isDisabled();
            })->readonly(function () {
                return $this->isReadonly();
            })->required(function () {
                return $this->isRequired();
            });
            $this->withInputElement($input_element);
        }
    }

}