<?php
namespace FewAgency\FluentForm\Support;

use FewAgency\FluentForm\AbstractControlBlock;
use FewAgency\FluentForm\ButtonBlock;
use FewAgency\FluentForm\InputBlock;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;

trait FollowedByBlocksTrait
{
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
}