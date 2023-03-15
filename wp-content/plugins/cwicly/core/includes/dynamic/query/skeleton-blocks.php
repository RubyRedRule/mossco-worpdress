<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class CCSkeletoner
{
    public function cc_skeleton_block($block, $with_animation = false, $isBlock = false, $newq = false)
    {
        $final = '';
        if ($newq) {
            if (isset($block->parsed_block['innerBlocks'])) {
                foreach ($block->parsed_block['innerBlocks'] as $innerBlock) {
                    $final .= self::maker_prep_v2($innerBlock, $with_animation);
                };
            }
        } else if ($isBlock) {
            $final .= self::maker_prep($block, $with_animation);
        } else {
            foreach ($block->parsed_block['innerBlocks'] as $innerBlock) {
                $final .= self::maker_prep($innerBlock, $with_animation);
            };
        }
        return $final;
    }

    private function maker_prep($innerBlock, $with_animation)
    {
        if (str_contains($innerBlock['blockName'], 'cwicly')) {
            $innerInnerBlocks = '';
            if (isset($innerBlock['innerBlocks']) && $innerBlock['innerBlocks']) {
                $innerInnerBlocks .= $this->template_maker($innerBlock, $with_animation);
            }

            $attributers = (new WP_Block(
                $innerBlock
            ))->attributes;

            if (isset($attributers['skeletonActive']) && $attributers['skeletonActive']) {
                $open = cc_tag_maker($attributers, '', true);
                $close_tag = cc_tag_maker($attributers, '');

                if ($with_animation === false) {
                    $extraClass = ' cc-no-anim';
                } else {
                    $extraClass = '';
                }

                $count = 1;
                if ($innerBlock['blockName'] === 'cwicly/list') {
                    if (isset($attributers['content']) && $attributers['content']) {
                        $count = substr_count($attributers['content'], '<li>');
                    }
                }

                if ($innerBlock['blockName'] === 'cwicly/heading' || $innerBlock['blockName'] === 'cwicly/paragraph' || $innerBlock['blockName'] === 'cwicly/button' || $innerBlock['blockName'] === 'cwicly/input') {
                    return '<' . $open . ' class="' . $attributers['classID'] . ' cc-loading-skeleton-top"><span aria-live="polite" aria-busy="true"><span class="cc-loading-skeleton' . $extraClass . '">‌</span></span>' . $close_tag . '';
                } else if ($innerBlock['blockName'] === 'cwicly/image') {
                    return '<' . $open . ' class="' . $attributers['classID'] . ' cc-loading-skeleton-top"><span aria-live="polite" aria-busy="true"><span class="cc-loading-skeleton' . $extraClass . '">‌</span></span>' . $close_tag . '';
                } else if ($innerBlock['blockName'] === 'cwicly/icon') {
                    return '<' . $open . ' class="' . $attributers['classID'] . ' cc-loading-skeleton-top"><span aria-live="polite" aria-busy="true"><svg class="cc-loading-skeleton' . $extraClass . '" style="border-radius: 50%;">‌</svg></span>' . $close_tag . '';
                } else if ($innerBlock['blockName'] === 'cwicly/list') {
                    $return = '';
                    for ($i = 0; $i < $count; $i++) {
                        $return .= '<' . $open . ' class="' . $attributers['classID'] . '"><span aria-live="polite" aria-busy="true"><span class="cc-loading-skeleton' . $extraClass . '">‌</span></span>' . $close_tag . '';
                    }
                    return $return;
                } else if (!$innerInnerBlocks) {
                    return '<' . $open . ' class="' . $attributers['classID'] . ' cc-loading-skeleton-top"><span aria-live="polite" aria-busy="true"><span class="cc-loading-skeleton' . $extraClass . '">‌</span></span>' . $close_tag . '';
                } else {
                    return '<' . $open . ' class="' . $attributers['classID'] . '">' . $innerInnerBlocks . $close_tag . '';
                }
            }
        }
    }

    private function maker_prep_v2($innerBlock, $with_animation)
    {
        if (str_contains($innerBlock['blockName'], 'cwicly')) {
            $innerInnerBlocks = '';
            if (isset($innerBlock['innerBlocks']) && $innerBlock['innerBlocks']) {
                $innerInnerBlocks .= $this->template_maker_v2($innerBlock, $with_animation);
            }

            $attributers = (new WP_Block(
                $innerBlock
            ))->attributes;

            $open = cc_tag_maker($attributers, '', true);
            $close_tag = cc_tag_maker($attributers, '');

            if ($with_animation === false) {
                $extraClass = ' cc-no-anim';
            } else {
                $extraClass = '';
            }

            $count = 1;
            if ($innerBlock['blockName'] === 'cwicly/list') {
                if (isset($attributers['content']) && $attributers['content']) {
                    $count = substr_count($attributers['content'], '<li>');
                }
            }

            if ($innerBlock['blockName'] === 'cwicly/heading' || $innerBlock['blockName'] === 'cwicly/paragraph' || $innerBlock['blockName'] === 'cwicly/button' || $innerBlock['blockName'] === 'cwicly/input') {
                return '<' . $open . ' class="' . $attributers['classID'] . '">‌' . $close_tag . '';
            } else if ($innerBlock['blockName'] === 'cwicly/image') {
                return '<' . $open . ' class="' . $attributers['classID'] . '">‌' . $close_tag . '';
            } else if ($innerBlock['blockName'] === 'cwicly/icon') {
                return '<' . $open . ' class="' . $attributers['classID'] . '">‌' . $close_tag . '';
            } else if ($innerBlock['blockName'] === 'cwicly/list') {
                $return = '';
                for ($i = 0; $i < $count; $i++) {
                    $return .= '<' . $open . ' class="' . $attributers['classID'] . '">‌' . $close_tag . '';
                }
                return $return;
            } else {
                return '<' . $open . ' class="' . $attributers['classID'] . '">' . $innerInnerBlocks . $close_tag . '';
            }
        }
    }

    private function template_maker($block, $with_animation)
    {
        $innerBlocks = '';
        foreach ($block['innerBlocks'] as $innerBlock) {
            $innerBlocks .= $this->maker_prep($innerBlock, $with_animation);
        }
        return $innerBlocks;
    }

    private function template_maker_v2($block, $with_animation)
    {
        $innerBlocks = '';
        foreach ($block['innerBlocks'] as $innerBlock) {
            $innerBlocks .= $this->maker_prep_v2($innerBlock, $with_animation);
        }
        return $innerBlocks;
    }
}
