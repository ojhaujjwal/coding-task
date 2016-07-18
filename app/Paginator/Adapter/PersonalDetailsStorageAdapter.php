<?php

namespace App\Paginator\Adapter;

use App\Services\PersonalDetailsStorage;
use Pagerfanta\Adapter\AdapterInterface;

class PersonalDetailsStorageAdapter implements AdapterInterface
{
    /**
     * @var PersonalDetailsStorage
     */
    private $storage;

    /**
     * Constructor.
     *
     * @param PersonalDetailsStorage $storage
     */
    public function __construct(PersonalDetailsStorage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Returns the number of results.
     *
     * @return int The number of results.
     */
    public function getNbResults()
    {
        return count($this->storage);
    }

    /**
     * Returns an slice of the results.
     *
     * @param int $offset The offset.
     * @param int $length The length.
     *
     * @return array The slice.
     */
    public function getSlice($offset, $length)
    {
        return iterator_to_array($this->storage->getSlice($offset, $length));
    }
}
