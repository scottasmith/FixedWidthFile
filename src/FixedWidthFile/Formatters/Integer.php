<?php
namespace FixedWidthFile\Formatters;

class Integer implements FormatterInterface
{
    /**
     * @param  mixed
     * @param  integer
     * @return string
     */
    public function format($data, $length)
    {
        $value = sprintf("%0{$length}d", $data);
        $value = substr($value, 0, $length);

        return $value;
    }
}
