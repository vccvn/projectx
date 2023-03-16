<?php
namespace Crazy\Magic;

class MaskCollectionExample extends MaskCollection{
    public function getMask()
    {
        return MaskExample::class;
    }
}