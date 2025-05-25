<?php
/*
 * This file is part of the WayForPay project.
 *
 * @link https://github.com/wayforpay/php-sdk
 *
 * @author Vladislav Lyshenko <vladdnepr1989@gmail.com>
 * @copyright Copyright 2019 WayForPay
 * @license   https://opensource.org/licenses/MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WayForPay\SDK\Collection;

use WayForPay\SDK\Contract\SignatureAbleInterface;
use WayForPay\SDK\Domain\Product;

class ProductCollection implements SignatureAbleInterface, \Countable, \IteratorAggregate, \ArrayAccess
{
    /**
     * @var Product[]
     */
    private array $items = [];

    /**
     * Constructor to initialize with optional items
     *
     * @param Product[] $items
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    /**
     * Add an item to the collection
     *
     * @param Product $item
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function add($item)
    {
        if (!$item instanceof Product) {
            throw new \InvalidArgumentException('Expect Product, got ' . get_class($item));
        }

        $this->items[] = $item;
        return $this;
    }

    /**
     * Get the concatenated string as required by SignatureAbleInterface
     *
     * @param string $delimiter
     * @return string
     */
    public function getConcatenatedString($delimiter)
    {
        return implode($delimiter, $this->getNames()) . $delimiter .
            implode($delimiter, $this->getCounts()) . $delimiter .
            implode($delimiter, $this->getPrices());
    }

    /**
     * Get all product names
     *
     * @return string[]
     */
    public function getNames()
    {
        return array_map(function (Product $product) {
            return $product->getName();
        }, $this->items);
    }

    /**
     * Get all product counts
     *
     * @return int[]
     */
    public function getCounts()
    {
        return array_map(function (Product $product) {
            return $product->getCount();
        }, $this->items);
    }

    /**
     * Get all product prices
     *
     * @return float[]
     */
    public function getPrices()
    {
        return array_map(function (Product $product) {
            return $product->getPrice();
        }, $this->items);
    }

    /**
     * Map a function to each item in the collection
     *
     * @param callable $callback
     * @return array
     */
    public function map(callable $callback)
    {
        return array_map($callback, $this->items);
    }

    /**
     * Convert collection to array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->items;
    }

    /**
     * Implement Countable interface
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * Implement IteratorAggregate interface
     *
     * @return \ArrayIterator
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }

    /**
     * Check if offset exists
     *
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->items[$offset]);
    }

    /**
     * Get item at offset
     *
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset): mixed
    {
        return $this->items[$offset] ?? null;
    }

    /**
     * Set item at offset
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        if (!$value instanceof Product) {
            throw new \InvalidArgumentException('Expect Product, got ' . get_class($value));
        }

        if ($offset === null) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    /**
     * Unset item at offset
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset): void
    {
        unset($this->items[$offset]);
    }

    /**
     * Serialize the collection
     *
     * @return array
     */
    public function __serialize(): array
    {
        return [
            'items' => $this->items
        ];
    }

    /**
     * Unserialize the collection
     *
     * @param array $data
     */
    public function __unserialize(array $data): void
    {
        if (isset($data['items']) && is_array($data['items'])) {
            $this->items = [];
            foreach ($data['items'] as $item) {
                $this->add($item);
            }
        }
    }
}