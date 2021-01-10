<?php


namespace PhpLinq\Group;


use App\Shared\LinqCollection\Interfaces\ILinq;
use App\Shared\LinqCollection\LinqCollection;

class Group implements IGroup
{
    /**
     * @var mixed key of group
     */
    private $key;

    /**
     * @var ILinq<mixed> list of items
     */
    private ILinq $items;

    /**
     * Group constructor.
     * @param mixed $key
     * @param ILinq<mixed> | null $items
     */
    public function __construct($key, ILinq $items = null)
    {
        $this->key = $key;
        $this->items = $items ?? new LinqCollection();
    }

    /**
     * @inheritDoc
     */
    public function getKey()
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
    public function addItem($item): ILinq
    {
        $this->items->add($item);
        return $this->items;
    }
}