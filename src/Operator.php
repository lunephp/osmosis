<?php


namespace Lune\Osmosis;


class Operator
{
    private $type;
    private $fieldname;
    private $value;
    private $strict;

    public function __construct(string $type, string $fieldname, $value, bool $strict = false)
    {
        $this->type = $type;
        $this->fieldname = $fieldname;
        $this->value = $value;
        $this->strict = $strict;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getFieldname(): string
    {
        return $this->fieldname;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return boolean
     */
    public function isStrict(): bool
    {
        return $this->strict;
    }

}