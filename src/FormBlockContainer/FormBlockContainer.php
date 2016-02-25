<?php
namespace FewAgency\FluentForm\FormBlockContainer;

use ArrayAccess;
use FewAgency\FluentHtml\FluentHtmlElement;
use FewAgency\FluentForm\Support\FormElementContract;
use FewAgency\FluentForm\Support\FormElement;
use FewAgency\FluentForm\FormBlock\InputBlock;
use FewAgency\FluentForm\FormBlock\ButtonBlock;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\MessageProvider;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

abstract class FormBlockContainer extends FluentHtmlElement implements FormElementContract
{
    use FormElement;

    protected $is_aligned;
    protected $alignment_classes;
    protected $alignment_classes_default = [1 => 'half-width float-left align-right', 2 => 'half-width', 3 => ''];
    protected $alignment_offset_classes;
    protected $alignment_offset_classes_default = [2 => 'half-width half-margin-left', 3 => ''];

    /**
     * The values and selected options for inputs in this level of the form.
     * @var Collection of arrays, objects or other key-value implementations, in order of preference
     */
    private $value_maps;

    /**
     * Error messages for this level of the form.
     * @var MessageBag
     */
    private $error_messages;

    public function __construct()
    {
        parent::__construct();
        $this->value_maps = new Collection();
        $this->error_messages = new MessageBag();
    }


    /**
     * Add a hidden input to the form
     * @param $name
     * @param $value
     * @return $this
     */
    public function withHiddenInput($name, $value)
    {
        $this->withContent($this->createInstanceOf('FormInput\HiddenInputElement', [$name, $value]));

        return $this;
    }

    /* TODO: implement these methods on FormBlockContainer
->withWarnings(messages)

->with…Block(name, type)
->with…Blocks(array of input names and types)

->withAlignmentClasses(col 1, col 2, col 3, offset 2, offset 3=null)
->getAlignmentClasses(column number, bool with_offset=false)
->align(true)
->isAligned()
     */

    /**
     * Put an input block on the form.
     * @param string $name
     * @param string $type
     * @return $this|FormBlockContainer
     */
    public function withInputBlock($name, $type = 'text')
    {
        $this->containingInputBlock($name, $type);

        return $this;
    }

    /**
     * Put an input block on the form and return it.
     * @param string $name
     * @param string $type
     * @return InputBlock
     */
    public function containingInputBlock($name, $type = 'text')
    {
        //TODO: check for $type.'Block' class first
        $block = $this->createInstanceOf('FormBlock\InputBlock', [$name, $type]);
        $this->withContent($block);

        return $block;
    }

    /**
     * Put a button block on the form.
     * @param string|Htmlable|array|Arrayable $tag_contents
     * @param string $type
     * @return $this|FormBlockContainer
     */
    public function withButtonBlock($tag_contents, $type = 'submit')
    {
        $this->containingButtonBlock($tag_contents, $type);

        return $this;
    }

    /**
     * Put a button block on the form and return it.
     * @param string|Htmlable|array|Arrayable $tag_contents
     * @param string $type
     * @return ButtonBlock
     */
    public function containingButtonBlock($tag_contents, $type = 'submit')
    {
        $block = $this->createInstanceOf('FormBlock\ButtonBlock', [$tag_contents, $type]);
        $this->withContent($block);

        return $block;
    }

    /**
     * Set a value container for populating inputs.
     * @param array|object|Arrayable $map key-value implementation
     * @return $this
     */
    public function withValues($map)
    {
        $this->value_maps->prepend($map);

        return $this;
    }

    /**
     * Get an input value or selected option.
     * @param string $key in dot-notation
     * @return mixed|null
     */
    public function getValue($key)
    {
        foreach ($this->value_maps as $map) {
            $value = $this->getValueFromMap(explode('.', $key), $map);
            if (isset($value)) {
                return $value;
            }
        }

        return $this->getValueFromAncestor($key);
    }

    /**
     * Get a value from a key value map.
     * @param array $key_parts containing one string for each level
     * @param array|object|ArrayAccess|Arrayable $map key-value implementation
     * @return mixed|null
     */
    protected static function getValueFromMap($key_parts, $map)
    {
        $original_key_parts = $key_parts;
        $key = array_shift($key_parts);
        $value = null;
        if (is_object($map) and isset($map->$key)) {
            $value = $map->$key;
        } elseif ((is_array($map) or $map instanceof ArrayAccess) and isset($map[$key])) {
            $value = $map[$key];
        } elseif ($map instanceof Arrayable) {
            return self::getValueFromMap($original_key_parts, $map->toArray());
        }
        if (count($key_parts)) {
            return self::getValueFromMap($key_parts, $value);
        }

        return $value;
    }

    /**
     * Merge a new array of messages into the error messages.
     *
     * @param  MessageProvider|array $messages keyed by fieldname
     * @return $this
     */
    public function withErrors($messages)
    {
        if ($messages instanceof ViewErrorBag) {
            $messages = $messages->getMessageBag();
        }
        $this->error_messages->merge($messages);

        return $this;
    }

    /**
     * Get the error messages for a field.
     *
     * @param string $key
     * @return array of message strings
     */
    public function getErrors($key)
    {
        return array_merge($this->error_messages->get($key), $this->getErrorsFromAncestor($key));
    }
}