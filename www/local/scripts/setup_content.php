<?php

declare(strict_types=1);

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Loader;

$_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__ . '/../..');
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
define('BX_BUFFER_USED', true);

require $DOCUMENT_ROOT . '/bitrix/modules/main/include/prolog_before.php';

error_reporting(E_ALL);
ini_set('display_errors', '1');

try {
    runSetup();
    echo 'Настройка завершена' . PHP_EOL;
} catch (Throwable $e) {
    fwrite(STDERR, 'Ошибка: ' . $e->getMessage() . PHP_EOL);
    exit(1);
}

function runSetup(): void
{
    if (!Loader::includeModule('iblock')) {
        throw new RuntimeException('Модуль iblock недоступен');
    }

    if (!Loader::includeModule('highloadblock')) {
        throw new RuntimeException('Модуль highloadblock недоступен');
    }

    $siteId = getSiteId();

    ensureIblockType('cds_content', [
        'ID' => 'cds_content',
        'SECTIONS' => 'N',
        'LANG' => [
            'ru' => ['NAME' => 'Контент CDS'],
            'en' => ['NAME' => 'CDS content'],
        ],
    ]);

    $iblockIds = [];

    $iblockIds['cds_directions'] = ensureIblock([
        'CODE' => 'cds_directions',
        'NAME' => 'Наши направления',
        'TYPE_ID' => 'cds_content',
        'SITE_ID' => $siteId,
        'LIST_PAGE_URL' => '#SITE_DIR#/directions/',
        'DETAIL_PAGE_URL' => '#SITE_DIR#/directions/#ELEMENT_CODE#/',
        'DESCRIPTION' => 'Слайдер направлений фонда',
    ]);

    ensureProperty($iblockIds['cds_directions'], [
        'NAME' => 'Показывать на главной',
        'CODE' => 'SHOW_ON_MAIN',
        'PROPERTY_TYPE' => 'L',
        'LIST_TYPE' => 'C',
        'VALUES' => [
            ['XML_ID' => 'Y', 'VALUE' => 'Да', 'DEF' => 'Y'],
            ['XML_ID' => 'N', 'VALUE' => 'Нет'],
        ],
    ]);

    $iblockIds['cds_tasks'] = ensureIblock([
        'CODE' => 'cds_tasks',
        'NAME' => 'Задачи фонда',
        'TYPE_ID' => 'cds_content',
        'SITE_ID' => $siteId,
        'LIST_PAGE_URL' => '#SITE_DIR#/tasks/',
        'DETAIL_PAGE_URL' => '#SITE_DIR#/tasks/#ELEMENT_CODE#/',
        'DESCRIPTION' => 'Карточки задач',
    ]);

    ensureProperty($iblockIds['cds_tasks'], [
        'NAME' => 'Иконка (ID символа спрайта)',
        'CODE' => 'ICON_SYMBOL',
        'PROPERTY_TYPE' => 'S',
    ]);

    $iblockIds['cds_benefactors'] = ensureIblock([
        'CODE' => 'cds_benefactors',
        'NAME' => 'Способы помощи',
        'TYPE_ID' => 'cds_content',
        'SITE_ID' => $siteId,
        'LIST_PAGE_URL' => '#SITE_DIR#/benefactors/',
        'DETAIL_PAGE_URL' => '#SITE_DIR#/benefactors/#ELEMENT_CODE#/',
        'DESCRIPTION' => 'Методы поддержать фонд',
    ]);

    ensureProperty($iblockIds['cds_benefactors'], [
        'NAME' => 'Иконка (ID символа спрайта)',
        'CODE' => 'ICON_SYMBOL',
        'PROPERTY_TYPE' => 'S',
    ]);

    $iblockIds['cds_partners'] = ensureIblock([
        'CODE' => 'cds_partners',
        'NAME' => 'Партнеры фонда',
        'TYPE_ID' => 'cds_content',
        'SITE_ID' => $siteId,
        'LIST_PAGE_URL' => '#SITE_DIR#/partners/',
        'DETAIL_PAGE_URL' => '#SITE_DIR#/partners/#ELEMENT_CODE#/',
        'DESCRIPTION' => 'Список логотипов партнеров',
    ]);

    $iblockIds['cds_news'] = ensureIblock([
        'CODE' => 'cds_news',
        'NAME' => 'Новости фонда',
        'TYPE_ID' => 'cds_content',
        'SITE_ID' => $siteId,
        'LIST_PAGE_URL' => '#SITE_DIR#/news/',
        'DETAIL_PAGE_URL' => '#SITE_DIR#/news/#ELEMENT_CODE#/',
        'DESCRIPTION' => 'Новости для главной страницы',
    ]);

    ensureProperty($iblockIds['cds_news'], [
        'NAME' => 'Ссылка на внешний ресурс',
        'CODE' => 'EXTERNAL_LINK',
        'PROPERTY_TYPE' => 'S',
    ]);

    $applicationsHlId = ensureHighloadBlock('CdsApplications', 'cds_applications');
    ensureHlFields($applicationsHlId, [
        [
            'FIELD_NAME' => 'UF_NAME',
            'USER_TYPE_ID' => 'string',
            'EDIT_FORM_LABEL' => ['ru' => 'Имя'],
            'LIST_COLUMN_LABEL' => ['ru' => 'Имя'],
        ],
        [
            'FIELD_NAME' => 'UF_AGE',
            'USER_TYPE_ID' => 'double',
            'EDIT_FORM_LABEL' => ['ru' => 'Возраст'],
            'LIST_COLUMN_LABEL' => ['ru' => 'Возраст'],
        ],
        [
            'FIELD_NAME' => 'UF_DIRECTION',
            'USER_TYPE_ID' => 'string',
            'EDIT_FORM_LABEL' => ['ru' => 'Направление'],
            'LIST_COLUMN_LABEL' => ['ru' => 'Направление'],
        ],
        [
            'FIELD_NAME' => 'UF_DESCRIPTION',
            'USER_TYPE_ID' => 'string',
            'EDIT_FORM_LABEL' => ['ru' => 'Описание'],
            'LIST_COLUMN_LABEL' => ['ru' => 'Описание'],
            'SETTINGS' => ['ROWS' => 5],
        ],
        [
            'FIELD_NAME' => 'UF_SUM_NEED',
            'USER_TYPE_ID' => 'double',
            'EDIT_FORM_LABEL' => ['ru' => 'Необходимая сумма'],
            'LIST_COLUMN_LABEL' => ['ru' => 'Необходимая сумма'],
        ],
        [
            'FIELD_NAME' => 'UF_SUM_COLLECTED',
            'USER_TYPE_ID' => 'double',
            'EDIT_FORM_LABEL' => ['ru' => 'Собрано'],
            'LIST_COLUMN_LABEL' => ['ru' => 'Собрано'],
        ],
        [
            'FIELD_NAME' => 'UF_PHOTO',
            'USER_TYPE_ID' => 'file',
            'EDIT_FORM_LABEL' => ['ru' => 'Фотография'],
            'LIST_COLUMN_LABEL' => ['ru' => 'Фотография'],
        ],
        [
            'FIELD_NAME' => 'UF_STATUS',
            'USER_TYPE_ID' => 'string',
            'EDIT_FORM_LABEL' => ['ru' => 'Статус карточки'],
            'LIST_COLUMN_LABEL' => ['ru' => 'Статус'],
        ],
        [
            'FIELD_NAME' => 'UF_STORY_LINK',
            'USER_TYPE_ID' => 'string',
            'EDIT_FORM_LABEL' => ['ru' => 'Внешняя ссылка'],
            'LIST_COLUMN_LABEL' => ['ru' => 'Внешняя ссылка'],
        ],
        [
            'FIELD_NAME' => 'UF_SORT',
            'USER_TYPE_ID' => 'double',
            'EDIT_FORM_LABEL' => ['ru' => 'Сортировка'],
            'LIST_COLUMN_LABEL' => ['ru' => 'Сортировка'],
            'SETTINGS' => ['DEFAULT_VALUE' => 500],
        ],
        [
            'FIELD_NAME' => 'UF_SHOW_ON_MAIN',
            'USER_TYPE_ID' => 'boolean',
            'EDIT_FORM_LABEL' => ['ru' => 'Показывать на главной'],
            'LIST_COLUMN_LABEL' => ['ru' => 'На главной'],
            'SETTINGS' => ['DEFAULT_VALUE' => 1],
        ],
    ]);

    $optionsHlId = ensureHighloadBlock('CdsOptions', 'cds_options');
    ensureHlFields($optionsHlId, [
        [
            'FIELD_NAME' => 'UF_CODE',
            'USER_TYPE_ID' => 'string',
            'EDIT_FORM_LABEL' => ['ru' => 'Код'],
            'LIST_COLUMN_LABEL' => ['ru' => 'Код'],
        ],
        [
            'FIELD_NAME' => 'UF_VALUE',
            'USER_TYPE_ID' => 'string',
            'EDIT_FORM_LABEL' => ['ru' => 'Значение'],
            'LIST_COLUMN_LABEL' => ['ru' => 'Значение'],
            'SETTINGS' => ['ROWS' => 2],
        ],
    ]);

    seedOptions($optionsHlId, [
        'TASKS_BTN_PRIMARY_TEXT' => 'Помочь сейчас',
        'TASKS_BTN_PRIMARY_LINK' => '/',
        'TASKS_BTN_SECONDARY_TEXT' => 'Нужна помощь',
        'TASKS_BTN_SECONDARY_LINK' => '/',
        'APPLICATIONS_BTN_TEXT' => 'Смотреть все заявки',
        'APPLICATIONS_BTN_LINK' => '/',
        'APPLICATIONS_CARD_HELP_TEXT' => 'Помочь сейчас',
        'APPLICATIONS_CARD_HISTORY_TEXT' => 'Узнать историю',
        'APPLICATIONS_CARD_CLOSED_TEXT' => 'Спасибо, сбор закрыт',
        'BENEFACTORS_BTN_TEXT' => 'Помочь сейчас',
        'BENEFACTORS_BTN_LINK' => '/',
        'NEWS_BTN_TEXT' => 'Смотреть все новости',
        'NEWS_BTN_LINK' => '/',
    ]);
}

