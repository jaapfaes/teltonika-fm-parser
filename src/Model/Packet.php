<?php

namespace Uro\TeltonikaFmParser\Model;

interface Packet
{
    public function getPreamble();

    public function getLength();

    public function getCodec();

    public function getBody();

    public function getCrc();
}