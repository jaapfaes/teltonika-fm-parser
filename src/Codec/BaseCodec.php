<?php 

namespace Uro\TeltonikaFmParser\Codec;

use Uro\TeltonikaFmParser\Exception\CrcMismatchException;
use Uro\TeltonikaFmParser\Io\Reader;
use Uro\TeltonikaFmParser\Model\Codec8\AvlData;
use Uro\TeltonikaFmParser\Model\Codec8\GpsElement;
use Uro\TeltonikaFmParser\Model\Codec8\AvlDataCollection;
use Uro\TeltonikaFmParser\Exception\NumberOfDataMismatchException;
use Uro\TeltonikaFmParser\Model\Codec8\Packet;
use Uro\TeltonikaFmParser\Support\Crc16;

abstract class BaseCodec implements Codec
{
    protected $reader;

    /**
     * BaseCodec8 constructor.
     * @param $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
        $this->reader->setPosition(0);
    }

    abstract public function decode();

    public function checkCrc()
    {
        $this->reader->setPosition(0);

        $data = bin2hex($this->reader->getInputString());

        $input = substr($data,16, strlen($data) - 24);
        $input = hex2bin($input);

        $crc = substr($data,-4);

        return $crc == dechex((new Crc16)->calc($input));
    }
}