function getSiteId(): string
{
    $site = CSite::GetList($by = 'sort', $order = 'asc')->Fetch();

    return $site['LID'] ?? 's1';
}

function ensureIblockType(string $id, array $fields): void
{
    $res = CIBlockType::GetByID($id)->Fetch();
    if ($res) {
        return;
    }

    $ibType = new CIBlockType();
    $ibType->Add($fields);
}

function ensureIblock(array $fields): int
{
    $existing = CIBlock::GetList([], ['=CODE' => $fields['CODE']])->Fetch();
    if ($existing) {
        return (int) $existing['ID'];
    }

    $ib = new CIBlock();

    $default = [
        'ACTIVE' => 'Y',
        'VERSION' => 2,
        'LID' => [$fields['SITE_ID']],
        'GROUP_ID' => ['1' => 'X', '2' => 'R'],
    ];

    if (isset($fields['TYPE_ID']) && !isset($fields['IBLOCK_TYPE_ID'])) {
        $fields['IBLOCK_TYPE_ID'] = $fields['TYPE_ID'];
        unset($fields['TYPE_ID']);
    }

    $iblockId = $ib->Add(array_merge($default, $fields));

    if (!$iblockId) {
        throw new RuntimeException('Ошибка создания инфоблока ' . $fields['CODE'] . ': ' . $ib->LAST_ERROR);
    }

    return (int) $iblockId;
}

