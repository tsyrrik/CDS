<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (empty($arResult['ITEMS'])) {
    return;
}
?>
<div class="news-section__items-grid">
    <?php foreach ($arResult['ITEMS'] as $item): ?>
        <?php
        $this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item['IBLOCK_ID'], 'ELEMENT_EDIT'));
        $this->AddDeleteAction(
            $item['ID'],
            $item['DELETE_LINK'],
            CIBlock::GetArrayByID($item['IBLOCK_ID'], 'ELEMENT_DELETE'),
            ['CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]
        );

        $image = null;
        if (!empty($item['PREVIEW_PICTURE'])) {
            $image = CFile::ResizeImageGet(
                $item['PREVIEW_PICTURE'],
                ['width' => 420, 'height' => 280],
                BX_RESIZE_IMAGE_EXACT,
                true
            );
        }

        $link = $item['PROPERTIES']['EXTERNAL_LINK']['VALUE'] ?: $item['DETAIL_PAGE_URL'] ?: '#';
        ?>
        <div class="card-news" id="news<?= $item['ID']; ?>">
            <a href="<?= htmlspecialcharsbx($link); ?>" class="card-news" target="_blank" id="<?= $this->GetEditAreaId($item['ID']); ?>">
                <div class="card-news__image">
                    <?php if ($image): ?>
                        <img src="<?= $image['src']; ?>" alt="<?= htmlspecialcharsbx($item['NAME']); ?>" title="<?= htmlspecialcharsbx($item['NAME']); ?>"/>
                    <?php endif; ?>
                </div>
                <div class="card-news__info">
                    <p class="card-news__info-description"><?= htmlspecialcharsbx($item['PREVIEW_TEXT'] ?: $item['NAME']); ?></p>
                    <?php if ($item['DISPLAY_ACTIVE_FROM']): ?>
                        <p class="card-news__info-date"><?= $item['DISPLAY_ACTIVE_FROM']; ?></p>
                    <?php endif; ?>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>
