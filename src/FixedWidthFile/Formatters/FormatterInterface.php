<?php
namespace FixedWidthFile\Formatters;

interface FormatterInterface
{
    /**
     * Format value with max length
     *
     * @param  mixed
     * @param  integer
     * @return mixed
     */
    public function format($data, $length);
}
