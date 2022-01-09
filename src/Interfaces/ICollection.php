<?php


namespace PhpLinq\Interfaces
{


    use Iterator;

    interface ICollection extends Iterator
    {
        /**
         * Ensures that this collection contains the specified element.
         * @param mixed $element
         * @return bool
         */
        public function add(mixed $element): bool;

        /**
         * Adds all the elements in the specified collection to this collection.
         * @param ICollection $collection
         * @return bool
         */
        public function addAll(ICollection $collection): bool;

        /**
         * Removes all the elements from this collection.
         */
        public function clear(): void;

        /**
         * Returns true if this collection contains the specified element.
         * @param $element
         * @return bool
         */
        public function contains($element): bool;

        /**
         * Returns the number of elements in this collection.
         * @return int
         */
        public function count(): int;

        /**
         * Return element with given index of this collection.
         * @param int $key
         * @return mixed|null
         */
        public function get(int $key): mixed;

        /**
         * Returns true if this collection contains no elements.
         * @return bool
         */
        public function isEmpty(): bool;

        /**
         * Removes a single instance of the specified element from this collection, if it is present.
         * @param mixed $element
         * @return bool
         */
        public function remove(mixed $element): bool;

        /**
         * Removes all of this collection's elements that are also contained in the specified collection.
         * @param ICollection $elements
         * @return bool
         */
        public function removeAll(ICollection $elements): bool ;

        /**
         * Returns an array containing all the elements in this collection.
         * @return array
         */
        public function toArray(): array;
    }
}