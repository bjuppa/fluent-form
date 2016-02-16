<?php
namespace FewAgency\FluentForm\FormBlock;

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