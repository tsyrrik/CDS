<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (empty($arResult['ITEMS'])) {
    return;
}
?>
<ul class="benefactors__methods">
    <?php foreach ($arResult['ITEMS'] as $item): ?>
        <?php
        $this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item['IBLOCK_ID'], 'ELEMENT_EDIT'));
        $this->AddDeleteAction(
            $item['ID'],
            $item['DELETE_LINK'],
            CIBlock::GetArrayByID($item['IBLOCK_ID'], 'ELEMENT_DELETE'),
            ['CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]
        );
        $iconSymbol = $item['PROPERTIES']['ICON_SYMBOL']['VALUE'] ?? '';
        ?>
        <li class="benefactors__item" id="<?= $this->GetEditAreaId($item['ID']); ?>">
            <div class="benefactors__card">
                <?php if ($iconSymbol): ?>
                    <div class="benefactors__icon">
                        <svg aria-hidden="true" class="icon-symbol icon-symbol--default">
                            <use xlink:href="#<?= htmlspecialcharsbx($iconSymbol); ?>"/>
                        </svg>
                    </div>
                <?php endif; ?>
                <span class="benefactors__card-text"><?= htmlspecialcharsbx($item['NAME']); ?></span>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
