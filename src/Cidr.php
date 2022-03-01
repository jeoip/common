<?php

namespace Jeoip\Common;

use Jeoip\Common\Exceptions\Exception;
use Jeoip\Contracts\ICidr;

class Cidr implements ICidr
{
    public static function parse(string $subnet): self
    {
        $parts = explode('/', $subnet);
        $count = count($parts);
        if (1 == $count) {
            throw new Exception('Cannot find prefix');
        }
        if ($count > 2) {
            throw new Exception('Subnet is melformed');
        }
        $prefix = intval($parts[1]);
        $network = $parts[0];

        return new self($network, $prefix);
    }

    /**
     * @param string|int $start
     * @param string|int $end
     */
    public static function fromRange($start, $end): self
    {
        if (!extension_loaded('gmp')) {
            throw new Exception("'gmp' extension is not available");
        }
        $startNumber = gmp_init($start);
        $end = gmp_init($end);
        $bits = max(strlen(gmp_strval($startNumber, 2)), strlen(gmp_strval($end, 2)));
        $bits = ($bits <= 32) ? 32 : 128;
        $diff = gmp_sub($end, $startNumber);
        $diff = gmp_strval($diff, 2);
        if (false !== strpos($diff, '1', 0)) {
            $diff = '1'.str_repeat('0', strlen($diff));
        }
        $prefix = $bits - strlen($diff) - 1;

        return new self(Utilities::decToIp(strval($start)), $prefix);
    }

    protected string $network;
    protected int $prefix;

    public function __construct(string $network, int $prefix)
    {
        $this->setNetwork($network);
        $this->setPrefix($prefix);
    }

    public function setNetwork(string $network): void
    {
        if (!filter_var($network, FILTER_VALIDATE_IP)) {
            throw new Exception('Network IP is invalid');
        }
        $this->network = $network;
    }

    public function getNetwork(): string
    {
        return $this->network;
    }

    public function setPrefix(int $prefix): void
    {
        $maxPrefix = Utilities::isIpv4($this->network) ? 32 : 128;
        if ($prefix < 0 or $prefix > $maxPrefix) {
            throw new Exception('Prefix is invalid. it must be between 0 - '.$maxPrefix);
        }
        $this->prefix = $prefix;
    }

    public function getPrefix(): int
    {
        return $this->prefix;
    }

    public function __toString(): string
    {
        return $this->network.'/'.$this->prefix;
    }
}
