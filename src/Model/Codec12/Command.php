<?php 

namespace Uro\TeltonikaFmParser\Model\Codec12;

use Uro\TeltonikaFmParser\Support\Crc16;

class Command
{
//    private $type;
//
//    private $body;
//
//    private $crc;
//
//    public function __construct($type, $body, $crc)
//    {
//        $this->type = $type;
//        $this->body = $body;
//        $this->crc = $crc;
//    }
//
//    /**
//     * Get preamble
//     *
//     * @return int
//     */
//    public function getType(): int
//    {
//        return $this->type;
//    }
//
//    /**
//     * Get AVL data array length
//     *
//     * @return int
//     */
//    public function getBody(): int
//    {
//        return $this->body;
//    }
//
//    /**
//     * Get number of accepted data
//     *
//     * @return int
//     */
//    public function getNumberOfAcceptedData(): int
//    {
//        return $this->avlDataCollection->getNumberOfData();
//    }
//
//    /**
//     * Get CRC
//     *
//     * @return int
//     */
//    public function getCrc(): int
//    {
//        return $this->crc;
//    }
//
//    /**
//     * Check if packet CRC equals calculated CRC
//     *
//     * @return boolean
//     */
//    public function checkCrc(string $input): bool
//    {
//        return $this->crc == (new Crc16)->calc($input);
//    }
}