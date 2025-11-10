<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}

if (empty($arResult['ITEMS'])) {
    return;
}
?>
<div class="partners__box swiper j-partners-swiper">
    <div class="swiper-wrapper">
        <?php foreach ($arResult['ITEMS'] as $item) { ?>
            <?php
            $this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item['IBLOCK_ID'], 'ELEMENT_EDIT'));
            $this->AddDeleteAction(
                $item['ID'],
                $item['DELETE_LINK'],
                CIBlock::GetArrayByID($item['IBLOCK_ID'], 'ELEMENT_DELETE'),
                ['CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')],
            );
            $image = null;
            if (!empty($item['PREVIEW_PICTURE'])) {
                $image = CFile::ResizeImageGet(
                    $item['PREVIEW_PICTURE'],
                    ['width' => 240, 'height' => 120],
                    BX_RESIZE_IMAGE_PROPORTIONAL,
                    true,
                );
            }
            ?>
            <div class="partners__item swiper-slide" id="<?php echo $this->GetEditAreaId($item['ID']); ?>">
                <?php if ($image) { ?>
                    <img src="<?php echo $image['src']; ?>" alt="<?php echo htmlspecialcharsbx($item['NAME']); ?>">
                <?php } else { ?>
                    <span><?php echo htmlspecialcharsbx($item['NAME']); ?></span>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
    <div class="swiper-pagination partners-swiper-pagination"></div>
</div>
