<?php

class ByteConverterTest extends PHPUnit_Framework_TestCase
{
    public function getDataForReturnBytes()
    {
        return array(
            ['23m', 23 * 1024 * 1024],
            ['23M', 23 * 1024 * 1024],
            [' 23M ', 23 * 1024 * 1024],
            ['23g', 23 * 1024 * 1024 * 1024],
            ['23k', 23 * 1024],
        );
    }

    /**
     * @dataProvider getDataForReturnBytes
     */
    public function testReturnBytes(string $value, int $expectation)
    {
        $byteConverter = new ByteConverter();

        $result = $byteConverter->return_bytes($value);

        $this->assertSame($expectation, $result);
    }
}
