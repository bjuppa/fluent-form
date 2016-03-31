<?php
namespace FewAgency\FluentForm\Support;

use FewAgency\FluentForm\AbstractControlBlock;
use FewAgency\FluentForm\ButtonBlock;
use FewAgency\FluentForm\InputBlock;
use FewAgency\FluentForm\SelectBlock;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;

trait ContainingBlocksTrait
{
    /**
     * Put an input block on the form and return it.
     * @param string $name
     * @param string $type
     * @return InputBlock
     */
    public function containingInputBlock($name, $type = 'text')
    {
        return $this->containingBlock($type, compact('name'));
    }

    /**
     * Put a password block on the form and return it.
     * @param string $name defaults to 'password'
     * @return InputBlock
     */
    public function containingPasswordBlock($name = 'password')
    {
        return $this->containingInputBlock($name, 'password');
    }

    /**
     * Put a select block on the form and return it.
     * @param string $name
     * @param mixed $options
     * @return SelectBlock
     */
    public function containingSelectBlock($name, $options = null)
    {
        return $this->containingBlock('Select', func_get_args());
    }

    /**
     * Put a multi-select block on the form and return it.
     * @param string $name
     * @param mixed $options
     * @return SelectBlock
     */
    public function containingMultiSelectBlock($name, $options = null)
    {
        return $this->containingBlock('Select', func_get_args())->multiple();
    }

    /**
     * Put a button block on the form and return it.
     * @param string|Htmlable|array|Arrayable $button_contents
     * @param string $type
     * @return ButtonBlock
     */
    public function containingButtonBlock($button_contents, $type = 'submit')
    {
        return $this->containingBlock('Button', func_get_args());
    }

    /**
     * Put a new control-block on the form and return it.
     * @param string $type
     * @param array $parameters
     * @return AbstractControlBlock
     */
    protected function containingBlock($type, $parameters = [])
    {
        $block = $this->createControlBlock($type, $parameters);
        $this->withContent($block);

        return $block;
    }
}