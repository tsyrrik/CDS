<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (empty($arResult['ITEMS'])) {
    return;
}
?>
<ul class="tasks">
    <?php foreach ($arResult['ITEMS'] as $item): ?>
        <?php
        $this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item['IBLOCK_ID'], 'ELEMENT_EDIT'));
        $this->AddDeleteAction(
            $item['ID'],
            $item['DELETE_LINK'],
            CIBlock::GetArrayByID($item['IBLOCK_ID'], 'ELEMENT_DELETE'),
            ['CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]
        );
        $iconSymbol = $item['PROPERTIES']['ICON_SYMBOL']['VALUE'] ?? null;
        ?>
        <li class="tasks__item" id="<?= $this->GetEditAreaId($item['ID']); ?>">
            <div class="tasks__card">
                <h3 class="tasks__card-title"><?= htmlspecialcharsbx($item['NAME']); ?></h3>
                <?php if (!empty($item['PREVIEW_TEXT'])): ?>
                    <div class="tasks__card-description"><?= $item['PREVIEW_TEXT']; ?></div>
                <?php endif; ?>
                <?php if ($iconSymbol): ?>
                    <div class="tasks__card-icon">
                        <svg aria-hidden="true" class="icon-symbol icon-symbol--default">
                            <use xlink:href="#<?= htmlspecialcharsbx($iconSymbol); ?>"/>
                        </svg>
                    </div>
                <?php endif; ?>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
