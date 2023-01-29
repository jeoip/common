<?php

namespace Jeoip\Common;

use Jeoip\Common\Exceptions\Exception;
use Jeoip\Contracts\ICidr;
use Jeoip\Contracts\ILocation;

class Location implements ILocation
{
    protected string $query;
    protected string $countryCode;
    protected ICidr $subnet;

    public function __construct(string $query, string $countryCode, ICidr $subnet)
    {
        $this->setQuery($query);
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

    public function setQuery(string $query): void
    {
        $this->query = $query;
    }

    public function getQuery(): string
    {
        return $this->query;
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
     * @return array{qurey:string,countryCode:string,subnet:string}
     */
    public function jsonSerialize(): array
    {
        return [
            'query' => $this->query,
            'countryCode' => $this->countryCode,
            'subnet' => $this->subnet->__toString(),
        ];
    }
}
