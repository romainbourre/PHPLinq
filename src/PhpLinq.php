<?php


namespace PhpLinq
{
    use Closure;
    use PhpLinq\Exceptions\InvalidQueryResultException;
    use PhpLinq\Group\Group;
    use Interfaces\ICollection;
    use Interfaces\ListCollection;

    class PhpLinq extends ListCollection implements ILinq
    {
        /**
         * @inheritDoc
         */
        public final function all(Closure $closure): bool
        {
            foreach ($this as $elem)
            {
                if (!$closure($elem))
                {
                    return false;
                }
            }

            return true;
        }

        /**
         * @inheritDoc
         */
        public final function any(Closure $closure = null): bool
        {
            $closure = $closure ?? fn() => true;
            return $this->where($closure)->count() > 0;
        }

        /**
         * @inheritDoc
         */
        public final function distinct(Closure $closure = null): ILinq
        {
            $result = new PhpLinq();
            foreach ($this as $item)
            {
                if ($closure == null)
                {
                    if (!$result->contains($item))
                    {
                        $result->add($item);
                    }
                }
                else
                {
                    if (!$result->any(fn($i) => $closure($i) == $closure($item)))
                    {
                        $result->add($item);
                    }
                }
            }

            return $result;
        }

        /**
         * @inheritDoc
         */
        public final function first(Closure $closure = null)
        {
            if (($result = $this->firstOrNull($closure)) === null)
            {
                throw new InvalidQueryResultException("the first value cannot be null");
            }

            return $result;
        }

        /**
         * @inheritDoc
         */
        public final function firstOrNull(Closure $closure = null)
        {
            if ($closure == null)
            {
                $closure = fn($item) => true;
            }

            $items = $this->where($closure)->toArray();

            if (sizeof($items) == 0)
            {
                return null;
            }

            return $items[0];
        }

        /**
         * @inheritDoc
         */
        public final function forEach(Closure $closure): void
        {
            foreach ($this->items as $item)
            {
                $closure($item);
            }
        }

        /**
         * @inheritDoc
         */
        public final function groupBy(Closure $keySelector, Closure $target = null): ILinq
        {
            $groupList = new PhpLinq();

            foreach ($this->items as $item)
            {
                $key = $keySelector($item);
                $group = $groupList->singleOrNull(fn(Group $g) => $g->getKey() == $key);

                if ($group == null)
                {
                    $group = new Group($key);
                    $groupList->add($group);
                }

                $groupItem = is_null($target) ? $item : $target($item);
                $group->addItem($groupItem);
            }

            return $groupList;
        }

        /**
         * @inheritDoc
         */
        public function join(ILinq $list): ILinq
        {
            $merged = array_merge($this->items, $list->toArray());

            return PhpLinq::fromArray($merged);
        }

        /**
         * @inheritDoc
         */
        public final function last(Closure $closure = null)
        {
            if (($result = $this->lastOrNull($closure)) == null)
            {
                throw new InvalidQueryResultException("the last value cannot be null");
            }

            return $result;
        }

        /**
         * @inheritDoc
         */
        public final function lastOrNull(Closure $closure = null)
        {
            if ($closure == null)
            {
                $closure = fn($item) => true;
            }

            $filteredItems = $this->where($closure)->toArray();

            if (($result = end($filteredItems)) == false)
            {
                return null;
            }

            return $result;
        }

        /**
         * @inheritDoc
         */
        public final function select(Closure $closure): ILinq
        {
            return self::fromArray(array_map($closure, $this->toArray()));
        }

        /**
         * @inheritDoc
         */
        public final function selectMany(Closure $closure): ILinq
        {
            $result = [];
            $selected = $this->select($closure);
            foreach ($selected as $select)
            {
                if (is_iterable($select))
                {
                    $select = is_object($select) ? $select->toArray() : $select;
                    $result = array_merge($result, $select);
                    continue;
                }
                $result[] = $select;
            }

            return self::fromArray($result);
        }

        /**
         * @inheritDoc
         */
        public final function single(Closure $closure = null)
        {
            if (($result = $this->singleOrNull($closure)) == null)
            {
                throw new InvalidQueryResultException("single value can't be null");
            }

            return $result;
        }

        /**
         * @inheritDoc
         */
        public final function singleOrNull(Closure $closure = null)
        {
            if ($closure == null)
            {
                $closure = fn($item) => true;
            }

            $filteredItems = $this->where($closure);

            if ($filteredItems->count() > 1)
            {
                throw new InvalidQueryResultException("collection can't have more than single result");
            }

            if ($filteredItems->isEmpty())
            {
                return null;
            }

            $result = $filteredItems->toArray();

            return reset($result);
        }

        /**
         * @inheritDoc
         */
        public final function where(Closure $closure): ILinq
        {
            return self::fromArray(array_filter($this->items, $closure));
        }

        /**
         * @inheritDoc
         */
        public final static function fromArray(array $elements): ILinq
        {
            $collection = new PhpLinq();
            $collection->items = array_values($elements);
            return $collection;
        }

        /**
         * @inheritDoc
         */
        public final static function from(ICollection $collection): ILinq
        {
            $newCollection = new PhpLinq();
            $newCollection->items = array_values($collection->items);
            return $newCollection;
        }
    }
}
