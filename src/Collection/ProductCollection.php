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

use Collections\Vector as ArrayList;
use WayForPay\SDK\Contract\SignatureAbleInterface;
use WayForPay\SDK\Domain\Product;

class ProductCollection extends ArrayList implements SignatureAbleInterface
{
    public function add($item)
    {
        if (!$item instanceof Product) {
            throw new \InvalidArgumentException('Expect Product, got ' . get_class($item));
        }

        return parent::add($item);
    }


    public function getConcatenatedString($delimiter)
    {
        return implode($delimiter, $this->getNames()) . $delimiter .
            implode($delimiter, $this->getCounts()) . $delimiter .
            implode($delimiter, $this->getPrices());
    }


    public function getNames()
    {
        return $this->map(function (Product $product) {
            return $product->getName();
        })->values();
    }


    public function getCounts()
    {
        return $this->map(function (Product $product) {
            return $product->getCount();
        })->values();
    }


    public function getPrices()
    {
        return $this->map(function (Product $product) {
            return $product->getPrice();
        })->values();
    }

    public function __serialize(): array
    {
        // Store the collection items
        return [
            'items' => $this->toArray()
        ];
    }

    public function __unserialize(array $data): void
    {
        // Restore items to the collection
        if (isset($data['items']) && is_array($data['items'])) {
            foreach ($data['items'] as $item) {
                $this->add($item);
            }
        }
    }

}