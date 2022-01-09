<?php


namespace PhpLinq\Group;


use PhpLinq\Interfaces\IGroup;
use PhpLinq\Interfaces\ILinq;
use PhpLinq\PhpLinq;

class Group implements IGroup
{
    /**
     * @var mixed key of group
     */
    private mixed $key;

    /**
     * @var ILinq<mixed> list of items
     */
    private ILinq $items;

    /**
     * Group constructor.
     * @param mixed $key
     * @param ILinq<mixed> | null $items
     */
    public function __construct(mixed $key, ILinq $items = null)
    {
        $this->key = $key;
        $this->items = $items ?? new PhpLinq();
    }

    /**
     * @inheritDoc
     */
    public function getKey(): mixed
    {
        return $this->key;
    }

    /**
     * @inheritDoc
     */
    public function getItems(): ILinq
    {
        return $this->items;
    }

    /**
     * @inheritDoc
     */
    public function addItem(mixed $item): ILinq
    {
        $this->items->add($item);
        return $this->items;
    }
}