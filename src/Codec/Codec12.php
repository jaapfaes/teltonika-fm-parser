<?php 

namespace Uro\TeltonikaFmParser\Codec;

use Uro\TeltonikaFmParser\Io\Reader;
use Uro\TeltonikaFmParser\Model\Codec12\Packet;

class Codec12 extends BaseCodec
{
    protected $reader;

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function decode()
    {
        $this->reader->setPosition(0);

        $preamble = $this->reader->readUInt32();
        $length = $this->reader->readUInt32();
        $codec = $this->reader->readUInt8();
        $this->reader->readUInt8();
        $type = $this->reader->readUInt8();
        $bodySize = $this->reader->readUInt32();
        $body = $this->reader->readBytes($bodySize);
        $this->reader->readUInt8();
        $crc = $this->reader->readUInt32();

        return new Packet(
            $preamble,
            $length,
            $codec,
            $type,
            $bodySize,
            $body,
            $crc
        );
    }
}