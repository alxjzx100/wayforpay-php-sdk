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

namespace WayForPay\SDK\Domain;

use DateTime;

class Avia
{
    /**
     * @var string
     */
    private string $departureDate;

    /**
     * @var string
     */
    private string $locationNumber;

    /**
     * @var string
     */
    private string $locationCodes;

    /**
     * @var string
     */
    private string $nameFirst;

    /**
     * @var string
     */
    private string $nameLast;

    /**
     * @var string
     */
    private string $reservationCode;

    public function __construct(
        ?DateTime $departureDate = null,
        $locationNumber = null,
        $locationCodes = null,
        $nameFirst = null,
        $nameLast = null,
        $reservationCode = null
    ) {
        $this->departureDate = $departureDate;
        $this->locationNumber = (string)$locationNumber;
        $this->locationCodes = (string)$locationCodes;
        $this->nameFirst = (string)$nameFirst;
        $this->nameLast = (string)$nameLast;
        $this->reservationCode = (string)$reservationCode;
    }

    public function getDepartureDate(): DateTime|string|null
    {
        return $this->departureDate;
    }

    /**
     * @return string
     */
    public function getLocationNumber(): string
    {
        return $this->locationNumber;
    }

    /**
     * @return string
     */
    public function getLocationCodes(): string
    {
        return $this->locationCodes;
    }

    /**
     * @return string
     */
    public function getNameFirst(): string
    {
        return $this->nameFirst;
    }

    /**
     * @return string
     */
    public function getNameLast(): string
    {
        return $this->nameLast;
    }

    /**
     * @return string
     */
    public function getReservationCode(): string
    {
        return $this->reservationCode;
    }
}