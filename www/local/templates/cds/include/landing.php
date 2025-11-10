<?php
use Cds\Helpers\IblockHelper;
use Cds\Helpers\Applications;
use Cds\Options;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$directionsIblockId = IblockHelper::getId('cds_directions');
$tasksIblockId = IblockHelper::getId('cds_tasks');
$benefactorsIblockId = IblockHelper::getId('cds_benefactors');
$partnersIblockId = IblockHelper::getId('cds_partners');
$newsIblockId = IblockHelper::getId('cds_news');

$tasksButtons = [
    'primary' => [
        'text' => Options::get('TASKS_BTN_PRIMARY_TEXT', 'Помочь сейчас'),
        'link' => Options::get('TASKS_BTN_PRIMARY_LINK', '#'),
    ],
    'secondary' => [
        'text' => Options::get('TASKS_BTN_SECONDARY_TEXT', 'Нужна помощь'),
        'link' => Options::get('TASKS_BTN_SECONDARY_LINK', '#'),
    ],
];

$applicationsButton = [
    'text' => Options::get('APPLICATIONS_BTN_TEXT', 'Смотреть все заявки'),
    'link' => Options::get('APPLICATIONS_BTN_LINK', '#'),
];

$benefactorsButton = [
    'text' => Options::get('BENEFACTORS_BTN_TEXT', 'Помочь сейчас'),
    'link' => Options::get('BENEFACTORS_BTN_LINK', '#'),
];

$newsButton = [
    'text' => Options::get('NEWS_BTN_TEXT', 'Смотреть все новости'),
    'link' => Options::get('NEWS_BTN_LINK', '#'),
];

$applications = Applications::getMainList();
$applicationButtonTexts = Applications::getButtonTexts();
?>

<?php
$APPLICATION->IncludeComponent(
    'bitrix:main.include',
    '',
    [
        'AREA_FILE_SHOW' => 'file',
        'PATH' => SITE_DIR . 'local/include/home/hero.php',
        'EDIT_TEMPLATE' => '',
    ],
    false,
    ['HIDE_ICONS' => 'Y']
);
?>

