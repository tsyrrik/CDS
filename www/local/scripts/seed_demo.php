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

define('CDS_FORCE_RESET', in_array('--reset', $argv ?? [], true));

try {
    runSeeder();
    echo 'Демо-данные добавлены' . PHP_EOL;
} catch (Throwable $e) {
    fwrite(STDERR, 'Ошибка: ' . $e->getMessage() . PHP_EOL);
    exit(1);
}

function runSeeder(): void
{
    if (!Loader::includeModule('iblock')) {
        throw new RuntimeException('Модуль iblock недоступен');
    }

    if (!Loader::includeModule('highloadblock')) {
        throw new RuntimeException('Модуль highloadblock недоступен');
    }

    seedDirections();
    seedTasks();
    seedBenefactors();
    seedPartners();
    seedNews();
    seedApplications();
}

function seedDirections(): void
{
    $iblockId = getIblockId('cds_directions');
    if (!$iblockId) {
        echo "Инфоблок cds_directions не найден\n";

        return;
    }

    if (!shouldSeedIblock($iblockId, 'Направления')) {
        return;
    }

    $items = [
        [
            'NAME' => 'Физико-математическое',
            'PREVIEW_TEXT' => 'Программа объединяет физику и математику, развивает логическое мышление и готовит к инженерным и научным направлениям.',
            'PICTURE' => 'tmp/bf-slider/slider-img1.jpg',
        ],
        [
            'NAME' => 'Химико-биологическое',
            'PREVIEW_TEXT' => 'Углублённое изучение природных наук и лабораторная практика для будущих медиков и исследователей.',
            'PICTURE' => 'tmp/bf-slider/slider-img2.jpg',
        ],
        [
            'NAME' => 'Информационно-технологическое',
            'PREVIEW_TEXT' => 'Современные технологии, основы программирования и проектная деятельность для тех, кто видит будущее в IT.',
            'PICTURE' => 'tmp/bf-slider/slider-img1.jpg',
        ],
        [
            'NAME' => 'Творческое',
            'PREVIEW_TEXT' => 'Поддержка талантливых детей в музыке, дизайне и медиа, наставники помогают раскрыть творческий потенциал.',
            'PICTURE' => 'tmp/bf-slider/slider-img2.jpg',
        ],
    ];

    foreach ($items as $sort => $item) {
        addElement($iblockId, $item + [
            'SORT' => ($sort + 1) * 100,
            'PROPERTIES' => ['SHOW_ON_MAIN' => 'Y'],
        ]);
    }
}

function seedTasks(): void
{
    $iblockId = getIblockId('cds_tasks');
    if (!$iblockId) {
        echo "Инфоблок cds_tasks не найден\n";

        return;
    }

    if (!shouldSeedIblock($iblockId, 'Задачи')) {
        return;
    }

    $items = [
        [
            'NAME' => 'Стипендии и гранты',
            'PREVIEW_TEXT' => 'Помогаем с оплатой учёбы и покупкой учебных материалов, чтобы талантливые дети могли продолжать образование.',
            'PROPERTIES' => ['ICON_SYMBOL' => 'i-hands'],
        ],
        [
            'NAME' => 'Наставничество',
            'PREVIEW_TEXT' => 'Организуем программы менторства и карьерных консультаций совместно с партнёрами фонда.',
            'PROPERTIES' => ['ICON_SYMBOL' => 'i-star'],
        ],
        [
            'NAME' => 'Долгосрочная поддержка',
            'PREVIEW_TEXT' => 'Сопровождаем семьи, нуждающиеся в комплексной помощи: от медицинских услуг до социальной адаптации.',
            'PROPERTIES' => ['ICON_SYMBOL' => 'i-icon-stars'],
        ],
        [
            'NAME' => 'Открытые мероприятия',
            'PREVIEW_TEXT' => 'Проводим лекции, фестивали и сборы, чтобы каждый мог присоединиться к проектам фонда.',
            'PROPERTIES' => ['ICON_SYMBOL' => 'i-calendar'],
        ],
    ];

    foreach ($items as $sort => $item) {
        addElement($iblockId, $item + ['SORT' => ($sort + 1) * 100]);
    }
}

