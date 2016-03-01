<?php
namespace FewAgency\FluentForm\FormBlock;

use FewAgency\FluentForm\FormLabel\FormLabel;
use FewAgency\FluentForm\Support\FormElementContract;
use FewAgency\FluentForm\Support\FormElement;
use FewAgency\FluentHtml\FluentHtmlElement;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;


abstract class FormBlock extends FluentHtmlElement implements FormElementContract
{
    use FormElement;

    /**
     * @var string representing name or key for the main input of this block
     */
    private $input_name;

    /**
     * @var FormLabel
     */
    private $label_element;

    /**
     * @var FluentHtmlElement
     */
    private $description_element;

    /**
     * @var array of elements for alignment within the block, e.g. label holder, input holder, description holder
     */
    private $alignment_elements = [];

    /**
     * @var Collection of error messages for this input block
     */
    private $errors;

    /**
     * @var Collection of warning messages for this input block
     */
    private $warnings;

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
     * @var string css class name to put on all form blocks
     */
    private $form_block_class = 'form-block';

    /**
     * @var string css class name for labels in form blocks
     */
    private $form_block_label_class = 'form-block__label';

    /**
     * @var string css class name for labels in form blocks
     */
    private $form_block_description_class = 'form-block__description';

    /**
     * @var string css class name for message lists in form blocks
     */
    private $form_block_messages_class = 'form-block__messages';

    /**
     * @var string css class name for error message lists in form blocks
     */
    private $form_block_error_messages_class = 'form-block__messages--error';

    /**
     * @var string css class name for warning message lists in form blocks
     */
    private $form_block_warning_messages_class = 'form-block__messages--warning';

    /**
     * @var string css class name to put on aligned form blocks
     */
    private $form_block_aligned_class = 'form-block--aligned';

    /**
     * @var string css class name to put on disabled form blocks
     */
    private $form_block_disabled_class = 'form-block--disabled';

    /**
     * @var string css class name to put on required form blocks
     */
    private $form_block_required_class = 'form-block--required';

    /**
     * @var string css class name to put on form blocks with error
     */
    private $form_block_error_class = 'form-block--error';

    /**
     * @var string css class name to put on form blocks with warning
     */
    private $form_block_warning_class = 'form-block--warning';

    /**
     * @var string css class name to put on form blocks with success
     */
    private $form_block_success_class = 'form-block--success';

    public function __construct()
    {
        parent::__construct();
        $this->withHtmlElementName('div');
        $this->errors = new Collection();
        $this->warnings = new Collection();
        $this->alignment_elements = [
            //label holder
            $this->createFluentHtmlElement('div')
                ->withContent(function () {
                    return $this->getLabelElement();
                }),
            //input holder
            $this->createFluentHtmlElement('div'),
            //description holder
            $this->createFluentHtmlElement('div')
                ->onlyDisplayedIfHasContent()
                ->withContent(function () {
                    return $this->getDescriptionElement();
                }),
        ];
        $this->withContent($this->alignment_elements);
        $this->getDescriptionElement()->withContent(function () {
            return $this->generateErrorListElement();
        });
        $this->withClass([
            $this->form_block_class,
            $this->form_block_disabled_class => function () {
                return $this->isDisabled();
            },
            $this->form_block_required_class => function () {
                return $this->isRequired();
            },
            function () {
                return $this->getStateClass();
            }
        ]);
        $this->withAttribute('disabled', function () {
            return $this->isDisabled() and $this->getHtmlElementName() == 'fieldset';
        });
    }

    /**
     * Add label content.
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
        $label_element->withClass($this->form_block_label_class);
        $this->label_element = $label_element;

        return $this;
    }

    /**
     * Add description content.
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
            $this->description_element = $this->createFluentHtmlElement('div')->onlyDisplayedIfHasContent();
            $this->description_element->withClass($this->form_block_description_class);
        }

        return $this->description_element;
    }

    /**
     * Put an input block after this block.
     * @param $name
     * @param string $type
     * @return InputBlock
     */
    public function followedByInputBlock($name, $type = 'text')
    {
        return $this->getFormBlockContainer()->containingInputBlock($name, $type);
    }

    /**
     * Put a password block after this block.
     * @param string $name
     * @return InputBlock
     */
    public function followedByPasswordBlock($name = 'password')
    {
        return $this->getFormBlockContainer()->containingPasswordBlock($name);
    }

    /**
     * Put a button block after this block.
     * @param string|Htmlable|array|Arrayable $tag_contents
     * @param string $type
     * @return ButtonBlock
     */
    public function followedByButtonBlock($tag_contents, $type = 'submit')
    {
        return $this->getFormBlockContainer()->containingButtonBlock($tag_contents, $type);
    }

    /**
     * Make the input(s) in the block disabled.
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
     * Check if the block is readonly.
     * @return bool true if the block's items is considered readonly
     */
    public function isReadonly()
    {
        return (bool)$this->evaluate($this->readonly);
    }

    /**
     * Make the input in the block required.
     * @param bool|callable $required
     * @return $this
     */
    public function required($required = true)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * Check if the block is required.
     * @return bool true if the block is considered required
     */
    public function isRequired()
    {
        return (bool)$this->evaluate($this->required);
    }

    /**
     * Set name of main input for this block.
     * @param string $name
     * @return $this
     */
    public function withInputName($name)
    {
        $this->input_name = $name;

        return $this;
    }

    /**
     * Get the name of the main input of this block.
     * @return string
     */
    public function getInputName()
    {
        return $this->input_name;
    }

    /**
     * Add error message(s) to this block.
     * @param string|array|Arrayable $messages
     * @return $this
     */
    public function withError($messages)
    {
        $this->errors = $this->errors->merge($messages);

        return $this;
    }

    /**
     * Get all combined error messages for this block.
     * @return array
     */
    protected function getErrorMessages()
    {
        return $this->errors->merge($this->getErrorsFromAncestor($this->getInputName()))
            ->transform(function ($message) {
                return trim($message);
            })->filter(function ($message) {
                //Filter out empty strings and booleans
                return isset($message) and !is_bool($message) and '' !== $message;
            })->unique()->toArray();
    }

    /**
     * Find out if this form block has any errors.
     * @return bool
     */
    public function hasError()
    {
        return (bool)count($this->getErrorMessages());
    }

    /**
     * Generate a html list of error messages for this block.
     * @return FluentHtmlElement
     */
    protected function generateErrorListElement()
    {
        return $this->createFluentHtmlElement('ul')->onlyDisplayedIfHasContent()
            ->withClass($this->form_block_messages_class)
            ->withClass($this->form_block_error_messages_class)
            ->withContentWrappedIn($this->getErrorMessages(), 'li');
    }

    /**
     * @param $number 1: label, 2: input, or 3: description
     * @return FluentHtmlElement
     */
    protected function getAlignmentElement($number)
    {
        return $this->alignment_elements[$number - 1];
    }

    /**
     * Get the css class representing the state of this block.
     * @return null|string
     */
    protected function getStateClass()
    {
        if ($this->hasError()) {
            return $this->form_block_error_class;
        } else {
            return null;
        }
    }

    /* TODO: implement these methods on FormBlock:
    ->withWarning(messages)
    ->withSuccess(true)
    ->withFeedback(html) - should this be in twbs-form only?

    ->getAlignmentClasses(column number, bool with_offset=false)

    ->followedBy…Block()
     */

}