<section class="main-directions">
    <div class="container">
        <div class="main-directions__content">
            <div class="main-directions__content-title">
                <?php
                $APPLICATION->IncludeComponent(
                    'bitrix:main.include',
                    '',
                    [
                        'AREA_FILE_SHOW' => 'file',
                        'PATH' => SITE_DIR . 'local/include/home/directions_title.php',
                        'EDIT_TEMPLATE' => '',
                    ],
                    false,
                    ['HIDE_ICONS' => 'Y']
                );
                ?>
            </div>
            <?php if ($directionsIblockId): ?>
                <?php
                global $arDirectionsFilter;
                $arDirectionsFilter = ['=PROPERTY_SHOW_ON_MAIN' => 'Y'];

                $APPLICATION->IncludeComponent(
                    'bitrix:news.list',
                    'cds_directions',
                    [
                        'IBLOCK_TYPE' => 'cds_content',
                        'IBLOCK_ID' => $directionsIblockId,
                        'FILTER_NAME' => 'arDirectionsFilter',
                        'FIELD_CODE' => ['NAME', 'PREVIEW_TEXT', 'PREVIEW_PICTURE'],
                        'PROPERTY_CODE' => ['SHOW_ON_MAIN'],
                        'NEWS_COUNT' => '20',
                        'SORT_BY1' => 'SORT',
                        'SORT_ORDER1' => 'ASC',
                        'CACHE_TYPE' => 'A',
                        'CACHE_TIME' => '3600',
                        'CACHE_FILTER' => 'Y',
                        'CACHE_GROUPS' => 'Y',
                        'SET_TITLE' => 'N',
                        'SET_BROWSER_TITLE' => 'N',
                        'SET_META_KEYWORDS' => 'N',
                        'SET_META_DESCRIPTION' => 'N',
                        'STRICT_SECTION_CHECK' => 'N',
                        'INCLUDE_SUBSECTIONS' => 'Y',
                        'CHECK_DATES' => 'Y',
                    ],
                    false,
                    ['HIDE_ICONS' => 'Y']
                );
                ?>
            <?php else: ?>
                <div class="alert alert-warning">Создайте инфоблок «Наши направления».</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="fund-tasks">
    <div class="container">
        <div class="fund-tasks__content">
            <div class="fund-tasks__content-title">
                <?php
                $APPLICATION->IncludeComponent(
                    'bitrix:main.include',
                    '',
                    [
                        'AREA_FILE_SHOW' => 'file',
                        'PATH' => SITE_DIR . 'local/include/home/tasks_title.php',
                        'EDIT_TEMPLATE' => '',
                    ],
                    false,
                    ['HIDE_ICONS' => 'Y']
                );
                ?>
            </div>
            <?php
            $APPLICATION->IncludeComponent(
                'bitrix:main.include',
                '',
                [
                    'AREA_FILE_SHOW' => 'file',
                    'PATH' => SITE_DIR . 'local/include/home/tasks_metrics.php',
                    'EDIT_TEMPLATE' => '',
                ],
                false,
                ['HIDE_ICONS' => 'Y']
            );
            ?>

            <?php if ($tasksIblockId): ?>
                <?php
                $APPLICATION->IncludeComponent(
                    'bitrix:news.list',
                    'cds_tasks',
                    [
                        'IBLOCK_TYPE' => 'cds_content',
                        'IBLOCK_ID' => $tasksIblockId,
                        'NEWS_COUNT' => '20',
                        'SORT_BY1' => 'SORT',
                        'SORT_ORDER1' => 'ASC',
                        'CACHE_TYPE' => 'A',
                        'CACHE_TIME' => '3600',
                        'CACHE_GROUPS' => 'Y',
                        'FIELD_CODE' => ['NAME', 'PREVIEW_TEXT'],
                        'PROPERTY_CODE' => ['ICON_SYMBOL'],
                        'SET_TITLE' => 'N',
                        'SET_BROWSER_TITLE' => 'N',
                        'SET_META_KEYWORDS' => 'N',
                        'SET_META_DESCRIPTION' => 'N',
                    ],
                    false,
                    ['HIDE_ICONS' => 'Y']
                );
                ?>
            <?php else: ?>
                <div class="alert alert-warning">Создайте инфоблок «Задачи фонда».</div>
            <?php endif; ?>

            <div class="tasks-content-btn-box">
                <a href="<?= htmlspecialcharsbx($tasksButtons['primary']['link'] ?: '#'); ?>"
                   class="btn btn--bg-red_txt-w">
                    <span class="text-btn"><?= htmlspecialcharsbx($tasksButtons['primary']['text']); ?></span>
                </a>
                <a href="<?= htmlspecialcharsbx($tasksButtons['secondary']['link'] ?: '#'); ?>"
                   class="btn btn--bg-w_txt-bl_brd-bl btn-sc-hidden">
                    <span class="text-btn"><?= htmlspecialcharsbx($tasksButtons['secondary']['text']); ?></span>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="main-applications">
    <div class="container">
        <div class="main-applications__content">
            <div class="main-applications__content-title">
                <?php
                $APPLICATION->IncludeComponent(
                    'bitrix:main.include',
                    '',
                    [
                        'AREA_FILE_SHOW' => 'file',
                        'PATH' => SITE_DIR . 'local/include/home/applications_title.php',
                        'EDIT_TEMPLATE' => '',
                    ],
                    false,
                    ['HIDE_ICONS' => 'Y']
                );
                ?>
                <?php if ($applications): ?>
                    <div class="w-full slider-wrap">
                        <div class="swiper j-main-applications__slider">
                            <div class="swiper-wrapper applications__slides">
                                <?php foreach ($applications as $application): ?>
                                    <?php
                                    $isClosed = $application['UF_STATUS'] === Applications::STATUS_CLOSED;
                                    $needAmount = (float)$application['UF_SUM_NEED'];
                                    $progressMax = max(1, $needAmount);
                                    $collected = (float)$application['UF_SUM_COLLECTED'];
                                    $historyText = $applicationButtonTexts[Applications::STATUS_HISTORY] ?? 'Узнать историю';
                                    $helpText = $applicationButtonTexts[Applications::STATUS_ACTIVE] ?? 'Помочь сейчас';
                                    $closedText = $applicationButtonTexts[Applications::STATUS_CLOSED] ?? 'Спасибо, сбор закрыт';
                                    ?>
                                    <div class="application-slide swiper-slide" id="application<?= (int)$application['ID']; ?>">
                                        <div class="application-slide__img-wrap">
                                            <div class="application-slide__img">
                                                <?php if (!empty($application['UF_PHOTO_SRC']['src'])): ?>
                                                    <img src="<?= $application['UF_PHOTO_SRC']['src']; ?>"
                                                         alt="<?= htmlspecialcharsbx($application['UF_NAME']); ?>"
                                                         title="<?= htmlspecialcharsbx($application['UF_NAME']); ?>"/>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="application-slide__content">
                                            <h4 class="application-slide__title"><?= htmlspecialcharsbx($application['UF_NAME']); ?></h4>
                                            <div class="application-slide__content-wrap">
                                                <?php if (!empty($application['UF_AGE'])): ?>
                                                    <div class="application-slide__age"><?= (int)$application['UF_AGE']; ?> лет</div>
                                                <?php endif; ?>
                                                <?php if (!empty($application['UF_DIRECTION'])): ?>
                                                    <div class="application-slide__direction-wrap">
                                                        <p class="application-slide__direction"><?= htmlspecialcharsbx($application['UF_DIRECTION']); ?></p>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (!empty($application['UF_DESCRIPTION'])): ?>
                                                    <div class="application-slide__description">
                                                        <p><?= $application['UF_DESCRIPTION']; ?></p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="application-slide__progress-wrap">
                                            <progress value="<?= $collected; ?>" max="<?= $progressMax; ?>"></progress>
                                                <p class="application-slide__sum">
                                                    Собрано <span><?= Applications::formatCurrency($collected); ?></span>
                                                    из <span><?= Applications::formatCurrency($needAmount); ?></span>
                                                </p>
                                            </div>
                                            <div class="application-slide__collect-btn">
                                                <?php if ($isClosed): ?>
                                                    <button type="button" class="btn btn--bg-w_txt-bl_brd-bl" disabled>
                                                        <span class="text-btn"><?= htmlspecialcharsbx($closedText); ?></span>
                                                    </button>
                                                <?php else: ?>
                                                    <a class="btn btn--bg-red_txt-w" href="#" role="button">
                                                        <span class="text-btn"><?= htmlspecialcharsbx($helpText); ?></span>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                            <div class="application-slide__link-wrap">
                                                <a class="application-slide__link"
                                                   href="<?= htmlspecialcharsbx($application['UF_STORY_LINK'] ?: '#'); ?>"
                                                   target="_blank" rel="noopener">
                                                    <?= htmlspecialcharsbx($historyText); ?>
                                                </a>
                                            </div>
                                            <?php if ($isClosed): ?>
                                                <div class="application-slide__closed-wrap">
                                                    <div class="application-slide__closed"></div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="applications-pagination swiper-pagination"></div>
                        <div class="addition_btn">
                            <div class="applications-prev_ rounded-button mobile-hidden">
                                <span class="icon-pagination icon-prev">
                                    <svg aria-hidden="true" class="icon-symbol icon-symbol--default">
                                        <use xlink:href="#i-arrow-right-m"/>
                                    </svg>
                                </span>
                            </div>
                            <div class="applications-next_ rounded-button mobile-hidden">
                                <span class="icon-pagination icon-next">
                                    <svg aria-hidden="true" class="icon-symbol icon-symbol--default">
                                        <use xlink:href="#i-arrow-right-m"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">Заполните HL-блок «Заявки соискателей».</div>
                <?php endif; ?>
                <div class="main-applications__btn">
                    <a href="<?= htmlspecialcharsbx($applicationsButton['link'] ?: '#'); ?>"
                       class="btn btn--bg-w_txt-bl_i-arrow-more">
                        <span class="text-btn"><?= htmlspecialcharsbx($applicationsButton['text']); ?></span>
                        <svg aria-hidden="true" class="icon-symbol icon-symbol--default">
                            <use xlink:href="#i-arrow-more"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="benefactors">
    <div class="container">
        <div class="benefactors__content">
            <div class="benefactors__content-title">
                <?php
                $APPLICATION->IncludeComponent(
                    'bitrix:main.include',
                    '',
                    [
                        'AREA_FILE_SHOW' => 'file',
                        'PATH' => SITE_DIR . 'local/include/home/benefactors_title.php',
                        'EDIT_TEMPLATE' => '',
                    ],
                    false,
                    ['HIDE_ICONS' => 'Y']
                );
                ?>
            </div>
            <?php
            $APPLICATION->IncludeComponent(
                'bitrix:main.include',
                '',
                [
                    'AREA_FILE_SHOW' => 'file',
                    'PATH' => SITE_DIR . 'local/include/home/benefactors_description.php',
                    'EDIT_TEMPLATE' => '',
                ],
                false,
                ['HIDE_ICONS' => 'Y']
            );
            ?>
            <?php if ($benefactorsIblockId): ?>
                <?php
                $APPLICATION->IncludeComponent(
                    'bitrix:news.list',
                    'cds_benefactors',
                    [
                        'IBLOCK_TYPE' => 'cds_content',
                        'IBLOCK_ID' => $benefactorsIblockId,
                        'NEWS_COUNT' => '20',
                        'SORT_BY1' => 'SORT',
                        'SORT_ORDER1' => 'ASC',
                        'CACHE_TYPE' => 'A',
                        'CACHE_TIME' => '3600',
                        'CACHE_GROUPS' => 'Y',
                        'FIELD_CODE' => ['NAME'],
                        'PROPERTY_CODE' => ['ICON_SYMBOL'],
                        'SET_TITLE' => 'N',
                        'SET_BROWSER_TITLE' => 'N',
                        'SET_META_KEYWORDS' => 'N',
                        'SET_META_DESCRIPTION' => 'N',
                    ],
                    false,
                    ['HIDE_ICONS' => 'Y']
                );
                ?>
            <?php else: ?>
                <div class="alert alert-warning">Создайте инфоблок «Благотворителям».</div>
            <?php endif; ?>

            <div class="benefactors__content-btn-box">
                <a href="<?= htmlspecialcharsbx($benefactorsButton['link'] ?: '#'); ?>"
                   class="btn btn--bg-red_txt-w">
                    <span class="text-btn"><?= htmlspecialcharsbx($benefactorsButton['text']); ?></span>
                </a>
            </div>
        </div>
    </div>
    <div class="ellipse"></div>
