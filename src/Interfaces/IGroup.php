<?php


namespace PhpLinq\Interfaces
{


    interface IGroup
    {
        /**
         * Get key of group
         * @return mixed
         */
        public function getKey();

        /**
         * Get items list of group
         * @return ILinq<mixed>
         */
        public function getItems(): ILinq;

        /**
         * Add item to group
         * @param $item
         * @return ILinq<mixed>
         */
        public function addItem($item): ILinq;
    }
}