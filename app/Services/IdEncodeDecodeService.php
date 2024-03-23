<?php

namespace App\Services;

class IdEncodeDecodeService
{
    /**
     * Base64 encoding.
     *
     * @param  int  $id
     * @return string
     */
    public function encodeId($id)
    {
        return base64_encode($id);
    }

    /**
     * Base64 decoding.
     *
     * @param  string  $encodedId
     * @return int
     */
    public function decodeId($encodedId)
    {
        return base64_decode($encodedId);
    }
}
