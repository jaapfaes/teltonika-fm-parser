<?php 

namespace Uro\TeltonikaFmParser\Model\Codec8;

use Uro\TeltonikaFmParser\Support\Crc16;
use Uro\TeltonikaFmParser\Support\Acknowledgeable;
use Uro\TeltonikaFmParser\Model\Packet as PacketContract;

class Packet implements Acknowledgeable, PacketContract
{
    private $preamble;

    private $avlDataArrayLength;
    
    /**
     * Undocumented variable
     *
     * @var Uro\TeltonikaFmParser\Model\Codec8\AvlDataCollection
     */
    private $avlDataCollection;

    private $crc;

    public function __construct($preamble, $avlDataArrayLength, AvlDataCollection $avlDataCollection, $crc)
    {
        $this->preamble = $preamble;
        $this->avlDataArrayLength = $avlDataArrayLength;
        $this->avlDataCollection = $avlDataCollection;
        $this->crc = $crc;
    }

    /**
     * Get preamble
     *
     * @return int
     */
    public function getPreamble(): int
    {
        return $this->preamble;
    }

    /**
     * Get AVL data array length
     *
     * @return int
     */
    public function getLength(): int
    {
        return $this->avlDataArrayLength;
    }

    public function getBody()
    {
        return $this->avlDataCollection;
    }

    /**
     * Get number of accepted data
     *
     * @return int
     */
    public function getNumberOfAcceptedData(): int
    {
        return $this->avlDataCollection->getNumberOfData();
    }

    /**
     * Get CRC
     *
     * @return int
     */
    public function getCrc(): int
    {
        return $this->crc;
    }

    public function getCodec()
    {
        return $this->avlDataCollection->getCodecId;
    }
}