</section>

<section class="partners partners--in-main">
    <div class="container">
        <div class="partners__content">
            <div class="partners__content-title">
                <?php
                $APPLICATION->IncludeComponent(
                    'bitrix:main.include',
                    '',
                    [
                        'AREA_FILE_SHOW' => 'file',
                        'PATH' => SITE_DIR . 'local/include/home/partners_title.php',
                        'EDIT_TEMPLATE' => '',
                    ],
                    false,
                    ['HIDE_ICONS' => 'Y']
                );
                ?>
            </div>
            <?php
            $APPLICATION->IncludeComponent(
                'bitrix:main.include',
                '',
                [
                    'AREA_FILE_SHOW' => 'file',
                    'PATH' => SITE_DIR . 'local/include/home/partners_description.php',
                    'EDIT_TEMPLATE' => '',
                ],
                false,
                ['HIDE_ICONS' => 'Y']
            );
            ?>
            <?php if ($partnersIblockId): ?>
                <?php
                $APPLICATION->IncludeComponent(
                    'bitrix:news.list',
                    'cds_partners',
                    [
                        'IBLOCK_TYPE' => 'cds_content',
                        'IBLOCK_ID' => $partnersIblockId,
                        'NEWS_COUNT' => '30',
                        'SORT_BY1' => 'SORT',
                        'SORT_ORDER1' => 'ASC',
                        'CACHE_TYPE' => 'A',
                        'CACHE_TIME' => '3600',
                        'CACHE_GROUPS' => 'Y',
                        'FIELD_CODE' => ['NAME', 'PREVIEW_PICTURE'],
                        'PROPERTY_CODE' => [],
                        'SET_TITLE' => 'N',
                        'SET_BROWSER_TITLE' => 'N',
                        'SET_META_KEYWORDS' => 'N',
                        'SET_META_DESCRIPTION' => 'N',
                    ],
                    false,
                    ['HIDE_ICONS' => 'Y']
                );
                ?>
            <?php else: ?>
                <div class="alert alert-warning">Создайте инфоблок «Партнёры фонда».</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="news-section">
    <div class="container">
        <div class="news-section__content">
            <div class="news-section__content-title">
                <?php
                $APPLICATION->IncludeComponent(
                    'bitrix:main.include',
                    '',
                    [
                        'AREA_FILE_SHOW' => 'file',
                        'PATH' => SITE_DIR . 'local/include/home/news_title.php',
                        'EDIT_TEMPLATE' => '',
                    ],
                    false,
                    ['HIDE_ICONS' => 'Y']
                );
                ?>
            </div>
            <?php if ($newsIblockId): ?>
                <?php
                $APPLICATION->IncludeComponent(
                    'bitrix:news.list',
                    'cds_news',
                    [
                        'IBLOCK_TYPE' => 'cds_content',
                        'IBLOCK_ID' => $newsIblockId,
                        'NEWS_COUNT' => '3',
                        'SORT_BY1' => 'SHOW_COUNTER',
                        'SORT_ORDER1' => 'DESC',
                        'SORT_BY2' => 'ACTIVE_FROM',
                        'SORT_ORDER2' => 'DESC',
                        'CACHE_TYPE' => 'A',
                        'CACHE_TIME' => '3600',
                        'CACHE_GROUPS' => 'Y',
                        'FIELD_CODE' => ['NAME', 'PREVIEW_TEXT', 'PREVIEW_PICTURE', 'ACTIVE_FROM', 'DETAIL_PAGE_URL'],
                        'PROPERTY_CODE' => ['EXTERNAL_LINK'],
                        'SET_TITLE' => 'N',
                        'SET_BROWSER_TITLE' => 'N',
                        'SET_META_KEYWORDS' => 'N',
                        'SET_META_DESCRIPTION' => 'N',
                    ],
                    false,
                    ['HIDE_ICONS' => 'Y']
                );
                ?>
            <?php else: ?>
                <div class="alert alert-warning">Создайте инфоблок «Новости».</div>
            <?php endif; ?>

            <div class="news-section__btn">
                <a href="<?= htmlspecialcharsbx($newsButton['link'] ?: '#'); ?>"
                   class="btn btn--bg-w_txt-bl_i-arrow-more">
                    <span class="text-btn"><?= htmlspecialcharsbx($newsButton['text']); ?></span>
                    <svg aria-hidden="true" class="icon-symbol icon-symbol--default">
                        <use xlink:href="#i-arrow-more"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>
