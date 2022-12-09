<?php

/*
 * This file is part of blomstra/trello-php.
 *
 * Copyright (c) 2022 Blomstra Ltd.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Trello\Models;

use ArrayAccess;
use Countable;
use InvalidArgumentException;
use Iterator;
use Trello\Client;

abstract class BaseObject implements ArrayAccess, Countable, Iterator
{
    protected $_client;
    protected $_model;

    private $_position = 0;
    protected $_data;

    public function __construct(Client $client, array $data = [])
    {
        $this->_client = $client;
        $this->_data = $data;
    }

    /**
     * Save an object.
     *
     * @return BaseObject
     */
    public function save()
    {
        if ($this->getId()) {
            return $this->update();
        }

        $response = $this->getClient()->post($this->getModel().'/'.$this->getId(), $this->toArray());

        $child = get_class($this);

        return new $child($this->getClient(), $response);
    }

    /**
     * @return mixed
     */
    public function update()
    {
        if (!$this->getId()) {
            throw new InvalidArgumentException('There is no ID set for this object - Please call setId before calling update');
        }

        $response = $this->getClient()->put($this->getModel().'/'.$this->getId(), $this->toArray());

        $child = get_class($this);

        return new $child($this->getClient(), $response);
    }

    /**
     * Get an item by id ($this->id).
     *
     * @throws InvalidArgumentException
     *
     * @return BaseObject
     */
    public function get()
    {
        if (!$this->getId()) {
            throw new InvalidArgumentException('There is no ID set for this object - Please call setId before calling get');
        }

        $child = get_class($this);
        $response = $this->getClient()->get($this->getModel().'/'.$this->getId());

        return new $child($this->getClient(), $response);
    }

    /**
     * Get relative data.
     *
     * @param string $path
     * @param array  $payload
     *
     * @return array
     */
    public function getPath($path, array $payload = []): array
    {
        return $this->getClient()->get($this->getModel().'/'.$this->getId().'/'.$path, $payload);
    }

    /**
     * Post relative data.
     *
     * @param string $path
     * @param array  $payload
     *
     * @return array
     */
    public function postPath($path, array $payload = []): array
    {
        return $this->getClient()->post($this->getModel().'/'.$this->getId().'/'.$path, $payload);
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->_model;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->_client;
    }

    /**
     * @param $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function __get($key)
    {
        return $this->offsetExists($key) ? $this->offsetGet($key) : null;
    }

    public function __set($key, $value)
    {
        $this->offsetSet($key, $value);
    }

    public function __isset($key)
    {
        return $this->offsetExists($key);
    }

    public function __unset($key)
    {
        return $this->offsetUnset($key);
    }

    public function toArray(): array
    {
        return $this->_data;
    }

    public function offsetSet($offset, $value): void
    {
        if ($offset === null) {
            $this->_data[] = $value;
        } else {
            $this->_data[$offset] = $value;
        }
    }

    public function offsetExists($offset): bool
    {
        return isset($this->_data[$offset]);
    }

    public function offsetUnset($offset): void
    {
        unset($this->_data[$offset]);
    }

    public function offsetGet($offset): mixed
    {
        return $this->_data[$offset] ?? null;
    }

    public function count(): int
    {
        return count($this->_data);
    }

    public function rewind(): void
    {
        $this->_position = 0;
    }

    public function current(): mixed
    {
        return $this->_data[$this->_position];
    }

    public function key(): mixed
    {
        return $this->_position;
    }

    public function next(): void
    {
        $this->_position++;
    }

    public function valid(): bool
    {
        return isset($this->_data[$this->_position]);
    }
}
