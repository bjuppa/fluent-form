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
     * @var string
     */
    private $input_name;

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
        $this->input_name = $name;
        $this->input_type = $type;
        parent::__construct();
    }

    /**
     * Set the input element of the block.
     * @param FormInputElement $input_element
     * @return FormBlock
     */
    public function withInputElement(FormInputElement $input_element)
    {
        $this->input_element = $input_element;
        $this->withLabelElement($this->createInstanceOf('FormLabel\LabelElement'));
        $this->getLabelElement()->forInput($this->input_element);
        $this->withContent($this->input_element);
        $this->getInputElement()->withAttribute('aria-describedby', function (FormInputElement $input_element) {
            return $this->getDescriptionElement()->hasContent() ? $this->getDescriptionElement()->getId($input_element->getId() . '-desc') : null;
        });

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
     * Set this element's parent element.
     *
     * @param FluentHtmlElement|null $parent
     */
    protected function setParent(FluentHtmlElement $parent = null)
    {
        parent::setParent($parent);
        if (!$this->getInputElement()) {
            try {
                //Look for a type class
                $classname = 'FormInput\\' . ucfirst($this->input_type) . 'InputElement';
                $input_element = $this->createInstanceOf($classname, [$this->input_name]);
            } catch (\Exception $e) {
                try {
                    //Look for a full classname
                    $input_element = $this->createInstanceOf($this->input_type, [$this->input_name]);
                } catch (\Exception $e) {
                    //Fallback to an input with type attribute set
                    $input_element = $this->createInstanceOf('FormInput\\TextInputElement',
                        [$this->input_name, $this->input_type]);
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