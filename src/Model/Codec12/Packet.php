<?php

namespace Uro\TeltonikaFmParser\Model\Codec12;

use Uro\TeltonikaFmParser\Model\Packet as PacketContract;

class Packet implements PacketContract
{
    protected $preamble;
    protected $length;
    protected $codec;
    protected $type;
    protected $bodySize;
    protected $body;
    protected $crc;

    /**
     * Message constructor.
     * @param $preamble
     * @param $length
     * @param $codec
     * @param $type
     * @param $bodySize
     * @param $body
     * @param $crc
     */
    public function __construct($preamble, $length, $codec, $type, $bodySize, $body, $crc)
    {
        $this->preamble = $preamble;
        $this->length = $length;
        $this->codec = $codec;
        $this->type = $type;
        $this->bodySize = $bodySize;
        $this->body = $body;
        $this->crc = $crc;
    }

    /**
     * @return mixed
     */
    public function getPreamble()
    {
        return $this->preamble;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return mixed
     */
    public function getCodec()
    {
        return $this->codec;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getBodySize()
    {
        return $this->bodySize;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return mixed
     */
    public function getCrc()
    {
        return $this->crc;
    }


}