function seedBenefactors(): void
{
    $iblockId = getIblockId('cds_benefactors');
    if (!$iblockId) {
        echo "Инфоблок cds_benefactors не найден\n";

        return;
    }

    if (!shouldSeedIblock($iblockId, 'Блок «Благотворителям»')) {
        return;
    }

    $items = [
        ['NAME' => 'Онлайн-переводом', 'PROPERTIES' => ['ICON_SYMBOL' => 'i-pmnt-online']],
        ['NAME' => 'Через SMS', 'PROPERTIES' => ['ICON_SYMBOL' => 'i-pmnt-sms']],
        ['NAME' => 'По QR-коду', 'PROPERTIES' => ['ICON_SYMBOL' => 'i-pmnt-qr']],
        ['NAME' => 'По реквизитам', 'PROPERTIES' => ['ICON_SYMBOL' => 'i-pmnt-account1']],
    ];

    foreach ($items as $sort => $item) {
        addElement($iblockId, $item + ['SORT' => ($sort + 1) * 100]);
    }
}

function seedPartners(): void
{
    $iblockId = getIblockId('cds_partners');
    if (!$iblockId) {
        echo "Инфоблок cds_partners не найден\n";

        return;
    }

    if (!shouldSeedIblock($iblockId, 'Партнёры')) {
        return;
    }

    $items = [
        [
            'NAME' => 'Альфа Партнёр',
            'PICTURE' => 'tmp/bf-news/news-img1.png',
        ],
        [
            'NAME' => 'Бета Партнёр',
            'PICTURE' => 'tmp/bf-news/news-img2.png',
        ],
        [
            'NAME' => 'Гамма Партнёр',
            'PICTURE' => 'tmp/bf-news/news-img3.png',
        ],
        [
            'NAME' => 'Дельта Партнёр',
            'PICTURE' => 'tmp/bf-news/news-img1.png',
        ],
    ];

    foreach ($items as $sort => $item) {
        addElement($iblockId, $item + ['SORT' => ($sort + 1) * 100]);
    }
}

function seedNews(): void
{
    $iblockId = getIblockId('cds_news');
    if (!$iblockId) {
        echo "Инфоблок cds_news не найден\n";

        return;
    }

    if (!shouldSeedIblock($iblockId, 'Новости')) {
        return;
    }

    $items = [
        [
            'NAME' => 'Запуск программы стипендий',
            'PREVIEW_TEXT' => 'Фонд «Дерзай, твой шанс!» объявил о старте новой волны стипендий для талантливых студентов.',
            'PICTURE' => 'tmp/bf-news/news-img1.png',
            'ACTIVE_FROM' => '25.06.2024',
        ],
        [
            'NAME' => 'Проект для детей с ОВЗ',
            'PREVIEW_TEXT' => 'Новый образовательный курс помогает детям с ограниченными возможностями учиться онлайн.',
            'PICTURE' => 'tmp/bf-news/news-img2.png',
            'ACTIVE_FROM' => '20.06.2024',
        ],
        [
            'NAME' => 'Цифровая платформа фонда',
            'PREVIEW_TEXT' => 'Мы запустили платформу, где можно следить за историями соискателей и прогрессом сборов.',
            'PICTURE' => 'tmp/bf-news/news-img3.png',
            'ACTIVE_FROM' => '15.06.2024',
        ],
    ];

    foreach ($items as $sort => $item) {
        addElement($iblockId, $item + ['SORT' => ($sort + 1) * 100]);
    }
}

function seedApplications(): void
{
    $hlBlock = HighloadBlockTable::getList([
        'filter' => ['=TABLE_NAME' => 'cds_applications'],
    ])->fetch();

    if (!$hlBlock) {
        echo "HL-блок cds_applications не найден\n";

        return;
    }

    $entity = HighloadBlockTable::compileEntity($hlBlock);
    $dataClass = $entity->getDataClass();

    if (!shouldSeedApplications($dataClass)) {
        return;
    }

    $items = [
        [
            'UF_NAME' => 'Краснокутский Евгений',
            'UF_AGE' => 17,
            'UF_DIRECTION' => 'Физико-математическое направление',
            'UF_DESCRIPTION' => 'Стремлюсь поступить на инженерный факультет и хочу продолжить проекты по робототехнике.',
            'UF_SUM_NEED' => 678000,
            'UF_SUM_COLLECTED' => 300000,
            'UF_STATUS' => 'ACTIVE',
            'UF_STORY_LINK' => '#',
            'UF_PHOTO' => fileArray('tmp/bf-slider/applications-img.png'),
        ],
        [
            'UF_NAME' => 'Однолюбцева Дарина',
            'UF_AGE' => 16,
            'UF_DIRECTION' => 'Музыкальное направление',
            'UF_DESCRIPTION' => 'Учусь в колледже искусств, собираю на участие в международном конкурсе.',
            'UF_SUM_NEED' => 678000,
            'UF_SUM_COLLECTED' => 300340,
            'UF_STATUS' => 'ACTIVE',
            'UF_STORY_LINK' => '#',
            'UF_PHOTO' => fileArray('tmp/bf-slider/applications-img2.png'),
        ],
        [
            'UF_NAME' => 'Богомолова Светлана',
            'UF_AGE' => 15,
            'UF_DIRECTION' => 'Химико-биологическое направление',
            'UF_DESCRIPTION' => 'Мечтаю стать врачом-онкологом, фонд помогает с оплатой подготовительных курсов.',
            'UF_SUM_NEED' => 450000,
            'UF_SUM_COLLECTED' => 450000,
            'UF_STATUS' => 'CLOSED',
            'UF_STORY_LINK' => '#',
            'UF_PHOTO' => fileArray('tmp/bf-slider/applications-img3.png'),
        ],
    ];

    foreach ($items as $sort => $item) {
        $item['UF_SHOW_ON_MAIN'] = 1;
        $item['UF_SORT'] = ($sort + 1) * 100;
        if (empty($item['UF_PHOTO'])) {
            unset($item['UF_PHOTO']);
        }
        $result = $dataClass::add($item);
        if (!$result->isSuccess()) {
            throw new RuntimeException('Ошибка добавления заявки: ' . implode(', ', $result->getErrorMessages()));
        }
    }
}

