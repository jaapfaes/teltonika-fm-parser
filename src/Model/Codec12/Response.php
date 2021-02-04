<?php 

namespace Uro\TeltonikaFmParser\Model\Codec12;

class Response
{
    private $body;

    private $crc;

    public function __construct($body, $crc)
    {
        $this->body = $body;
        $this->crc = $crc;
    }

    public function getBody(): int
    {
        return $this->body;
    }
}