<?php 

namespace Uro\TeltonikaFmParser\Codec;

interface Codec
{
    public function decode();
    public function checkCrc();
}