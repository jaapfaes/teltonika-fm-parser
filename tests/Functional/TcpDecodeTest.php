<?php 

namespace Tests\Functional;

use PHPUnit\Framework\TestCase;
use Uro\TeltonikaFmParser\FmParser;

class TcpDecodeTest extends TestCase 
{
    /** @test */
    public function can_decode_imei()
    {
        $imei = (new FmParser('tcp'))->decodeImei('000F383632323539353838383334323930');

        $this->assertEquals('862259588834290', $imei->getImei());
    }

    /** @test */
    public function can_decode_codec8_data()
    {
        $packet = (new FmParser('tcp'))->decodeData(
            '0000000000000003'.    // AVL Packet header
            '8E'.                       // Codec 8 ID
            '0000'.                     // Empty AVL collection
            '00002b60'                  // CRC
        );

        $this->assertNotNull($packet);
        $this->assertEquals(0, $packet->getPreamble());
        $this->assertEquals(3, $packet->getLength());
        $this->assertEquals(0x8E, $packet->getBody()->getCodecId());
        $this->assertEquals(0x00002b60, $packet->getCrc());
    }

    /** @test */
    public function can_decode_codec12_data()
    {
        // 000000000000000F0C010500000007676574696E666F0100004312
        $packet = (new FmParser('tcp'))->decodeData(
            '00000000' .           // Zero Bytes
            '0000000F'.                 // Data Size - size is calculated from Codec ID field to the Response quantity field.
            '0C'.                       // Codec ID (Codec 12)
            '01'.                       // Command/Response Quantity 1 (ignored)
            '05'.                       // Type (05: Command - 06: Response)
            '00000007'.                 // Command/Response Size
            '676574696E666F'.           // Command/Response (getinfo in ASCI)
            '01'.                       // Command/Response Quantity 2 (ignored)
            '00004312'                  // CRC-16
        );

        $this->assertNotNull($packet);

        $this->assertEquals(0, $packet->getPreamble());
        $this->assertEquals(0x0000000F, $packet->getLength());
        $this->assertEquals(0x0C, $packet->getCodec());
        $this->assertEquals(0x05, $packet->getType());
        $this->assertEquals(0x00000007, $packet->getBodySize());

        $this->assertEquals('getinfo', $packet->getBody());

        $this->assertEquals(0x00004312, $packet->getCrc());
    }

    /** @test */
    public function can_decode_codec12_response_data()
    {
        // 000000000000000F0C010500000007676574696E666F0100004312
        $packet = (new FmParser('tcp'))->decodeData('00000000000000900C010600000088494E493A323031392F372F323220373A3232205254433A323031392F372F323220373A3533205253543A32204552523A312053523A302042523A302043463A302046473A3020464C3A302054553A302F302055543A3020534D533A30204E4F4750533A303A3330204750533A31205341543A302052533A332052463A36352053463A31204D443A30010000C78F');

        $this->assertNotNull($packet);

        $this->assertEquals(0, $packet->getPreamble());

        $this->assertEquals('INI:2019/7/22 7:22 RTC:2019/7/22 7:53 RST:2 ERR:1 SR:0 BR:0 CF:0 FG:0 FL:0 TU:0/0 UT:0 SMS:0 NOGPS:0:30 GPS:1 SAT:0 RS:3 RF:65 SF:1 MD:0', $packet->getBody());

        $this->assertEquals(0x0000C78F, $packet->getCrc());
    }

    /** 
     * @test 
     * @expectedException Uro\TeltonikaFmParser\Exception\CrcMismatchException
     */
    public function invalid_crc_throws_crc_mismatch_exception()
    {
        (new FmParser('tcp'))->decodeData(
            '0000000000000003'.     // AVL Packet header
            '8E'.                   // Codec 8 ID
            '0000'.                 // Empty AVL collection
            '00002b61'              // CRC
        );
    }
}