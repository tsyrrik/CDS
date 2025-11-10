<?php

declare(strict_types=1);

namespace Cds\Helpers;

use Bitrix\Main\Loader;
use CIBlock;

class IblockHelper
{
    private static array $cache = [];

    public static function getId(string $code): ?int
    {
        if (isset(self::$cache[$code])) {
            return self::$cache[$code];
        }

        if (!Loader::includeModule('iblock')) {
            return null;
        }

        $iblock = CIBlock::GetList([], ['=CODE' => $code])->Fetch();
        if (!$iblock) {
            return null;
        }

        self::$cache[$code] = (int) $iblock['ID'];

        return self::$cache[$code];
    }
}
