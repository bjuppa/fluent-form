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
     * @var bool|callable indicating if the block's inputs are disabled
     */
    private $disabled = false;

    /**
     * @param string|callable $html_element_name
     */
    public function __construct($html_element_name = 'div')
    {
        parent::__construct($html_element_name);
        $this->withClass([
            'disabled' => function (FormBlock $form_block) {
                return $form_block->isDisabled();
            }
        ]);
        $this->withAttribute('disabled', function (FormBlock $form_block) {
            if ($form_block->getHtmlElementName() == 'fieldset') {
                return $form_block->isDisabled();
            }
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
     * @return bool true if the block is considered disabled
     */
    public function isDisabled()
    {
        return (bool)$this->evaluate($this->disabled);
    }

    /* TODO: implement these methods on FormBlock:
    ->readonly(true)
    ->required(true)

    ->getDescriptionElement()
    ->withDescription(text)

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