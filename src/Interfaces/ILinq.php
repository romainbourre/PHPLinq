<?php


namespace PhpLinq\Interfaces
{


    use PhpLinq\Exceptions\InvalidQueryResultException;
    use Closure;

    interface ILinq extends ICollection
    {
        /**
         * Determines whether all elements of a sequence satisfy a condition
         * @param Closure $closure
         * @return bool
         */
        public function all(Closure $closure): bool;

        /**
         * Determines whether any element of a sequence exists or satisfies a condition.
         * @param Closure|null $closure
         * @return bool
         */
        public function any(Closure $closure = null): bool;

        /**
         * Returns distinct elements from a sequence.
         * @param Closure|null $closure
         * @return ILinq
         */
        public function distinct(Closure $closure = null): ILinq;

        /**
         * Returns the first element of a sequence.
         * @param Closure|null $closure
         * @return mixed
         * @throws InvalidQueryResultException
         */
        public function first(Closure $closure = null): mixed;

        /**
         * Execute function for each item of list
         * @param Closure $closure
         */
        public function forEach(Closure $closure): void;

        /**
         * Returns the first element of a sequence, or a null value if no element is found.
         * @param Closure|null $closure
         * @return mixed
         */
        public function firstOrNull(Closure $closure = null): mixed;

        /**
         * Group elements of array by selector
         * @param Closure $keySelector
         * @param Closure|null $target
         * @return ILinq
         * @throws InvalidQueryResultException
         */
        public function groupBy(Closure $keySelector, Closure $target = null): ILinq;

        /**
         * @param ILinq $list
         * @return ILinq<mixed>
         */
        public function join(ILinq $list): ILinq;

        /**
         * Return the last element of a sequence.
         * @param Closure|null $closure
         * @return mixed
         * @throws InvalidQueryResultException
         */
        public function last(Closure $closure = null): mixed;

        /**
         * Return the last element of a sequence, or a null value if no element is found.
         * @param Closure|null $closure
         * @return mixed
         */
        public function lastOrNull(Closure $closure = null): mixed;

        /**
         * Sort the elements of list by the given selector.
         * If no selector is given, the list will be sorted by the default sort function.
         * @param ?Closure $closure
         * @return ILinq
         */
        public function orderBy(?Closure $closure = null): ILinq;

        /**
         * Projects each element of a sequence into a new form.
         * @param Closure $closure
         * @return ILinq
         */
        public function select(Closure $closure): ILinq;

        /**
         * Projects each element of a sequence to an LinqCollection<T>
         * and flattens the resulting sequences into one sequence.
         * @param Closure $closure
         * @return ILinq
         */
        public function selectMany(Closure $closure): ILinq;

        /**
         * Returns a single, specific element of a sequence.
         * @param Closure|null $closure
         * @return mixed
         * @throws InvalidQueryResultException
         */
        public function single(Closure $closure = null): mixed;

        /**
         * Returns a single, specific element of a sequence, or a null value if that element is not found.
         * @param Closure|null $closure
         * @return mixed
         * @throws InvalidQueryResultException
         */
        public function singleOrNull(Closure $closure = null): mixed;

        /**
         * Filters a sequence of values based on a predicate.
         * @param Closure $closure
         * @return ILinq
         */
        public function where(Closure $closure): ILinq;
    }
}
