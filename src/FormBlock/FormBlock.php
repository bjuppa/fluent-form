<?php
namespace FewAgency\FluentForm\FormBlock;

use FewAgency\FluentForm\FormLabel\FormLabel;
use FewAgency\FluentHtml\FluentHtml;
use FewAgency\FluentForm\Support\FormElementContract;
use FewAgency\FluentForm\Support\FormElement;
use FewAgency\FluentHtml\FluentHtmlElement;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;


abstract class FormBlock extends FluentHtml implements FormElementContract
{
    use FormElement;

    /**
     * @var FormLabel
     */
    private $label_element;

    /**
     * @var FluentHtmlElement
     */
    private $description_element;

    /**
     * @var bool|callable indicating if the block's inputs are disabled
     */
    private $disabled = false;

    /**
     * @var bool|callable indicating if the block's inputs are readonly
     */
    private $readonly = false;

    /**
     * @var bool|callable indicating if the block's inputs are required
     */
    private $required = false;

    /**
     * @param string|callable $html_element_name
     */
    public function __construct($html_element_name = 'div')
    {
        parent::__construct($html_element_name);
        $this->withClass([
            'disabled' => function (FormBlock $form_block) {
                return $form_block->isDisabled();
            },
            'required' => function (FormBlock $form_block) {
                return $form_block->isRequired();
            }
        ]);
        $this->withAttribute('disabled', function (FormBlock $form_block) {
            return $form_block->isDisabled() and $form_block->getHtmlElementName() == 'fieldset';
        });
    }

    /**
     * Set label content.
     * @param string|Htmlable|callable|array|Arrayable $html_contents,...
     * @return $this|FluentHtmlElement can be method-chained to modify the current element
     */
    public function withLabel($html_contents)
    {
        $this->getLabelElement()->withContent(func_get_args());

        return $this;
    }

    /**
     * Get the label element of the block.
     * @return FormLabel
     */
    public function getLabelElement()
    {
        return $this->label_element;
    }

    /**
     * Set the label element of the block.
     * @param FormLabel $label_element
     * @return $this|FluentHtmlElement can be method-chained to modify the current element
     */
    public function withLabelElement(FormLabel $label_element)
    {
        $this->label_element = $label_element;
        $this->withContent($this->label_element);

        return $this;
    }

    /**
     * Set description content.
     * @param string|Htmlable|callable|array|Arrayable $html_contents,...
     * @return $this|FluentHtmlElement can be method-chained to modify the current element
     */
    public function withDescription($html_contents)
    {
        $this->getDescriptionElement()->withContent(func_get_args());

        return $this;
    }

    /**
     * Get the description element of the block.
     * @return FluentHtmlElement
     */
    public function getDescriptionElement()
    {
        if (!$this->description_element) {
            $this->withDescriptionElement($this->createFluentHtmlElement('div')->onlyDisplayedIfHasContent());
        }

        return $this->description_element;
    }

    /**
     * Set the description element of the block.
     * @param FluentHtmlElement $description_element
     * @return $this|FluentHtmlElement can be method-chained to modify the current element
     */
    public function withDescriptionElement(FluentHtmlElement $description_element)
    {
        $this->description_element = $description_element;
        $this->withContent($this->description_element);

        return $this;
    }


    /**
     * Put an input block after this block
     * @param $name
     * @param string $type
     * @return InputBlock
     */
    public function followedByInputBlock($name, $type = 'text')
    {
        return $this->getFormBlockContainer()->containingInputBlock($name, $type);
    }

    /**
     * Make the input(s) in the block disabled
     * @param bool|callable $disabled
     * @return $this
     */
    public function disabled($disabled = true)
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * Check if the block is disabled
     * @return bool true if the block is considered disabled
     */
    public function isDisabled()
    {
        return (bool)$this->evaluate($this->disabled);
    }

    /**
     * Make the input(s) in the block readonly
     * @param bool|callable $readonly
     * @return $this
     */
    public function readonly($readonly = true)
    {
        $this->readonly = $readonly;

        return $this;
    }

    /**
     * Check if the block is readonly
     * @return bool true if the block's items is considered readonly
     */
    public function isReadonly()
    {
        return (bool)$this->evaluate($this->readonly);
    }

    /**
     * Make the input(s) in the block required
     * @param bool|callable $required
     * @return $this
     */
    public function required($required = true)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * Check if the block is required
     * @return bool true if the block is considered required
     */
    public function isRequired()
    {
        return (bool)$this->evaluate($this->required);
    }

    /* TODO: implement these methods on FormBlock:
    ->withError(messages)
    ->withWarning(messages)
    ->withSuccess(true)
    ->withFeedback(html)

    ->getScreenReaderOnlyClass()
    ->hideLabel()

    ->getColumnElement(column number)
    ->getAlignmentClasses(column number, bool with_offset=false)

    ->followedBy…Block()
     */

}