function ensureProperty(int $iblockId, array $fields): void
{
    $property = CIBlockProperty::GetList([], [
        '=IBLOCK_ID' => $iblockId,
        '=CODE' => $fields['CODE'],
    ])->Fetch();

    if ($property) {
        return;
    }

    $propertyEntity = new CIBlockProperty();
    $propertyEntity->Add(array_merge($fields, ['IBLOCK_ID' => $iblockId]));
}

function ensureHighloadBlock(string $name, string $tableName): int
{
    $existing = HighloadBlockTable::getList([
        'filter' => ['=TABLE_NAME' => $tableName],
    ])->fetch();

    if ($existing) {
        return (int) $existing['ID'];
    }

    $result = HighloadBlockTable::add([
        'NAME' => $name,
        'TABLE_NAME' => $tableName,
    ]);

    if (!$result->isSuccess()) {
        throw new RuntimeException('Ошибка создания HL-блока ' . $name . ': ' . implode(', ', $result->getErrorMessages()));
    }

    return (int) $result->getId();
}

function ensureHlFields(int $hlId, array $fields): void
{
    $entityId = 'HLBLOCK_' . $hlId;
    $userType = new CUserTypeEntity();

    foreach ($fields as $field) {
        $fieldExists = CUserTypeEntity::GetList(
            [],
            ['ENTITY_ID' => $entityId, 'FIELD_NAME' => $field['FIELD_NAME']],
        )->Fetch();

        if ($fieldExists) {
            continue;
        }

        $fieldData = array_merge([
            'ENTITY_ID' => $entityId,
            'SORT' => 500,
            'MULTIPLE' => 'N',
            'MANDATORY' => 'N',
        ], $field);

        $userType->Add($fieldData);
    }
}

function seedOptions(int $hlId, array $options): void
{
    $entity = HighloadBlockTable::compileEntity(HighloadBlockTable::getById($hlId)->fetch());
    $dataClass = $entity->getDataClass();

    $existing = [];
    $rows = $dataClass::getList(['select' => ['UF_CODE', 'ID']]);

    while ($row = $rows->fetch()) {
        $existing[$row['UF_CODE']] = $row['ID'];
    }

    foreach ($options as $code => $value) {
        if (isset($existing[$code])) {
            continue;
        }

        $dataClass::add([
            'UF_CODE' => $code,
            'UF_VALUE' => $value,
        ]);
    }
}
