<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}

if (empty($arResult['ITEMS'])) {
    return;
}
?>
<div class="w-full slider-wrap">
    <div class="swiper j-main-directions__slider">
        <div class="swiper-wrapper main-directions__slides">
            <?php foreach ($arResult['ITEMS'] as $item) {
                $picture = null;
                if (!empty($item['PREVIEW_PICTURE'])) {
                    $picture = CFile::ResizeImageGet(
                        $item['PREVIEW_PICTURE'],
                        ['width' => 640, 'height' => 480],
                        BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
                        true,
                    );
                }
                $slideId = 'directions' . $item['ID'];
                $name = htmlspecialcharsbx($item['NAME']);
                $desc = $item['PREVIEW_TEXT'];
                ?>
                <div class="swiper-slide" id="<?php echo $slideId; ?>">
                    <div class="swiper-slide__content">
                        <h4><?php echo $name; ?></h4>
                        <?php if ($desc) { ?>
                            <div><?php echo $desc; ?></div>
                        <?php } ?>
                    </div>
                    <?php if ($picture) { ?>
                        <div class="main-directions__slides-img">
                            <img src="<?php echo $picture['src']; ?>" alt="<?php echo $name; ?>" title="<?php echo $name; ?>"/>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="direction-pagination swiper-pagination"></div>
    <div class="addition_btn">
        <div class="direction-prev_ rounded-button mobile-hidden">
            <span class="icon-pagination icon-prev">
                <svg aria-hidden="true" class="icon-symbol icon-symbol--default">
                    <use xlink:href="#i-arrow-right-m"/>
                </svg>
            </span>
        </div>
        <div class="direction-next_ rounded-button mobile-hidden">
            <span class="icon-pagination icon-next">
                <svg aria-hidden="true" class="icon-symbol icon-symbol--default">
                    <use xlink:href="#i-arrow-right-m"/>
                </svg>
            </span>
        </div>
    </div>
</div>
