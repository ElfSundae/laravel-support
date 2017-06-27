<?php

namespace ElfSundae\Laravel\Support\Constants;

use ElfSundae\Laravel\Support\Enum;
use ElfSundae\Laravel\Support\Traits\EnumKeyString;

class Sex extends Enum
{
    use EnumKeyString;

    const UNKNOWN = 0;
    const MALE = 1;
    const FEMALE = 2;

    /**
     * The transfer keys.
     *
     * @var array
     */
    protected static $transferKeys = [
        'UNKNOWN' => '',
        'MALE' => '男',
        'FEMALE' => '女',
    ];
}
