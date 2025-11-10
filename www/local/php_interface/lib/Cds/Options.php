<?php
namespace Cds;

use Bitrix\Main\Loader;
use Bitrix\Main\Data\Cache;
use Bitrix\Highloadblock\HighloadBlockTable;

class Options
{
    private const TABLE_NAME = 'cds_options';
    private const CACHE_TTL = 3600;
    private const CACHE_DIR = '/cds/options';

    private static array $options = [];

    public static function get(string $code, ?string $default = null): ?string
    {
        $all = self::getAll();
        return $all[$code] ?? $default;
    }

    public static function getMany(array $codes): array
    {
        $all = self::getAll();
        $result = [];
        foreach ($codes as $code) {
            $result[$code] = $all[$code] ?? null;
        }

        return $result;
    }

    private static function getAll(): array
    {
        if (!empty(self::$options)) {
            return self::$options;
        }

        if (!Loader::includeModule('highloadblock')) {
            return [];
        }

        $cache = Cache::createInstance();
        $cacheKey = self::TABLE_NAME;
        if ($cache->initCache(self::CACHE_TTL, $cacheKey, self::CACHE_DIR)) {
            self::$options = $cache->getVars();
            return self::$options;
        }

        $entityDataClass = self::getEntityDataClass();
        if (!$entityDataClass) {
            return [];
        }

        $options = [];
        $rows = $entityDataClass::getList([
            'select' => ['UF_CODE', 'UF_VALUE'],
        ]);

        while ($row = $rows->fetch()) {
            $options[$row['UF_CODE']] = $row['UF_VALUE'];
        }

        if ($cache->startDataCache()) {
            $cache->endDataCache($options);
        }

        self::$options = $options;

        return self::$options;
    }

    private static function getEntityDataClass(): ?string
    {
        $hlBlock = HighloadBlockTable::getList([
            'filter' => ['=TABLE_NAME' => self::TABLE_NAME],
        ])->fetch();

        if (!$hlBlock) {
            return null;
        }

        $entity = HighloadBlockTable::compileEntity($hlBlock);

        return $entity->getDataClass();
    }
}
