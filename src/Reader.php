<?php
/*
 * @copyright (c) 2018 vebut
 */
namespace Vebut\IniSizeReader;

use Vebut\IniSizeReader\Exception\FormatException;

/**
 * Reader
 */
class Reader
{
    /**
     * @var int
     */
    private $bytes;


    /**
     * @var string
     */
    private $string;


    /**
     * Reader constructor.
     *
     * @param string $string Formatted string size, i.e "4MB", "1024" "6GB"
     *
     * @throws FormatException
     */
    public function __construct (string $string)
    {
        $this->string = $string;

        // Valid unit characters
        $stringUnitChars = "bkmgtpezy";

        // Normalize string before read
        $string = trim(strtolower($string));
        $stringUnit = preg_replace("/[^$stringUnitChars]/", "", $string);
        $stringAmount = preg_replace("/[^\-0-9]/", "", $string);

        if (!is_numeric($stringAmount)) {
            throw new FormatException("\"$string\" is not valid");
        }

        $this->bytes = (int) $stringAmount;
        if (strlen($stringUnit) > 0) {
            $this->bytes *= pow(1024, strpos($stringUnitChars, $stringUnit[0]));
        }
    }


    /**
     * Reads a size string and converts it into amount of bytes.
     *
     * @param string $string Formatted string size, i.e "4MB", "1024" "6GB"
     *
     * @return int
     * @throws FormatException
     */
    public static function toBytes (string $string): int
    {
        $reader = new Reader($string);
        return $reader->getBytes();
    }


    /**
     * Get string size value in bytes
     *
     * @return int
     */
    public function getBytes (): int
    {
        return $this->bytes;
    }


    /**
     * Get the original string
     *
     * @return string
     */
    public function getString (): string
    {
        return $this->string;
    }
}
