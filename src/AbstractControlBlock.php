<?php
namespace FewAgency\FluentForm;

use FewAgency\FluentForm\Support\FormElementContract;
use FewAgency\FluentForm\Support\FormElementTrait;
use FewAgency\FluentHtml\FluentHtmlElement;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;

abstract class AbstractControlBlock extends FluentHtmlElement implements FormElementContract
{
    use FormElementTrait;

    /**
     * @var string representing name or key for the main input of this block
     */
    private $input_name;

    /**
     * @var AbstractLabel
     */
    private $label_element;

    /**
     * @var DescriptionElement
     */
    private $description_element;

    /**
     * @var bool true if the description element of this block has been pulled out for display elsewehere
     */
    private $is_description_element_pulled = false;

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
     * @var bool|callable indicating if the block has success state
     */
    private $has_success;

    /**
     * @var bool|callable indicating if the block's inputs are disabled
     */
    private $is_disabled;

    /**
     * @var bool|callable indicating if the block's inputs are readonly
     */
    private $is_readonly;

    /**
     * @var bool|callable indicating if the block's inputs are required
     */
    private $is_required;

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
        $this->withHtmlElementName(function () {
            return $this->isInline() ? 'span' : 'div';
        });
        $this->errors = new Collection();
        $this->warnings = new Collection();
        $this->alignment_elements = [
            //label holder
            $this->createFluentHtmlElement(function () {
                return $this->isAligned() || $this->isInline() ? 'span' : 'div';
            })->withContent(function () {
                return $this->getLabelElement();
            })->withClass(function () {
                return $this->getAlignmentClasses(1);
            }),
            //input holder
            $this->createFluentHtmlElement(function () {
                return $this->isAligned() || $this->isInline() ? 'span' : 'div';
            })->withClass(function () {
                return $this->getAlignmentClasses(2);
            }),
            //description
            function () {
                return $this->isDescriptionPulled() ? null : $this->getDescriptionElement();
            },
        ];
        $this->withContent($this->alignment_elements);
        $this->withClass([
            $this->form_block_class,
            $this->form_block_aligned_class => function () {
                return $this->isAligned();
            },
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
     * @return $this
     */
    public function withLabel($html_contents)
    {
        $this->getLabelElement()->withContent(func_get_args());

        return $this;
    }

    /**
     * Get the label element of the block.
     * @return AbstractLabel
     */
    public function getLabelElement()
    {
        return $this->label_element;
    }

    /**
     * Set the label element of the block.
     * @param AbstractLabel $label_element
     * @return $this
     */
    protected function withLabelElement(AbstractLabel $label_element)
    {
        $label_element->withClass($this->form_block_label_class);
        $this->label_element = $label_element;

        return $this;
    }

    /**
     * Add description content.
     * @param string|Htmlable|callable|array|Arrayable $html_contents,...
     * @return $this
     */
    public function withDescription($html_contents)
    {
        $this->getDescriptionElement()->withContent(func_get_args());

        return $this;
    }

    /**
     * Get the description element of the block.
     * @return DescriptionElement
     */
    public function getDescriptionElement()
    {
        if (!$this->description_element) {
            $this->description_element = $this->createInstanceOf('DescriptionElement')
                ->withClass($this->form_block_description_class)
                ->withClass(function () {
                    return $this->getAlignmentClasses(3);
                })
                ->withContent(function () {
                    return $this->generateErrorListElement();
                })
                ->withContent(function () {
                    return $this->generateWarningListElement();
                });
        }

        return $this->description_element;
    }

    /**
     * Pull the description out of this form block to place it somewhere else.
     * @return DescriptionElement
     */
    public function pullDescriptionElement()
    {
        $this->is_description_element_pulled = true;

        return $this->getDescriptionElement();
    }

    /**
     * Check if the description element has been placed outside this form-block
     * @return bool
     */
    public function isDescriptionPulled()
    {
        return $this->is_description_element_pulled;
    }

    /**
     * Put an input block after this block and return it.
     * @param $name
     * @param string $type
     * @return InputBlock
     */
    public function followedByInputBlock($name, $type = 'text')
    {
        return $this->followedByBlock($type, compact('name'));
    }

    /**
     * Put a password block after this block and return it.
     * @param string $name defaults to 'password'
     * @return InputBlock
     */
    public function followedByPasswordBlock($name = 'password')
    {
        return $this->followedByInputBlock($name, 'password');
    }

    /**
     * Put a button block after this block and return it.
     * @param string|Htmlable|array|Arrayable $button_contents
     * @param string $type
     * @return ButtonBlock
     */
    public function followedByButtonBlock($button_contents, $type = 'submit')
    {
        return $this->followedByBlock('Button', func_get_args());
    }

    /**
     * Put a new fieldset form block container after this block and return it.
     * @return FieldsetElement
     */
    public function followedByFieldset()
    {
        $fieldset = $this->createInstanceOf('FieldsetElement');
        $this->followedBy($fieldset);

        return $fieldset;
    }

    /**
     * Make the input(s) in the block disabled.
     * @param bool|callable $disabled
     * @return $this
     */
    public function disabled($disabled = true)
    {
        $this->is_disabled = $disabled;

        return $this;
    }

    /**
     * Check if the block is disabled
     * @return bool true if the block is considered disabled
     */
    public function isDisabled()
    {
        $disabled = $this->evaluate($this->is_disabled);
        if (!isset($disabled)) {
            $disabled = $this->isDisabledFromAncestor($this->getInputName());
        }

        return (bool)$disabled;
    }

    /**
     * Make the input(s) in the block readonly
     * @param bool|callable $readonly
     * @return $this
     */
    public function readonly($readonly = true)
    {
        $this->is_readonly = $readonly;

        return $this;
    }

    /**
     * Check if the block is readonly.
     * @return bool true if the block's items is considered readonly
     */
    public function isReadonly()
    {
        $readonly = $this->evaluate($this->is_readonly);
        if (!isset($readonly)) {
            $readonly = $this->isReadonlyFromAncestor($this->getInputName());
        }

        return (bool)$readonly;
    }

    /**
     * Make the input in the block required.
     * @param bool|callable $required
     * @return $this
     */
    public function required($required = true)
    {
        $this->is_required = $required;

        return $this;
    }

    /**
     * Check if the block is required.
     * @return bool true if the block is considered required
     */
    public function isRequired()
    {
        $required = $this->evaluate($this->is_required);
        if (!isset($required)) {
            $required = $this->isRequiredFromAncestor($this->getInputName());
        }

        return (bool)$required;
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
     * Add warning message(s) to this block.
     * @param string|array|Arrayable $messages
     * @return $this
     */
    public function withWarning($messages)
    {
        $this->warnings = $this->warnings->merge($messages);

        return $this;
    }

    /**
     * Get all combined warning messages for this block.
     * @return array
     */
    protected function getWarningMessages()
    {
        return $this->warnings->merge($this->getWarningsFromAncestor($this->getInputName()))
            ->transform(function ($message) {
                return trim($message);
            })->filter(function ($message) {
                //Filter out empty strings and booleans
                return isset($message) and !is_bool($message) and '' !== $message;
            })->unique()->toArray();
    }

    /**
     * Find out if this form block has any warnings.
     * @return bool
     */
    public function hasWarning()
    {
        return (bool)count($this->getWarningMessages());
    }

    /**
     * Generate a html list of warning messages for this block.
     * @return FluentHtmlElement
     */
    protected function generateWarningListElement()
    {
        return $this->createFluentHtmlElement('ul')->onlyDisplayedIfHasContent()
            ->withClass($this->form_block_messages_class)
            ->withClass($this->form_block_warning_messages_class)
            ->withContentWrappedIn($this->getWarningMessages(), 'li');
    }

    /**
     * Set success state on the input block.
     * @param bool|callable $has_success
     * @return $this
     */
    public function withSuccess($has_success = true)
    {
        $this->has_success = $has_success;

        return $this;
    }

    /**
     * Find out if this form block is in the success state.
     * @return bool
     */
    public function hasSuccess()
    {
        $success = $this->evaluate($this->has_success);
        if (!isset($success)) {
            $success = $this->hasSuccessFromAncestor($this->getInputName());
        }

        return (bool)$success;
    }

    /**
     * Get the holder/wrapper elements for parts of this form block.
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
        } elseif ($this->hasWarning()) {
            return $this->form_block_warning_class;
        } elseif ($this->hasSuccess()) {
            return $this->form_block_success_class;
        } else {
            return null;
        }
    }

    /**
     * Put a new control-block after this block and return it.
     * @param string $type
     * @param array $parameters
     * @return AbstractControlBlock
     */
    protected function followedByBlock($type, $parameters = [])
    {
        $block = $this->getFormBlockContainer()->createControlBlock($type, $parameters);
        $this->followedBy($block);

        return $block;
    }

    /**
     * Get the alignment classes for an alignment element.
     * @param $number 1: label, 2: input, or 3: description
     * @param bool $with_offset Switch to include offset classes (if preceding element was left blank)
     * @return array of class names
     */
    public function getAlignmentClasses($number, $with_offset = false)
    {
        //TODO: remove with_offset as parameter and forward it only if the previous alignment element won't display in html
        return $this->isAligned() ? $this->getFormBlockContainer()->getAlignmentClasses($number, $with_offset) : [];
    }

}