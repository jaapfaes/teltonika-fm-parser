<?php 

namespace Tests\Unit\Protocol\Tcp;

use PHPUnit\Framework\TestCase;
use Uro\TeltonikaFmParser\Model\Codec8\Packet;
use Uro\TeltonikaFmParser\Model\Codec8\AvlDataCollection;

class PacketTest extends TestCase
{
    private $packet;

    private $avlDataCollection;

    public function setUp()
    {
        $this->avlDataCollection = new AvlDataCollection(8, 2, []);
        $this->packet = new Packet(0, 2, $this->avlDataCollection, 0x2b60);
    }

    /** @test */
    public function can_get_number_of_accepted_data()
    {
        $this->assertEquals(2, $this->packet->getNumberOfAcceptedData());
    }

    /** @test */
    public function can_get_preamble()
    {
        $this->assertEquals(0, $this->packet->getPreamble());
    }

    /** @test */
    public function can_get_avl_data_array_length()
    {
        $this->assertEquals(2, $this->packet->getLength());
    }

    /** @test */
    public function can_get_avl_data_collection()
    {
        $this->assertEquals($this->avlDataCollection, $this->packet->getBody());
    }

    /** @test */
    public function can_get_crc()
    {
        $this->assertEquals(0x2b60, $this->packet->getCrc());
    }
}