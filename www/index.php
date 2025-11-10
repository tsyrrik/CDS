<?php

declare(strict_types=1);
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
$APPLICATION->SetTitle('Дерзай, благотворительный фонд');
$templatePath = defined('SITE_TEMPLATE_PATH') ? SITE_TEMPLATE_PATH : '/local/templates/cds';
include $_SERVER['DOCUMENT_ROOT'] . $templatePath . '/include/landing.php';
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
