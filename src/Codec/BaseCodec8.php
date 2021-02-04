<?php 

namespace Uro\TeltonikaFmParser\Codec;

use Uro\TeltonikaFmParser\Exception\CrcMismatchException;
use Uro\TeltonikaFmParser\Io\Reader;
use Uro\TeltonikaFmParser\Model\Codec8\AvlData;
use Uro\TeltonikaFmParser\Model\Codec8\GpsElement;
use Uro\TeltonikaFmParser\Model\Codec8\AvlDataCollection;
use Uro\TeltonikaFmParser\Exception\NumberOfDataMismatchException;
use Uro\TeltonikaFmParser\Model\Codec8\Packet;

abstract class BaseCodec8 extends BaseCodec implements Codec
{
    protected $reader;

    /**
     * BaseCodec8 constructor.
     * @param $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function decode()
    {
        $this->reader->setPosition(0);

        $packet = new Packet(
            $this->reader->readUInt32(),                // Preamble
            $this->reader->readUInt32(),                // Avl Data array length
            $this->decodeAvlDataCollection(),           // Avl Data collection
            $this->reader->readUInt32()                 // CRC
        );

        return $packet;
    }
    
    public function decodeAvlDataCollection(): AvlDataCollection
    {
        $avlDataCollection = new AvlDataCollection(
            $this->reader->readUInt8(),     // Codec ID
            $this->reader->readUInt8()      // Number of data
        );

        $avlData = [];
        for($i = 0; $i < $avlDataCollection->getNumberOfData(); $i++) {
            $avlData[] = $this->decodeAvlData();
        }
        $avlDataCollection->setAvlData($avlData);

        $this->checkNumberOfData($avlDataCollection->getNumberOfData());
        
        return $avlDataCollection;
    }

    protected function checkNumberOfData($expected)
    {
        $lastNumberOfData = $this->reader->readUInt8();
        if($expected != $lastNumberOfData) {
            throw new NumberOfDataMismatchException(
                $expected, 
                $lastNumberOfData
            );
        }
    }

    public function decodeAvlData(): AvlData
    {
        return new AvlData(
            $this->reader->readUInt64(),    // Timestamp
            $this->reader->readUInt8(),     // Priority
            $this->decodeGpsElement(),      // GPS Element
            $this->decodeIoElement()        // IO Element
        );
    }

    public function decodeGpsElement(): GpsElement
    {
        return new GpsElement(
            $this->decodeCoordinate(),      // Longitude
            $this->decodeCoordinate(),      // Latitude
            $this->reader->readUInt16(),    // Altitude
            $this->reader->readUInt16(),    // Angle
            $this->reader->readUInt8(),     // Satellites
            $this->reader->readUInt16()     // Speed
        );
    }

    protected function decodeCoordinate(): float
    {
        return unpack('l', pack('l', $this->reader->readUInt32()))[1] / 10000000;
    }
}