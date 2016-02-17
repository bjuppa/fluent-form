<?php
namespace FewAgency\FluentForm\FormBlock;

use FewAgency\FluentForm\FormInput\FormInputElement;
use FewAgency\FluentForm\FormInput\TextInputElement;
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

    /* TODO: implement these methods on InputBlock:
    ->withInputAttribute(attributes)
    */

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
                $classname = 'FormInput\\' . ucfirst($this->input_type) . 'InputElement';
                $input_element = $this->createInstanceOf($classname, [$this->input_name]);
            } catch (\Exception $e) {
                try {
                    $input_element = $this->createInstanceOf($this->input_type, [$this->input_name]);
                } catch (\Exception $e) {
                    $input_element = $this->createInstanceOf('FormInput\\TextInputElement', [$this->input_name]);
                }
            }
            $this->withInputElement($input_element);
        }
    }


}