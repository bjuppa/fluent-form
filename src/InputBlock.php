<?php
namespace FewAgency\FluentForm;

use Illuminate\Contracts\Support\Arrayable;

class InputBlock extends AbstractControlBlock
{
    /**
     * @var AbstractFormControl
     */
    private $input_element;

    /**
     * @var string css class name to put on input elements
     */
    protected $form_control_class = 'form-block__control';

    /**
     * @param string $name of input
     * @param string $input_type of input or fully qualified classname
     */
    public function __construct($name, $input_type = 'text')
    {
        $this->withInputName($name);
        parent::__construct();
        $input_element = $this->generateInputElement($input_type);
        $this->withInputElement($input_element);
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
     * Generate a new AbstractInput object.
     * @param string $input_type
     * @return AbstractInput
     */
    protected function generateInputElement($input_type)
    {
        try {
            //Look for a type Input class
            $classname = ucfirst($input_type) . 'InputElement';
            $input_element = $this->createInstanceOf($classname, [$this->getInputName()]);
        } catch (\Exception $e) {
            try {
                //Look for a type class
                $classname = ucfirst($input_type) . 'Element';
                $input_element = $this->createInstanceOf($classname, [$this->getInputName()]);
            } catch (\Exception $e) {
                try {
                    //Look for a full classname
                    $input_element = $this->createInstanceOf($input_type, [$this->getInputName()]);
                } catch (\Exception $e) {
                    //Fallback to an input with type attribute set
                    $input_element = $this->createInstanceOf('TextInputElement',
                        [$this->getInputName(), $input_type]);
                }
            }
        }
        return $input_element;
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
     * @param AbstractFormControl $input_element
     * @return AbstractControlBlock
     */
    protected function withInputElement(AbstractFormControl $input_element)
    {
        $this->input_element = $input_element;
        //Create label
        $this->withLabelElement($this->createInstanceOf('LabelElement'));
        $this->getLabelElement()->forControl($this->getInputElement());
        //Create description
        $this->getDescriptionElement()->forElement($input_element);
        //Configure input
        $this->getInputElement()->withClass($this->form_control_class)
            ->invalid(function () {
                return $this->hasError();
            })->disabled(function () {
                return $this->isDisabled();
            })->readonly(function () {
                return $this->isReadonly();
            })->required(function () {
                return $this->isRequired();
            });
        //Insert input element
        $this->getAlignmentElement(2)->withContent($this->getInputElement());

        return $this;
    }

    /**
     * Get the input element of the block.
     * @return AbstractFormControl
     */
    public function getInputElement()
    {
        return $this->input_element;
    }

}