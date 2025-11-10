<?php
namespace Cds\Helpers;

use Bitrix\Main\Loader;
use Bitrix\Main\Data\Cache;
use Bitrix\Highloadblock\HighloadBlockTable;
use CFile;
use Cds\Options;

class Applications
{
    private const TABLE_NAME = 'cds_applications';
    private const CACHE_TTL = 600;
    private const CACHE_DIR = '/cds/applications';

    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_HISTORY = 'HISTORY';
    public const STATUS_CLOSED = 'CLOSED';

    public static function getMainList(int $limit = 10): array
    {
        if (!Loader::includeModule('highloadblock')) {
            return [];
        }

        $cache = Cache::createInstance();
        $cacheKey = self::TABLE_NAME . '_main_' . $limit;

        if ($cache->initCache(self::CACHE_TTL, $cacheKey, self::CACHE_DIR)) {
            return $cache->getVars();
        }

        $entityDataClass = self::getEntityDataClass();
        if (!$entityDataClass) {
            return [];
        }

        $rows = $entityDataClass::getList([
            'filter' => ['=UF_SHOW_ON_MAIN' => 1],
            'select' => [
                'ID',
                'UF_NAME',
                'UF_AGE',
                'UF_DIRECTION',
                'UF_DESCRIPTION',
                'UF_SUM_NEED',
                'UF_SUM_COLLECTED',
                'UF_PHOTO',
                'UF_STATUS',
                'UF_STORY_LINK',
            ],
            'order' => ['UF_SORT' => 'ASC', 'ID' => 'DESC'],
            'limit' => $limit,
        ]);

        $result = [];
        while ($row = $rows->fetch()) {
            $row['UF_PHOTO_SRC'] = self::resolvePhoto((int)$row['UF_PHOTO']);
            $result[] = $row;
        }

        if ($cache->startDataCache()) {
            $cache->endDataCache($result);
        }

        return $result;
    }

    public static function formatCurrency($value): string
    {
        $value = (float)$value;

        return number_format($value, 0, '.', ' ') . ' ₽';
    }

    public static function getButtonTexts(): array
    {
        return [
            self::STATUS_ACTIVE => Options::get('APPLICATIONS_CARD_HELP_TEXT', 'Помочь сейчас'),
            self::STATUS_HISTORY => Options::get('APPLICATIONS_CARD_HISTORY_TEXT', 'Узнать историю'),
            self::STATUS_CLOSED => Options::get('APPLICATIONS_CARD_CLOSED_TEXT', 'Спасибо, сбор закрыт'),
        ];
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

    private static function resolvePhoto(int $fileId): ?array
    {
        if ($fileId <= 0) {
            return null;
        }

        $file = CFile::ResizeImageGet(
            $fileId,
            ['width' => 420, 'height' => 480],
            BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
            true
        );

        if (!$file) {
            return null;
        }

        return $file;
    }
}
