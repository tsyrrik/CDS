<?php
use Bitrix\Main\Loader;

Loader::registerAutoLoadClasses(
    null,
    [
        '\\Cds\\Options' => '/local/php_interface/lib/Cds/Options.php',
        '\\Cds\\Helpers\\IblockHelper' => '/local/php_interface/lib/Cds/Helpers/IblockHelper.php',
        '\\Cds\\Helpers\\Applications' => '/local/php_interface/lib/Cds/Helpers/Applications.php',
    ]
);