function shouldSeedIblock(int $iblockId, string $label): bool
{
    if (CDS_FORCE_RESET) {
        clearIblock($iblockId);

        return true;
    }

    if (iblockHasElements($iblockId)) {
        echo $label . " уже заполнен, пропускаю\n";

        return false;
    }

    return true;
}

function clearIblock(int $iblockId): void
{
    $res = CIBlockElement::GetList([], ['IBLOCK_ID' => $iblockId], false, false, ['ID']);

    while ($row = $res->Fetch()) {
        CIBlockElement::Delete($row['ID']);
    }
}

function shouldSeedApplications(string $dataClass): bool
{
    if (CDS_FORCE_RESET) {
        clearHlBlock($dataClass);

        return true;
    }

    $existing = $dataClass::getList(['select' => ['ID'], 'limit' => 1])->fetch();
    if ($existing) {
        echo "HL «Заявки» уже заполнен, пропускаю\n";

        return false;
    }

    return true;
}

function clearHlBlock(string $dataClass): void
{
    $rows = $dataClass::getList(['select' => ['ID']]);

    while ($row = $rows->fetch()) {
        $dataClass::delete($row['ID']);
    }
}

function addElement(int $iblockId, array $fields): void
{
    $el = new CIBlockElement();
    $elementFields = [
        'IBLOCK_ID' => $iblockId,
        'ACTIVE' => 'Y',
        'NAME' => $fields['NAME'],
        'SORT' => $fields['SORT'] ?? 500,
    ];

    if (!empty($fields['PREVIEW_TEXT'])) {
        $elementFields['PREVIEW_TEXT'] = $fields['PREVIEW_TEXT'];
        $elementFields['PREVIEW_TEXT_TYPE'] = 'text';
    }

    if (!empty($fields['DETAIL_TEXT'])) {
        $elementFields['DETAIL_TEXT'] = $fields['DETAIL_TEXT'];
        $elementFields['DETAIL_TEXT_TYPE'] = 'text';
    }

    if (!empty($fields['PICTURE'])) {
        $file = fileArray($fields['PICTURE']);
        if ($file) {
            $elementFields['PREVIEW_PICTURE'] = $file;
        }
    }

    if (!empty($fields['ACTIVE_FROM'])) {
        $elementFields['ACTIVE_FROM'] = $fields['ACTIVE_FROM'];
    }

    if (!empty($fields['PROPERTIES'])) {
        $elementFields['PROPERTY_VALUES'] = $fields['PROPERTIES'];
    }

    $id = $el->Add($elementFields);
    if (!$id) {
        throw new RuntimeException('Ошибка добавления элемента: ' . $el->LAST_ERROR);
    }
}

function iblockHasElements(int $iblockId): bool
{
    $res = CIBlockElement::GetList([], ['IBLOCK_ID' => $iblockId], false, ['nTopCount' => 1], ['ID']);

    return (bool) $res->Fetch();
}

function getIblockId(string $code): ?int
{
    $iblock = CIBlock::GetList([], ['=CODE' => $code])->Fetch();

    return $iblock ? (int) $iblock['ID'] : null;
}

function fileArray(string $relativePath): ?array
{
    $absolute = $_SERVER['DOCUMENT_ROOT'] . '/local/templates/cds/' . ltrim($relativePath, '/');
    if (!is_file($absolute)) {
        echo "Файл не найден: {$absolute}\n";

        return null;
    }

    return CFile::MakeFileArray($absolute);
}
