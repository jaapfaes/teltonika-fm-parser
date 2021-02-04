<?php 

namespace Uro\TeltonikaFmParser\Protocol\Tcp;

use Uro\TeltonikaFmParser\Codec\BaseCodec;
use Uro\TeltonikaFmParser\Io\Reader;
use Uro\TeltonikaFmParser\Codec\Codec8;
use Uro\TeltonikaFmParser\Codec\Codec8Extended;
use Uro\TeltonikaFmParser\Codec\Codec12;
use Uro\TeltonikaFmParser\Exception\UnsupportedCodecException;
use Uro\TeltonikaFmParser\Exception\CrcMismatchException;
use Uro\TeltonikaFmParser\Model\Imei;
use Uro\TeltonikaFmParser\Model\Packet;

class Decoder 
{
    private $reader;

    protected $codecs = [
        0x08 => Codec8::class,
        0x8E => Codec8Extended::class,
        0x0C => Codec12::class,
    ];

    public function decodeImei($data): Imei
    {
        $this->reader = new Reader($data);

        $numberOfBytes = $this->reader->readUInt16();

        return new Imei($this->reader->readBytes($numberOfBytes));
    }

    public function decodeData($data): Packet
    {
        $codec = $this->getCodec($data);

        if(!$codec->checkCrc())
            throw new CrcMismatchException;

        return $codec->decode();
    }

    private function getCodec($data): BaseCodec
    {
        $this->reader = new Reader($data);

        $this->reader->readUInt32(); // skip preamble
        $this->reader->readUInt32(); // skip size

        $codecId = $this->reader->readUInt8();

        if(! array_key_exists($codecId, $this->codecs))
            throw new UnsupportedCodecException($codecId);

        return new $this->codecs[$codecId]($this->reader);
    }
}