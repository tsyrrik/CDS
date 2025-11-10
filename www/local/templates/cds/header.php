<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Page\Asset;

$asset = Asset::getInstance();
$asset->addCss(SITE_TEMPLATE_PATH . '/css/index.css');
$asset->addCss(SITE_TEMPLATE_PATH . '/css/components.css');
$asset->addJs(SITE_TEMPLATE_PATH . '/js/index.js');
$asset->addJs(SITE_TEMPLATE_PATH . '/js/components.js');
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=1,maximum-scale=1,minimum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php $APPLICATION->ShowTitle(); ?></title>
    <?php $APPLICATION->ShowHead(); ?>
    <link rel="apple-touch-icon" sizes="57x57" href="<?= SITE_TEMPLATE_PATH ?>/img/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= SITE_TEMPLATE_PATH ?>/img/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= SITE_TEMPLATE_PATH ?>/img/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= SITE_TEMPLATE_PATH ?>/img/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= SITE_TEMPLATE_PATH ?>/img/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= SITE_TEMPLATE_PATH ?>/img/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= SITE_TEMPLATE_PATH ?>/img/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= SITE_TEMPLATE_PATH ?>/img/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= SITE_TEMPLATE_PATH ?>/img/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= SITE_TEMPLATE_PATH ?>/img/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= SITE_TEMPLATE_PATH ?>/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= SITE_TEMPLATE_PATH ?>/img/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= SITE_TEMPLATE_PATH ?>/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?= SITE_TEMPLATE_PATH ?>/site.webmanifest">
    <meta name="msapplication-config" content="<?= SITE_TEMPLATE_PATH ?>/browserconfig.xml">
</head>
<body>
<div id="panel"><?php $APPLICATION->ShowPanel(); ?></div>
<?php require __DIR__ . '/include/header-content.php'; ?>
