<?php

namespace Jeoip\Common;

use Jeoip\Common\Exceptions\Exception;
use Jeoip\Contracts\ICidr;
use Jeoip\Contracts\ILocation;

class Location implements ILocation
{
    protected string $countryCode;
    protected ICidr $subnet;

    public function __construct(string $countryCode, ICidr $subnet)
    {
        $this->setCountryCode($countryCode);
        $this->setSubnet($subnet);
    }

    public function setCountryCode(string $countryCode): void
    {
        if (2 != strlen($countryCode)) {
            throw new Exception('countryCode must be ISO 3166‑1');
        }
        $this->countryCode = $countryCode;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function setSubnet(ICidr $subnet): void
    {
        $this->subnet = $subnet;
    }

    public function getSubnet(): ICidr
    {
        return $this->subnet;
    }

    /**
     * @return array{countryCode:string,subnet:string}
     */
    public function jsonSerialize(): array
    {
        return [
            'countryCode' => $this->countryCode,
            'subnet' => $this->subnet->__toString(),
        ];
    }
}
