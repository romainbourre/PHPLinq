<?php

namespace PhpLinq\Collections
{

    use Iterator;
    use JetBrains\PhpStorm\Pure;
    use PhpLinq\Interfaces\ICollection;

    class ListCollection implements Iterator, ICollection
    {
        /**
         * @var array
         */
        protected array $items;

        /**
         * @var int
         */
        private int $position;

        public function __construct(array $items = [])
        {
            $this->position = 0;
            $this->items = array_values($items);
        }

        /**
         * @inheritDoc
         */
        public function current(): mixed
        {
            return $this->items[$this->position];
        }

        /**
         * @inheritDoc
         */
        public function next(): void
        {
            $this->position = ++$this->position;
        }

        /**
         * @inheritDoc
         */
        public function key(): int
        {
            return $this->position;
        }

        /**
         * @inheritDoc
         */
        public function valid(): bool
        {
            return isset($this->items[$this->position]);
        }

        /**
         * @inheritDoc
         */
        public function rewind(): void
        {
            $this->position = 0;
        }

        /**
         * @inheritDoc
         */
        public function add(mixed $element): bool
        {
            $this->items[] = $element;

            return true;
        }

        /**
         * @inheritDoc
         */
        public function addAll(ICollection $collection): bool
        {
            array_merge($this->items, $collection->toArray());

            return true;
        }

        /**
         * @inheritDoc
         */
        public function clear(): void
        {
            $this->items = array();
            $this->position = 0;
        }

        /**
         * @inheritDoc
         */
        public function contains(mixed $element): bool
        {
            return in_array($element, $this->items, true);
        }

        /**
         * @inheritDoc
         */
        public function count(): int
        {
            return sizeof($this->items);
        }

        /**
         * @inheritDoc
         */
        public function get(int $key): mixed
        {
            return $this->items[$key];
        }

        /**
         * @inheritDoc
         */
        public function isEmpty(): bool
        {
            return sizeof($this->items) <= 0;
        }

        /**
         * @inheritDoc
         */
        public function remove(mixed $element): bool
        {
            $key = array_search($element, $this->items, true);

            if ($key == false)
            {
                return false;
            }

            unset($this->items[$key]);

            return true;
        }

        /**
         * @inheritDoc
         */
        public function removeAll(ICollection $elements): bool
        {
            $result = false;

            foreach ($elements as $element)
            {
                if ($this->remove($element))
                {
                    $result = true;
                }
            }

            return $result;
        }

        /**
         * @inheritDoc
         */
        public function toArray(): array
        {
            return $this->items;
        }

        /**
         * Create ListCollection from an array.
         * @param array $elements
         * @return ICollection
         */
        #[Pure]
        public static function fromArray(array $elements): ICollection
        {
            $collection = new ListCollection();
            $collection->items = array_values($elements);
            return $collection;
        }

        /**
         * Create ListCollection from another collection.
         * @param ICollection $collection
         * @return ICollection
         */
        #[Pure]
        public static function from(ICollection $collection): ICollection
        {
            $newCollection = new ListCollection();
            $newCollection->items = array_values($collection->items);
            return $newCollection;
        }
    }
}