<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class CCQueryTemplater
{
    protected $isQuery = false;

    public function singleBlock($block, $isQuery)
    {
        if ($isQuery) {
            $this->isQuery = true;
        }

        $innerBlocks = [];
        $innerBlocks[] = self::maker_prep($block->parsed_block);
        return $innerBlocks;
    }
    public function template($block, $isQuery)
    {
        if ($isQuery) {
            $this->isQuery = true;
        }
        $innerBlocks = [];

        foreach ($block->parsed_block['innerBlocks'] as $innerBlock) {
            $innerBlocks[] = self::maker_prep($innerBlock);
        };

        return $innerBlocks;
    }

    private function maker_prep($innerBlock)
    {
        if (str_contains($innerBlock['blockName'], 'cwicly')) {
            $innerInnerBlocks = [];
            if (isset($innerBlock['innerBlocks']) && $innerBlock['innerBlocks']) {
                $innerInnerBlocks = $this->template_maker($innerBlock);
            }
            $attributers = (new WP_Block(
                $innerBlock
            ))->attributes;

            $attrs = array();

            if ($innerBlock['blockName'] === 'cwicly/list') {
                // if (isset($attributes['listTag']) && $attributes['listTag']) {
                //     $attrs['list'] = $attributes['listTag'];
                // } else {
                //     $attrs['list'] = 'ul';
                // }
                if (cc_attribute_checker($attributers, 'listIconActive', 'true') && $attributers['listIconActive']) {
                    $attrs['list']['icon'] = $attributers['listIconActive'];
                }
            }
            if ($innerBlock['blockName'] === 'cwicly/icon') {
                $attrs['icon'] = $this->icon($attributers);
            }
            if ($innerBlock['blockName'] === 'cwicly/button') {
                $attrs['button'] = $this->button($attributers);
            }
            if ($innerBlock['blockName'] === 'cwicly/image') {
                $attrs['image'] = $this->image($attributers);
            }
            if ($innerBlock['blockName'] === 'cwicly/video') {
                $attrs['video'] = $this->video($attributers);
            }
            if ($innerBlock['blockName'] === 'cwicly/filter') {
                $attrs['filter'] = $this->filter($attributers);
            }
            if ($innerBlock['blockName'] === 'cwicly/rangeslider') {
                $attrs['rangeSlider'] = $this->rangeslider($attributers);
            }
            if ($innerBlock['blockName'] === 'cwicly/input') {
                $attrs['input'] = $this->input($attributers);
            }
            if ($innerBlock['blockName'] === 'cwicly/taxonomyterms') {
                $attrs['taxonomyterms'] = $this->taxonomy_terms($attributers, $innerBlock['blockName']);
            }
            if ($innerBlock['blockName'] === 'cwicly/accordions') {
                $attrs['accordions'] = $this->accordions($attributers);
            }
            if ($innerBlock['blockName'] === 'cwicly/accordion') {
                $attrs['accordion'] = $this->accordion($attributers);
            }
            if ($innerBlock['blockName'] === 'cwicly/tab') {
                $attrs['tab'] = $this->tab($attributers);
            }
            if ($innerBlock['blockName'] === 'cwicly/tablist') {
                $attrs['tabList'] = $this->tabList($attributers);
            }
            if ($innerBlock['blockName'] === 'cwicly/tabcontent') {
                $attrs['tabContent'] = $this->tabContent($attributers);
            }
            if (isset($innerBlock['repeaterMasonry']) && $innerBlock['repeaterMasonry']) {
                $attrs['repeaterMasonry'] = true;
            }
            if ($innerBlock['blockName'] === 'cwicly/popover') {
                $attrs['popover'] = $this->popover($attributers);
            }
            if ($innerBlock['blockName'] === 'cwicly/swatch') {
                $attrs['swatch'] = $this->swatch($attributers);
            }

            return array(
                'blockName' => $innerBlock['blockName'],
                'id' => $attributers['id'],
                'forceShowID' => cc_attribute_checker($attributers, 'forceShowID', 'true') ? true : false,
                'class' => $attributers['classID'],
                'isStyling' => cc_attribute_checker($attributers, 'isStyling', 'true') ? true : false,
                'addclasses' => isset($attributers['additionalClassesR']) && $attributers['additionalClassesR'] ? $attributers['additionalClassesR'] : '',
                'addclasseswrapper' => isset($attributers['additionalClassesWrapperR']) && $attributers['additionalClassesWrapperR'] ? $attributers['additionalClassesWrapperR'] : '',
                'globalclasses' => Cwicly\Helpers::global_classes($attributers),
                'tag' => $this->tagger($attributers, $innerBlock['blockName']),
                'content' => $this->content($attributers),
                'attrs' => $attrs,
                'link' => $this->link_wrapper($attributers),
                'isLinked' => cc_attribute_checker($attributers, 'linkWrapperActive', 'true') ? true : false,
                'conditions' => $this->conditions($attributers),
                'innerBlocks' => $innerInnerBlocks,
                'attributes' => cc_attribute_checker($attributers, 'htmlAttributes', 'true') ? $attributers['htmlAttributes'] : '',
                'styling' => $this->styling($attributers),
                'repeater' => $this->repeater($attributers, $innerBlock['blockName']),
                'tooltip' => $this->tooltip($attributers, $innerBlock['blockName']),
                'skeleton' => (new CCSkeletoner)->cc_skeleton_block($innerBlock, true, true),
            );
        } else {
            return array(
                'blockName' => $innerBlock['blockName'],
                'innerHTML' => $innerBlock['innerHTML'],
            );
        }
    }

    private function template_maker($block)
    {
        $innerBlocks = [];
        foreach ($block['innerBlocks'] as $innerBlock) {
            $innerBlocks[] = $this->maker_prep($innerBlock);
        }
        return $innerBlocks;
    }

    private function tagger($attributes, $blockName)
    {
        $custom_tag = '';
        if ($blockName === 'cwicly/list') {
            if (cc_attribute_checker($attributes, 'listTag', 'true') && $attributes['listTag']) {
                $custom_tag = $attributes['listTag'];
            } else {
                $custom_tag = 'ul';
            }
        } else if (isset($attributes['linkWrapperActive']) && $attributes['linkWrapperActive']) {
            if ($blockName === 'cwicly/heading') {
                $custom_tag = $attributes['headingTag'];
            } else if (isset($attributes['containerLayoutTag']) && $attributes['containerLayoutTag'] && ($attributes['containerLayoutTag'] === 'a' || $attributes['containerLayoutTag'] === 'button')) {
                $custom_tag = $attributes['containerLayoutTag'];
            } else {
                $custom_tag = 'a';
            }
        } else {
            if (isset($attributes['containerLayoutTag']) && $attributes['containerLayoutTag']) {
                $custom_tag = $attributes['containerLayoutTag'];
            } else if ($blockName === 'cwicly/paragraph') {
                $custom_tag = 'p';
            } else if ($blockName === 'cwicly/heading') {
                $custom_tag = $attributes['headingTag'];
            } else if ($blockName === 'cwicly/image') {
                $custom_tag = 'img';
            } else if ($blockName === 'cwicly/input') {
                if (cc_attribute_checker($attributes, 'inputTemplate', 'true') && $attributes['inputTemplate'] === 'commenttextarea') {
                    $custom_tag = 'textarea';
                } else {
                    $custom_tag = 'input';
                }
            } else {
                $custom_tag = 'div';
            }
        }
        return $custom_tag;
    }

    private function content($attributes)
    {
        $contenter = '';
        $extra = '';
        $extra2 = '';
        $extra3 = '';
        $before = '';
        $after = '';
        $fallback = '';

        if (cc_attribute_checker($attributes, 'dynamicStaticBefore', 'true')) {
            $before = $attributes['dynamicStaticBefore'];
        }
        if (cc_attribute_checker($attributes, 'dynamicStaticAfter', 'true')) {
            $after = $attributes['dynamicStaticAfter'];
        }
        if (cc_attribute_checker($attributes, 'dynamicStaticFallback', 'true')) {
            $fallback = $attributes['dynamicStaticFallback'];
        }

        if (isset($attributes['dynamic']) && $attributes['dynamic']) {
            if ($attributes['dynamic'] === 'wordpress' && isset($attributes['dynamicWordPressType'])) {
                switch ($attributes['dynamicWordPressType']) {
                    case "postexcerpt":
                        if (isset($attributes['dynamicWordPressExcerptLimit']) && $attributes['dynamicWordPressExcerptLimit']) {
                            $extra = $attributes['dynamicWordPressExcerptLimit'];
                        }
                        break;
                    case "customcurrentdate":
                        if (isset($attributes['dynamicWordPressCustomCurrentDate']) && $attributes['dynamicWordPressCustomCurrentDate']) {
                            $extra = $attributes['dynamicWordPressCustomCurrentDate'];
                        }
                        break;
                    case "currentdate":
                        if (isset($attributes['dynamicWordPressCurrentDateTime']) && $attributes['dynamicWordPressCurrentDateTime']) {
                            $extra = $attributes['dynamicWordPressCurrentDateTime'];
                        }
                        if (isset($attributes['dynamicWordPressCurrentDateDate']) && $attributes['dynamicWordPressCurrentDateDate']) {
                            $extra2 = $attributes['dynamicWordPressCurrentDateDate'];
                        }
                        break;
                    case "postdate":
                        if (isset($attributes['dynamicWordPressDateType']) && $attributes['dynamicWordPressDateType']) {
                            $extra = $attributes['dynamicWordPressDateType'];
                        }
                        if (isset($attributes['dynamicWordPressDateFormat']) && $attributes['dynamicWordPressDateFormat']) {
                            $extra2 = $attributes['dynamicWordPressDateFormat'];
                        }
                        if (isset($attributes['dynamicWordPressDateCustom']) && $attributes['dynamicWordPressDateCustom']) {
                            $extra3 = $attributes['dynamicWordPressDateCustom'];
                        }
                        break;
                    case "time":
                        if (isset($attributes['dynamicWordPressTimeType']) && $attributes['dynamicWordPressTimeType']) {
                            $extra = $attributes['dynamicWordPressTimeType'];
                        }
                        if (isset($attributes['dynamicWordPressTimeFormat']) && $attributes['dynamicWordPressTimeFormat']) {
                            $extra2 = $attributes['dynamicWordPressTimeFormat'];
                        }
                        if (isset($attributes['dynamicWordPressTimeCustom']) && $attributes['dynamicWordPressTimeCustom']) {
                            $extra3 = $attributes['dynamicWordPressTimeCustom'];
                        }
                        break;
                    case "postcomments":
                        if (isset($attributes['dynamicWordPressCommentsNone']) && $attributes['dynamicWordPressCommentsNone']) {
                            $extra = $attributes['dynamicWordPressCommentsNone'];
                        }
                        if (isset($attributes['dynamicWordPressCommentsOne']) && $attributes['dynamicWordPressCommentsOne']) {
                            $extra2 = $attributes['dynamicWordPressCommentsOne'];
                        }
                        if (isset($attributes['dynamicWordPressCommentsMultiple']) && $attributes['dynamicWordPressCommentsMultiple']) {
                            $extra3 = $attributes['dynamicWordPressCommentsMultiple'];
                        }
                        break;

                    case "authorinfo":
                        if (isset($attributes['dynamicWordPressAuthorInfo']) && $attributes['dynamicWordPressAuthorInfo']) {
                            $extra = $attributes['dynamicWordPressAuthorInfo'];
                        }
                        break;
                    case "userinfo":
                        if (isset($attributes['dynamicWordPressUserInfo']) && $attributes['dynamicWordPressUserInfo']) {
                            $extra = $attributes['dynamicWordPressUserInfo'];
                        }
                        break;
                    case "siteoption":
                    case "authorcustomfield":
                    case "usercustomfield":
                    case "customfield":
                        if (isset($attributes['dynamicWordPressExtra']) && $attributes['dynamicWordPressExtra']) {
                            $extra = $attributes['dynamicWordPressExtra'];
                        }
                        break;
                }
                $contenter = array(
                    'source' => 'wordpress',
                    'type' => $attributes['dynamicWordPressType'],
                    'extra' => $extra,
                    'extra2' => $extra2,
                    'extra3' => $extra3,
                    'before' => $before,
                    'after' => $after,
                    'fallback' => $fallback,
                );
            } else if ($attributes['dynamic'] === 'taxonomyquery' && isset($attributes['dynamicWordPressType'])) {
                $contenter = array(
                    'source' => 'taxonomyquery',
                    'type' => $attributes['dynamicWordPressType'],
                    'extra' => $extra,
                    'extra2' => $extra2,
                    'extra3' => $extra3,
                    'before' => $before,
                    'after' => $after,
                    'fallback' => $fallback,
                );
            } else if ($attributes['dynamic'] === 'userquery' && isset($attributes['dynamicWordPressType'])) {
                $contenter = array(
                    'source' => 'userquery',
                    'type' => $attributes['dynamicWordPressType'],
                    'extra' => $extra,
                    'extra2' => $extra2,
                    'extra3' => $extra3,
                    'before' => $before,
                    'after' => $after,
                    'fallback' => $fallback,
                );
            } else if ($attributes['dynamic'] === 'woocommerce' && isset($attributes['dynamicWordPressType'])) {
                switch ($attributes['dynamicWordPressType']) {
                    case "price":
                    case "regularprice":
                    case "saleprice":
                    case "variationmax":
                    case "variationmin":
                    case "cartitemprice":
                    case "cartitemregularprice":
                    case "cartitemsaleprice":
                    case "cartitemdesc":
                    case "cartitemtotal":
                    case "carttotal":
                    case "cartsubtotal":
                    case "cartshippingtotal":
                        if (isset($attributes['dynamicWooType']) && $attributes['dynamicWooType']) {
                            $extra = $attributes['dynamicWooType'];
                        }
                        break;

                    case "salefrom":
                    case "saleto":
                        if (isset($attributes['dynamicWordPressDateFormat']) && $attributes['dynamicWordPressDateFormat']) {
                            $extra = $attributes['dynamicWordPressDateFormat'];
                        }
                        break;
                }
                $contenter = array(
                    'source' => 'woocommerce',
                    'type' => $attributes['dynamicWordPressType'],
                    'extra' => $extra,
                    'extra2' => $extra2,
                    'extra3' => $extra3,
                    'before' => $before,
                    'after' => $after,
                    'fallback' => $fallback,
                );
            } else if (($attributes['dynamic'] === 'filter') && isset($attributes['dynamicWordPressType']) && $attributes['dynamicWordPressType']) {
                $contenter = array(
                    'source' => 'filter',
                    'type' => $attributes['dynamicWordPressType'],
                    'before' => $before,
                    'after' => $after,
                    'fallback' => $fallback,
                );
            } else if ($attributes['dynamic'] === 'filterselection') {
                $contenter = array(
                    'source' => 'filterselection',
                    'before' => $before,
                    'after' => $after,
                    'fallback' => $fallback,
                );
            } else if ($attributes['dynamic'] === 'acf' && cc_attribute_checker($attributes, 'dynamicACFGroup', 'true') && cc_attribute_checker($attributes, 'dynamicACFField', 'true')) {
                $location = '';
                if (cc_attribute_checker($attributes, 'dynamicACFFieldLocation', 'true')) {
                    switch ($attributes['dynamicACFFieldLocation']) {
                        case "postid":
                            if (cc_attribute_checker($attributes, 'dynamicACFFieldLocationID', 'true') && $attributes['dynamicACFFieldLocationID']) {
                                $location = $attributes['dynamicACFFieldLocationID'];
                            }
                            break;

                        case "userid":
                            if (cc_attribute_checker($attributes, 'dynamicACFFieldLocationID', 'true') && $attributes['dynamicACFFieldLocationID']) {
                                $location = 'user_' . $attributes['dynamicACFFieldLocationID'] . '';
                            }
                            break;

                        case "option":
                        case "currentuser":
                        case "termid":
                        case "termquery":
                        case "userquery":
                            $location = $attributes['dynamicACFFieldLocation'];
                            break;
                    }
                }

                // if (cc_attribute_checker($attributes, 'dynamicACFFieldPlus', 'true') && $attributes['dynamicACFFieldPlus']) {
                if (isset($attributes['dynamicACFFieldPlus']) && Cwicly\Helpers::check_if_exists($attributes['dynamicACFFieldPlus'])) {
                    $extra = $attributes['dynamicACFFieldPlus'];
                }

                $contenter = array(
                    'source' => 'acf',
                    'group' => $attributes['dynamicACFGroup'],
                    'field' => $attributes['dynamicACFField'],
                    'location' => $location,
                    'extra' => $extra,
                    'before' => $before,
                    'after' => $after,
                    'fallback' => $fallback,
                );
            } else if ($attributes['dynamic'] === 'repeater' && cc_attribute_checker($attributes, 'dynamicRepeaterField', 'true') && $attributes['dynamicRepeaterField']) {
                $contenter = array(
                    'source' => 'repeater',
                    'field' => $attributes['dynamicRepeaterField'],
                    'before' => $before,
                    'after' => $after,
                    'fallback' => $fallback,
                );
            } else if ($attributes['dynamic'] === 'taxonomyterms' && cc_attribute_checker($attributes, 'dynamicTaxTermsType', 'true') && $attributes['dynamicTaxTermsType']) {
                $contenter = array(
                    'source' => 'taxonomyterms',
                    'field' => $attributes['dynamicTaxTermsType'],
                    'before' => $before,
                    'after' => $after,
                    'fallback' => $fallback,
                );
            } else if ($attributes['dynamic'] === 'commentquery' && cc_attribute_checker($attributes, 'dynamicWordPressType', 'true') && $attributes['dynamicWordPressType']) {

                switch ($attributes['dynamicWordPressType']) {
                    case "comment_date":
                        if (isset($attributes['dynamicWordPressDateType']) && $attributes['dynamicWordPressDateType']) {
                            $extra = $attributes['dynamicWordPressDateType'];
                        }
                        if (isset($attributes['dynamicWordPressDateFormat']) && $attributes['dynamicWordPressDateFormat']) {
                            $extra2 = $attributes['dynamicWordPressDateFormat'];
                        }
                        if (isset($attributes['dynamicWordPressDateCustom']) && $attributes['dynamicWordPressDateCustom']) {
                            $extra3 = $attributes['dynamicWordPressDateCustom'];
                        }
                        break;

                    case "comment_time":
                        if (isset($attributes['dynamicWordPressDateType']) && $attributes['dynamicWordPressDateType']) {
                            $extra = $attributes['dynamicWordPressDateType'];
                        }
                        if (isset($attributes['dynamicWordPressDateFormat']) && $attributes['dynamicWordPressDateFormat']) {
                            $extra2 = $attributes['dynamicWordPressDateFormat'];
                        }
                        if (isset($attributes['dynamicWordPressDateCustom']) && $attributes['dynamicWordPressDateCustom']) {
                            $extra3 = $attributes['dynamicWordPressDateCustom'];
                        }
                        break;
                }

                $contenter = array(
                    'source' => 'commentquery',
                    'field' => $attributes['dynamicWordPressType'],
                    'extra' => $extra,
                    'extra2' => $extra2,
                    'extra3' => $extra3,
                    'before' => $before,
                    'after' => $after,
                    'fallback' => $fallback,
                );
            } else if ($attributes['dynamic'] === 'cartvariation' && cc_attribute_checker($attributes, 'dynamicWordPressType', 'true') && $attributes['dynamicWordPressType']) {
                $contenter = array(
                    'source' => 'cartvariation',
                    'type' => $attributes['dynamicWordPressType'],
                    'before' => $before,
                    'after' => $after,
                    'fallback' => $fallback,
                );
            }
        } else if (isset($attributes['content']) && $attributes['content']) {
            $contenter = $attributes['content'];
        }
        return $contenter;
    }

    private function image($attributes)
    {
        $fallback = '';
        $extra = '';

        if (isset($attributes['dynamicStaticFallbackID']) && $attributes['dynamicStaticFallbackID']) {
            // $fallback = $attributes['dynamicStaticFallbackID'];
            $thumbnailSize = 'full';
            if (cc_attribute_checker($attributes, 'imageThumbnailSize', 'true') && $attributes['imageThumbnailSize']) {
                $thumbnailSize = $attributes['imageThumbnailSize'];
            }
            $fallback = wp_get_attachment_image_src($attributes['dynamicStaticFallbackID'], $thumbnailSize);

        } else if (isset($attributes['dynamicStaticFallbackURL']) && $attributes['dynamicStaticFallbackURL']) {
            $fallback = $attributes['dynamicStaticFallbackURL'];
        }

        $size = '';
        if (isset($attributes['imageThumbnailSize']) && $attributes['imageThumbnailSize']) {
            $size = $attributes['imageThumbnailSize'];
        }

        $image = array();

        // if (!isset($attributes['imageType']) || (isset($attributes['imageType']) && (!$attributes['imageType'] || ($attributes['imageType'] && $attributes['imageType'] === 'static')))) {
        if (cc_attribute_checker($attributes, 'imageType', 'false') || (cc_attribute_checker($attributes, 'imageType', 'true') && $attributes['imageType'] === 'static')) {
            if (isset($attributes['imageID']) && $attributes['imageID'] && isset($attributes['imageURL']) && $attributes['imageURL']) {
                $image['source'] = 'static';
                $thumbnailSize = 'full';
                if (cc_attribute_checker($attributes, 'imageThumbnailSize', 'true') && $attributes['imageThumbnailSize']) {
                    $thumbnailSize = $attributes['imageThumbnailSize'];
                }
                $image_info = wp_get_attachment_image_src($attributes['imageID'], $thumbnailSize);
                if ($image_info) {
                    $image['src'] = $image_info[0];
                } else {
                    $image['src'] = $attributes['imageURL'];
                }
                $image['id'] = $attributes['imageID'];
                $image['width'] = $image_info[1];
                $image['height'] = $image_info[2];
                if (cc_attribute_checker($attributes, 'imageDisableSrcSet', 'false')) {
                    $image['srcset'] = esc_attr(wp_get_attachment_image_srcset($attributes['imageID'], 'medium'));
                }
            } else if (isset($attributes['imageURL']) && $attributes['imageURL']) {
                $image['src'] = $attributes['imageURL'];
            }
        } else if (cc_attribute_checker($attributes, 'imageType', 'true') && $attributes['imageType'] === 'dynamic') {
            if (cc_attribute_checker($attributes, 'dynamic', 'true')) {
                if ($attributes['dynamic'] === 'wordpress' || $attributes['dynamic'] === 'woocommerce') {
                    if (cc_attribute_checker($attributes, 'dynamicWordpressType', 'true')) {
                        switch ($attributes['dynamicWordpressType']) {

                        }
                        $image = array(
                            'source' => $attributes['dynamic'],
                            'type' => $attributes['dynamicWordpressType'],
                            'extra' => $extra,
                            'fallback' => $fallback,
                            'thumbnail' => $size,
                        );
                        if (cc_attribute_checker($attributes, 'imageDisableSrcSet', 'true')) {
                            $image['imageDisableSrcSet'] = true;
                        }
                    }
                } else if ($attributes['dynamic'] === 'acf' && cc_attribute_checker($attributes, 'dynamicACFGroup', 'true') && cc_attribute_checker($attributes, 'dynamicACFField', 'true')) {
                    $location = '';
                    if (cc_attribute_checker($attributes, 'dynamicACFFieldLocation', 'true')) {
                        switch ($attributes['dynamicACFFieldLocation']) {
                            case "postid":
                                if (cc_attribute_checker($attributes, 'dynamicACFFieldLocationID', 'true') && $attributes['dynamicACFFieldLocationID']) {
                                    $location = $attributes['dynamicACFFieldLocationID'];
                                }
                                break;

                            case "userid":
                                if (cc_attribute_checker($attributes, 'dynamicACFFieldLocationID', 'true') && $attributes['dynamicACFFieldLocationID']) {
                                    $location = 'user_' . $attributes['dynamicACFFieldLocationID'] . '';
                                }
                                break;

                            case "option":
                            case "currentuser":
                            case "termid":
                            case "termquery":
                            case "userquery":
                                $location = $attributes['dynamicACFFieldLocation'];
                                break;
                        }
                    }

                    if (cc_attribute_checker($attributes, 'dynamicACFFieldPlus', 'true') && $attributes['dynamicACFFieldPlus']) {
                        $extra = $attributes['dynamicACFFieldPlus'];
                    }

                    $image = array(
                        'type' => 'dynamic',
                        'source' => 'acf',
                        'group' => $attributes['dynamicACFGroup'],
                        'field' => $attributes['dynamicACFField'],
                        'location' => $location,
                        'extra' => $extra,
                        'fallback' => $fallback,
                        'thumbnail' => $size,
                    );
                    if (cc_attribute_checker($attributes, 'imageDisableSrcSet', 'true')) {
                        $image['imageDisableSrcSet'] = true;
                    }
                } else if ($attributes['dynamic'] === 'repeater' && cc_attribute_checker($attributes, 'dynamicACFField', 'true') && $attributes['dynamicACFField']) {
                    $image = array(
                        'source' => 'repeater',
                        'field' => $attributes['dynamicACFField'],
                        'fallback' => $fallback,
                        'thumbnail' => $size,
                    );
                    if (cc_attribute_checker($attributes, 'imageDisableSrcSet', 'true')) {
                        $image['imageDisableSrcSet'] = true;
                    }
                }
            }
        }

        // if (isset($image['src']) && $image['src']) {
        if (cc_attribute_checker($attributes, 'imageAlt', 'true') && $attributes['imageAlt']) {
            $image['alt'] = $attributes['imageAlt'];
        } else if (isset($attributes['imageID']) && $attributes['imageID']) {
            $image['alt'] = get_post_meta($attributes['imageID'], '_wp_attachment_image_alt', true);
        }
        if (isset($attributes['lazyLoad'])) {
            $image['lazyload'] = $attributes['lazyLoad'];
        }
        return $image;
    }

    private function icon($attributes)
    {
        $icon = array();

        if (isset($attributes['iconActive']) && $attributes['iconActive'] && isset($attributes['iconIcon']) && $attributes['iconIcon'] && is_array($attributes['iconIcon'])) {
            $icon = $attributes['iconIcon'];
        }
        if (cc_attribute_checker($attributes, 'iconSize', 'true') && isset($attributes['iconSize']['lg']) && $attributes['iconSize']['lg']) {
            $icon['size'] = $attributes['iconSize']['lg'];
        }
        return $icon;
    }

    private function button($attributes)
    {
        $icon = array();

        if (isset($attributes['buttonIconActive']) && $attributes['buttonIconActive'] && isset($attributes['buttonIcon']) && $attributes['buttonIcon'] && is_array($attributes['buttonIcon'])) {
            $icon['buttonIcon'] = $attributes['buttonIcon'];
        }
        if (cc_attribute_checker($attributes, 'buttonPosition', 'true')) {
            $icon['iconPosition'] = $attributes['buttonPosition'];
        }
        // if (cc_attribute_checker($attributes, 'iconSize', 'true') && isset($attributes['iconSize']['lg']) && $attributes['iconSize']['lg']) {
        //     $icon['size'] = $attributes['iconSize']['lg'];
        // }
        return $icon;
    }

    private function rangeslider($attributes)
    {
        $final = array();
        if (cc_attribute_checker($attributes, 'rangeSliderVertical', 'true')) {
            $final['rangeSliderVertical'] = $attributes['rangeSliderVertical'];
        }
        if (cc_attribute_checker($attributes, 'rangeSliderStep', 'true')) {
            $final['rangeSliderStep'] = $attributes['rangeSliderStep'];
        }
        if (cc_attribute_checker($attributes, 'rangeSliderValues', 'true')) {
            $final['rangeSliderValues'] = $attributes['rangeSliderValues'];
        }
        if (cc_attribute_checker($attributes, 'rangeSliderStep', 'true')) {
            $final['rangeSliderStep'] = $attributes['rangeSliderStep'];
        }
        if (cc_attribute_checker($attributes, 'rangeSliderMin', 'true')) {
            $final['rangeSliderMin'] = $attributes['rangeSliderMin'];
        }
        if (cc_attribute_checker($attributes, 'rangeSliderMax', 'true')) {
            $final['rangeSliderMax'] = $attributes['rangeSliderMax'];
        }
        if (cc_attribute_checker($attributes, 'rangeSliderRange', 'true')) {
            $final['rangeSliderRange'] = $attributes['rangeSliderRange'];
        }
        if (cc_attribute_checker($attributes, 'rangeSliderPush', 'true')) {
            $final['rangeSliderPush'] = $attributes['rangeSliderPush'];
        }
        if (cc_attribute_checker($attributes, 'rangeSliderLabel', 'true')) {
            $final['rangeSliderLabel'] = $attributes['rangeSliderLabel'];
        }
        if (cc_attribute_checker($attributes, 'rangeSliderHoverEffects', 'true')) {
            $final['rangeSliderHoverEffects'] = $attributes['rangeSliderHoverEffects'];
        }
        if (cc_attribute_checker($attributes, 'rangeSliderPrefix', 'true')) {
            $final['rangeSliderPrefix'] = $attributes['rangeSliderPrefix'];
        }
        if (cc_attribute_checker($attributes, 'rangeSliderSuffix', 'true')) {
            $final['rangeSliderSuffix'] = $attributes['rangeSliderSuffix'];
        }
        if (cc_attribute_checker($attributes, 'rangeSliderPips', 'true')) {
            $final['rangeSliderPips'] = $attributes['rangeSliderPips'];
        }
        if (cc_attribute_checker($attributes, 'rangeSliderPipStep', 'true')) {
            $final['rangeSliderPipStep'] = $attributes['rangeSliderPipStep'];
        }
        if (cc_attribute_checker($attributes, 'rangeSliderPipsAll', 'true')) {
            $final['rangeSliderPipsAll'] = $attributes['rangeSliderPipsAll'];
        }
        if (cc_attribute_checker($attributes, 'rangeSliderPipsFirst', 'true')) {
            $final['rangeSliderPipsFirst'] = $attributes['rangeSliderPipsFirst'];
        }
        if (cc_attribute_checker($attributes, 'rangeSliderPipsLast', 'true')) {
            $final['rangeSliderPipsLast'] = $attributes['rangeSliderPipsLast'];
        }
        if (cc_attribute_checker($attributes, 'rangeSliderPipsRest', 'true')) {
            $final['rangeSliderPipsRest'] = $attributes['rangeSliderPipsRest'];
        }
        if (cc_attribute_checker($attributes, 'rangeSliderHandles', 'true')) {
            $final['rangeSliderHandles'] = $attributes['rangeSliderHandles'];
        }
        if (cc_attribute_checker($attributes, 'rangeSliderFormatLabels', 'true')) {
            $final['rangeSliderFormatLabels'] = $attributes['rangeSliderFormatLabels'];
        }
        if (cc_attribute_checker($attributes, 'rangeSliderFormatLocales', 'true')) {
            $final['rangeSliderFormatLocales'] = $attributes['rangeSliderFormatLocales'];
        }
        return $final;
    }

    private function filter($attributes)
    {
        $final = array();
        if (cc_attribute_checker($attributes, 'filterQueryID', 'true') && isset($attributes['filterQueryID']['field'])) {
            if ($attributes['filterQueryID']['field']) {
                $final['filterQueryID'] = $attributes['filterQueryID']['field'];
            }
        }
        if (cc_attribute_checker($attributes, 'filterTarget', 'true')) {
            if (isset($attributes['filterTarget']['field'])) {
                $final['filterTarget'] = $attributes['filterTarget']['field'];
            }
        }
        if (cc_attribute_checker($attributes, 'filterType', 'true')) {
            $final['filterType'] = $attributes['filterType'];
        }
        if (cc_attribute_checker($attributes, 'filterSource', 'true')) {
            $final['filterSource'] = $attributes['filterSource'];
        }
        if (cc_attribute_checker($attributes, 'filterDataType', 'true')) {
            $final['filterDataType'] = $attributes['filterDataType'];
        }
        if (cc_attribute_checker($attributes, 'filterStaticData', 'true')) {
            $final['filterStaticData'] = $attributes['filterStaticData'];
        }
        if (cc_attribute_checker($attributes, 'filterData', 'true')) {
            $final['filterData'] = $attributes['filterData'];
        }
        if (cc_attribute_checker($attributes, 'filterParent', 'true')) {
            $final['filterParent'] = $attributes['filterParent'];
        }
        if (cc_attribute_checker($attributes, 'filterInclude', 'true')) {
            $final['filterInclude'] = $attributes['filterInclude'];
        }
        if (cc_attribute_checker($attributes, 'filterExclude', 'true')) {
            $final['filterExclude'] = $attributes['filterExclude'];
        }
        if (cc_attribute_checker($attributes, 'filterOrderBy', 'true')) {
            $final['filterOrderBy'] = $attributes['filterOrderBy'];
        }
        if (cc_attribute_checker($attributes, 'filterOrder', 'true')) {
            $final['filterOrder'] = $attributes['filterOrder'];
        }
        if (cc_attribute_checker($attributes, 'filterChildless', 'true')) {
            $final['filterChildless'] = $attributes['filterChildless'];
        }
        if (cc_attribute_checker($attributes, 'filterHideEmpty', 'true')) {
            $final['filterHideEmpty'] = $attributes['filterHideEmpty'];
        }
        if (cc_attribute_checker($attributes, 'filterTaxField', 'true')) {
            $final['filterTaxField'] = $attributes['filterTaxField'];
        }
        if (cc_attribute_checker($attributes, 'filterCountItems', 'true')) {
            $final['filterCountItems'] = $attributes['filterCountItems'];
        }
        if (cc_attribute_checker($attributes, 'filterShowInSelection', 'true')) {
            $final['filterShowInSelection'] = $attributes['filterShowInSelection'];
        }
        if (cc_attribute_checker($attributes, 'filterPlaceholder', 'true')) {
            $final['filterPlaceholder'] = $attributes['filterPlaceholder'];
        }
        if (cc_attribute_checker($attributes, 'filterSelectionPrefix', 'true')) {
            $final['filterSelectionPrefix'] = $attributes['filterSelectionPrefix'];
        }
        if (cc_attribute_checker($attributes, 'filterSelectionSuffix', 'true')) {
            $final['filterSelectionSuffix'] = $attributes['filterSelectionSuffix'];
        }
        if (cc_attribute_checker($attributes, 'filterDynamicDefaults', 'true')) {
            $final['filterDynamicDefaults'] = $attributes['filterDynamicDefaults'];
        }
        return $final;
    }

    private function input($attributes)
    {
        $final = array();
        if (cc_attribute_checker($attributes, 'inputTemplate', 'true')) {
            $final['inputTemplate'] = $attributes['inputTemplate'];
        }
        if (cc_attribute_checker($attributes, 'inputLabelDynamic', 'true')) {
            $final['inputLabelDynamic'] = $attributes['inputLabelDynamic'];
        }
        if (cc_attribute_checker($attributes, 'inputPlaceholder', 'true')) {
            $final['inputPlaceholder'] = $attributes['inputPlaceholder'];
        }
        return $final;
    }

    private function video($attributes)
    {
        $final = array();
        // if (cc_attribute_checker($attributes, 'videoStaticEmbedURL', 'true')) {
        if (cc_attribute_checker($attributes, 'videoType', 'true')) {
            if (cc_attribute_checker($attributes, 'videoType', 'true')) {
                $final['source'] = $attributes['videoType'];
            }
            if (cc_attribute_checker($attributes, 'videoStaticPlatform', 'true')) {
                $final['videoStaticPlatform'] = $attributes['videoStaticPlatform'];
            }
            if (cc_attribute_checker($attributes, 'videoStaticURL', 'true')) {
                $final['videoStaticURL'] = $attributes['videoStaticURL'];
            }
            if (cc_attribute_checker($attributes, 'videoPrivacy', 'true')) {
                $final['videoPrivacy'] = $attributes['videoPrivacy'];
            }
            if (cc_attribute_checker($attributes, 'videoBranding', 'true')) {
                $final['videoBranding'] = $attributes['videoBranding'];
            }
            if (cc_attribute_checker($attributes, 'videoStart', 'true')) {
                $final['videoStart'] = $attributes['videoStart'];
            }
            if (cc_attribute_checker($attributes, 'videoEnd', 'true')) {
                $final['videoEnd'] = $attributes['videoEnd'];
            }
            if (cc_attribute_checker($attributes, 'videoAutoplay', 'true')) {
                $final['videoAutoplay'] = $attributes['videoAutoplay'];
            }
            if (cc_attribute_checker($attributes, 'videoMute', 'true')) {
                $final['videoMute'] = $attributes['videoMute'];
            }
            if (cc_attribute_checker($attributes, 'videoLoop', 'true')) {
                $final['videoLoop'] = $attributes['videoLoop'];
            }
            if (cc_attribute_checker($attributes, 'videoControls', 'true')) {
                $final['videoControls'] = $attributes['videoControls'];
            }
            if (cc_attribute_checker($attributes, 'videoStaticEmbedURL', 'true')) {
                $final['videoStaticEmbedURL'] = $attributes['videoStaticEmbedURL'];
            }

            if (isset($attributes['videoDynamicType']) && $attributes['videoDynamicType'] === 'acf' && cc_attribute_checker($attributes, 'videoDynamicAcfGroup', 'true') && cc_attribute_checker($attributes, 'videoDynamicAcfField', 'true')) {
                // $location = '';
                // if (cc_attribute_checker($attributes, 'backgroundDynamicACFFieldLocation', 'true')) {
                //     switch ($attributes['backgroundDynamicACFFieldLocation']) {
                //         case "postid":
                //             if (cc_attribute_checker($attributes, 'backgroundDynamicACFFieldLocationID', 'true') && $attributes['backgroundDynamicACFFieldLocationID']) {
                //                 $location = $attributes['backgroundDynamicACFFieldLocationID'];
                //             }
                //             break;

                //         case "userid":
                //             if (cc_attribute_checker($attributes, 'backgroundDynamicACFFieldLocationID', 'true') && $attributes['backgroundDynamicACFFieldLocationID']) {
                //                 $location = 'user_' . $attributes['backgroundDynamicACFFieldLocationID'] . '';
                //             }
                //             break;

                //         case "option":
                //         case "currentuser":
                //         case "termid":
                //         case "termquery":
                //         case "userquery":
                //             $location = $attributes['dynamicACFFieldLocation'];
                //             break;
                //     }
                // }

                // $final['location'] = $location;

                $final['dynamicType'] = $attributes['videoDynamicType'];
                $final['group'] = $attributes['videoDynamicAcfGroup'];
                $final['field'] = $attributes['videoDynamicAcfField'];
            }
            // break;
        }
        // }

        if (cc_attribute_checker($attributes, 'videoImageOverlay', 'true')) {
            $final['videoImageOverlay'] = true;
        }
        return $final;
    }

    private function conditions($attributes)
    {
        $final = array();
        if (cc_attribute_checker($attributes, 'hideLoggedIn', 'true')) {
            $final['hideLoggedIn'] = true;
        }
        if (cc_attribute_checker($attributes, 'hideGuest', 'true')) {
            $final['hideGuest'] = true;
        }
        if (cc_attribute_checker($attributes, 'hideConditions', 'true')) {
            $final['hideConditions'] = $attributes['hideConditions'];
        }
        if (cc_attribute_checker($attributes, 'hideConditionsType', 'true')) {
            $final['hideConditionsType'] = $attributes['hideConditionsType'];
        }
        return $final;
    }

    private function styling($attributes)
    {
        $extra = '';
        $fallback = '';
        $final = array();
        if (cc_attribute_checker($attributes, 'backgroundDynamicStaticFallbackID', 'true') && $attributes['backgroundDynamicStaticFallbackID']) {
            $fallback = $attributes['backgroundDynamicStaticFallbackID'];
            $thumbnailSize = 'full';
            $fallback = wp_get_attachment_image_src($attributes['backgroundDynamicStaticFallbackID'], $thumbnailSize);

        } else if (cc_attribute_checker($attributes, 'backgroundDynamicStaticFallbackURL', 'true') && $attributes['backgroundDynamicStaticFallbackURL']) {
            $fallback = $attributes['backgroundDynamicStaticFallbackURL'];
        }
        if (cc_attribute_checker($attributes, 'backgroundType', 'true') && $attributes['backgroundType'] && $attributes['backgroundType']['lg'] === 'image' && cc_attribute_checker($attributes, 'backgroundImageType', 'true') && $attributes['backgroundImageType'] === 'dynamic' && cc_attribute_checker($attributes, 'backgroundDynamic', 'true') && $attributes['backgroundDynamic']) {
            if (cc_attribute_checker($attributes, 'backgroundDynamic', 'true')) {
                if ($attributes['backgroundDynamic'] === 'wordpress') {
                    if (cc_attribute_checker($attributes, 'backgroundDynamicWordpressType', 'true')) {
                        switch ($attributes['backgroundDynamicWordpressType']) {

                        }
                        $final = array(
                            'source' => 'wordpress',
                            'type' => $attributes['backgroundDynamicWordpressType'],
                            'fallback' => $fallback,
                        );
                    }
                } else if ($attributes['backgroundDynamic'] === 'acf' && cc_attribute_checker($attributes, 'backgroundDynamicACFGroup', 'true') && cc_attribute_checker($attributes, 'backgroundDynamicACFField', 'true')) {
                    $location = '';
                    if (cc_attribute_checker($attributes, 'backgroundDynamicACFFieldLocation', 'true')) {
                        switch ($attributes['backgroundDynamicACFFieldLocation']) {
                            case "postid":
                                if (cc_attribute_checker($attributes, 'backgroundDynamicACFFieldLocationID', 'true') && $attributes['backgroundDynamicACFFieldLocationID']) {
                                    $location = $attributes['backgroundDynamicACFFieldLocationID'];
                                }
                                break;

                            case "userid":
                                if (cc_attribute_checker($attributes, 'backgroundDynamicACFFieldLocationID', 'true') && $attributes['backgroundDynamicACFFieldLocationID']) {
                                    $location = 'user_' . $attributes['backgroundDynamicACFFieldLocationID'] . '';
                                }
                                break;

                            case "option":
                            case "currentuser":
                            case "termid":
                            case "termquery":
                            case "userquery":
                                $location = $attributes['dynamicACFFieldLocation'];
                                break;
                        }
                    }

                    if (cc_attribute_checker($attributes, 'backgroundDynamicACFFieldPlus', 'true') && $attributes['backgroundDynamicACFFieldPlus']) {
                        $extra = $attributes['backgroundDynamicACFFieldPlus'];
                    }

                    $final = array(
                        'type' => 'dynamic',
                        'source' => 'acf',
                        'group' => $attributes['backgroundDynamicACFGroup'],
                        'field' => $attributes['backgroundDynamicACFField'],
                        'location' => $location,
                        'extra' => $extra,
                        'fallback' => $fallback,
                    );
                }
            }
        }
        return $final;
    }

    private function link_wrapper($attributes)
    {
        if (cc_attribute_checker($attributes, 'linkWrapperActive', 'true')) {
            $description = '';
            if (cc_attribute_checker($attributes, 'linkWrapperShareDescription', 'true')) {
                $description = $attributes['linkWrapperShareDescription'];
            }
            $title = '';
            $rel = '';
            $target = '';
            $url = array();
            if (cc_attribute_checker($attributes, 'linkWrapperRel', 'true')) {
                $rel = $attributes['videoType'];
            }
            if (cc_attribute_checker($attributes, 'linkWrapperTitle', 'true')) {
                $title = $attributes['linkWrapperTitle'];
            }
            if (cc_attribute_checker($attributes, 'linkWrapperNewTab', 'true')) {
                $target = '_blank';
            } else {
                $target = '_self';
            }

            if (cc_attribute_checker($attributes, 'linkWrapperType', 'true')) {
                switch ($attributes['linkWrapperType']) {
                    case 'action':
                        if (cc_attribute_checker($attributes, 'linkWrapperAction', 'true')) {
                            switch ($attributes['linkWrapperAction']) {
                                case 'contact':
                                    $source = '';
                                    $oneLine = '';
                                    $skype = '';
                                    if (cc_attribute_checker($attributes, 'linkWrapperActionContactOneLine', 'true')) {
                                        $oneLine = $attributes['linkWrapperActionContactOneLine'];
                                    }
                                    if (cc_attribute_checker($attributes, 'linkWrapperActionContactType', 'true')) {
                                        $source = $attributes['linkWrapperActionContactType'];
                                    }
                                    if (cc_attribute_checker($attributes, 'linkWrapperActionContactSkype', 'true')) {
                                        $source = $attributes['linkWrapperActionContactSkype'];
                                    }
                                    $url['type'] = 'dynamic';
                                    $url['href'] = 'contact';
                                    $url['source'] = $source;
                                    if ($oneLine !== '') {
                                        $url['oneLine'] = $oneLine;
                                    }
                                    if ($skype) {
                                        $url['skype'] = $skype;
                                    }
                                    break;
                                case 'share':
                                    $source = '';
                                    if (cc_attribute_checker($attributes, 'linkWrapperShare', 'true')) {
                                        $source = $attributes['linkWrapperShare'];
                                    }

                                    $url['type'] = 'dynamic';
                                    $url['href'] = 'share';
                                    $url['source'] = $source;
                                    $url['description'] = $description;
                                    break;

                                case 'modal':
                                    $modalID = '';
                                    $modalType = '';
                                    if (cc_attribute_checker($attributes, 'linkWrapperActionModalBlockId', 'true')) {
                                        $modalID = $attributes['linkWrapperActionModalBlockId'];
                                    }
                                    if (cc_attribute_checker($attributes, 'linkWrapperActionModalType', 'true')) {
                                        $modalType = $attributes['linkWrapperActionModalType'];
                                    }

                                    $url['type'] = 'dynamic';
                                    $url['href'] = 'modal';
                                    $url['source'] = $modalType;
                                    if ($modalID) {
                                        $url['modalID'] = $modalID;
                                    }
                                    break;

                                case 'prevQuery':
                                case 'nextQuery':
                                case 'infiniteButtonLoad':
                                    $url['type'] = 'dynamic';
                                    $url['href'] = $attributes['linkWrapperAction'];
                                    break;

                                case 'scrolltotop':
                                    $offset = '';
                                    $offsetOut = '';
                                    $targetIn = '';
                                    $targetOut = '';
                                    if (cc_attribute_checker($attributes, 'linkWrapperActionExtra', 'true') && $attributes['linkWrapperActionExtra'] && $attributes['linkWrapperActionExtra']['offset']) {
                                        $offset = $attributes['linkWrapperActionExtra']['offset'];
                                    }
                                    if (cc_attribute_checker($attributes, 'linkWrapperActionExtra', 'true') && $attributes['linkWrapperActionExtra'] && $attributes['linkWrapperActionExtra']['outoffset']) {
                                        $offsetOut = $attributes['linkWrapperActionExtra']['outoffset'];
                                    }
                                    if (cc_attribute_checker($attributes, 'linkWrapperActionExtra', 'true') && $attributes['linkWrapperActionExtra'] && $attributes['linkWrapperActionExtra']['intarget']) {
                                        $targetIn = $attributes['linkWrapperActionExtra']['intarget'];
                                    }
                                    if (cc_attribute_checker($attributes, 'linkWrapperActionExtra', 'true') && $attributes['linkWrapperActionExtra'] && $attributes['linkWrapperActionExtra']['outtarget']) {
                                        $targetOut = $attributes['linkWrapperActionExtra']['outtarget'];
                                    }

                                    $url['type'] = 'dynamic';
                                    $url['href'] = 'scrolltotop';
                                    if ($offset) {
                                        $url['offset'] = $offset;
                                    }
                                    if ($offsetOut) {
                                        $url['offsetOut'] = $offsetOut;
                                    }
                                    if ($targetIn) {
                                        $url['targetIn'] = $targetIn;
                                    }
                                    if ($targetOut) {
                                        $url['targetOut'] = $targetOut;
                                    }
                                    break;
                                case 'filter':
                                    $url['type'] = 'dynamic';
                                    $url['href'] = 'filter';
                                    break;

                                case 'woostepup':
                                case 'woostepdown':
                                case 'woocartitemremove':
                                case 'wooaddtocart':
                                    $url['type'] = 'dynamic';
                                    $url['href'] = $attributes['linkWrapperAction'];
                                    $url['extra'] = cc_attribute_checker($attributes, 'linkWrapperActionExtra', 'true') && $attributes['linkWrapperActionExtra'] ? $attributes['linkWrapperActionExtra'] : '';
                                    break;

                                    // case 'woostepdown':
                                    //     $url['type'] = 'dynamic';
                                    //     $url['href'] = 'woostepdown';
                                    //     break;

                                    // case 'woocartitemremove':
                                    //     $url['type'] = 'dynamic';
                                    //     $url['href'] = 'woocartitemremove';
                                    //     break;
                            }
                        }
                        break;
                    case 'url':
                        if (cc_attribute_checker($attributes, 'linkWrapperSourceType', 'true')) {
                            if ($attributes['linkWrapperSourceType'] === 'static') {
                                if (cc_attribute_checker($attributes, 'linkWrapperUrl', 'true')) {
                                    $url['type'] = 'static';
                                    $url['href'] = $attributes['linkWrapperUrl'];
                                }
                            } else if ($attributes['linkWrapperSourceType'] === 'dynamic') {
                                $url['type'] = 'dynamic';
                                if (cc_attribute_checker($attributes, 'linkWrapperSourceDynamic', 'true')) {
                                    switch ($attributes['linkWrapperSourceDynamic']) {
                                        case 'acffield':
                                            if (cc_attribute_checker($attributes, 'linkWrapperAcfGroup', 'true') && cc_attribute_checker($attributes, 'linkWrapperAcfFields', 'true')) {
                                                $location = '';
                                                if (cc_attribute_checker($attributes, 'linkWrapperAcfLocation', 'true')) {
                                                    switch ($attributes['linkWrapperAcfLocation']) {
                                                        case "postid":
                                                            if (cc_attribute_checker($attributes, 'linkWrapperAcfLocationID', 'true') && $attributes['linkWrapperAcfLocationID']) {
                                                                $location = $attributes['linkWrapperAcfLocationID'];
                                                            }
                                                            break;

                                                        case "userid":
                                                            if (cc_attribute_checker($attributes, 'linkWrapperAcfLocationID', 'true') && $attributes['linkWrapperAcfLocationID']) {
                                                                $location = 'user_' . $attributes['linkWrapperAcfLocationID'] . '';
                                                            }
                                                            break;

                                                        case "option":
                                                        case "currentuser":
                                                        case "termid":
                                                        case "termquery":
                                                        case "userquery":
                                                            $location = $attributes['linkWrapperAcfLocation'];
                                                            break;
                                                    }
                                                }

                                                if (cc_attribute_checker($attributes, 'dynamicACFFieldPlus', 'true') && $attributes['dynamicACFFieldPlus']) {
                                                    $extra = $attributes['dynamicACFFieldPlus'];
                                                }

                                                $url['href'] = array(
                                                    'type' => 'dynamic',
                                                    'source' => 'acffield',
                                                    'group' => $attributes['linkWrapperAcfGroup'],
                                                    'field' => $attributes['linkWrapperAcfFields'],
                                                    'location' => $location,
                                                    // 'extra' => $extra,
                                                    // 'fallback' => $fallback,
                                                );
                                            }
                                            break;
                                        case 'acfrepeater':
                                            if (cc_attribute_checker($attributes, 'linkWrapperAcfRepeater', 'true') && cc_attribute_checker($attributes, 'linkWrapperAcfRepeater', 'true')) {
                                                $url['href'] = array(
                                                    'type' => 'dynamic',
                                                    'source' => 'acfrepeater',
                                                    'field' => $attributes['linkWrapperAcfRepeater'],
                                                    // 'extra' => $extra,
                                                    // 'fallback' => $fallback,
                                                );
                                            }
                                            break;
                                        default:
                                            // } && $attributes['linkWrapperSourceDynamic'] != 'acffield' && $attributes['linkWrapperSourceDynamic'] != 'acfrepeater') {
                                            if ($attributes['linkWrapperSourceDynamic'] === 'taxonomytermsurl') {
                                                $url['href'] = 'taxonomytermsurl';
                                            } else if ($attributes['linkWrapperSourceDynamic'] === 'taxonomyqueryurl') {
                                                $url['href'] = 'taxonomyqueryurl';
                                            } else if ($attributes['linkWrapperSourceDynamic'] === 'userqueryurl') {
                                                $url['href'] = 'userqueryurl';
                                            } else if ($attributes['linkWrapperSourceDynamic'] === 'commentqueryauthorarchive') {
                                                $url['href'] = 'commentqueryauthorarchive';
                                            } else if ($attributes['linkWrapperSourceDynamic'] === 'commentqueryauthorinfourl') {
                                                $url['href'] = 'commentquery=comment_author_url';
                                            } else if ($attributes['linkWrapperSourceDynamic'] === 'commenturl') {
                                                $url['href'] = 'commenturl';
                                            } else if ($attributes['linkWrapperSourceDynamic'] === 'commentreplyurl') {
                                                $url['href'] = 'commentreplyurl';
                                            } else if ($attributes['linkWrapperSourceDynamic'] === 'directlogout') {
                                                if (cc_attribute_checker($attributes, 'linkWrapperSourceExtra', 'true') && $attributes['linkWrapperSourceExtra'] != 'specific') {
                                                    $url['href'] = array('source' => 'directlogout', 'one' => $attributes['linkWrapperSourceExtra']);
                                                } else if (cc_attribute_checker($attributes, 'linkWrapperSourceExtra', 'true') && $attributes['linkWrapperSourceExtra'] === 'specific' && isset($attributes['linkWrapperSourceExtra2']) && $attributes['linkWrapperSourceExtra2']) {
                                                    $url['href'] = array('source' => 'directlogout', 'one' => 'specific', 'two' => $attributes['linkWrapperSourceExtra2']);
                                                } else {
                                                    $url['href'] = 'directlogout';
                                                }
                                            } else if ($attributes['linkWrapperSourceDynamic'] === 'loginurl') {
                                                if ($attributes['linkWrapperSourceExtra'] && $attributes['linkWrapperSourceExtra'] != 'specific') {
                                                    $url['href'] = array('source' => 'loginurl', 'one' => $attributes['linkWrapperSourceExtra']);
                                                } else if (cc_attribute_checker($attributes, 'linkWrapperSourceExtra', 'true') && $attributes['linkWrapperSourceExtra'] === 'specific' && isset($attributes['linkWrapperSourceExtra2']) && $attributes['linkWrapperSourceExtra2']) {
                                                    $url['href'] = array('source' => 'loginurl', 'one' => 'specific', 'two' => $attributes['linkWrapperSourceExtra2']);
                                                } else {
                                                    $url['href'] = 'loginurl';
                                                }
                                            } else if ($attributes['linkWrapperSourceDynamic'] === 'editcommenturl') {
                                                $url['href'] = 'editcommenturl';
                                            } else if ($attributes['linkWrapperSourceDynamic'] === 'posturl') {
                                                $url['href'] = 'pageurl';
                                            } else if ($attributes['linkWrapperSourceDynamic'] === 'postarchiveurl') {
                                                $url['href'] = 'archiveurl';
                                            } else if ($attributes['linkWrapperSourceDynamic'] === 'archiveurl') {
                                                $url['href'] = 'archiveurl';
                                            } else if ($attributes['linkWrapperSourceDynamic'] === 'featuredimage') {
                                                $url['href'] = 'featuredimage';
                                            } else if ($attributes['linkWrapperSourceDynamic'] === 'homeurl') {
                                                $url['href'] = 'homeurl';
                                            } else if ($attributes['linkWrapperSourceDynamic'] === 'siteurl') {
                                                $url['href'] = 'siteurl';
                                            } else if ($attributes['linkWrapperSourceDynamic'] === 'authorurl') {
                                                $url['href'] = 'authorurl';
                                            } else if ($attributes['linkWrapperSourceDynamic'] === 'commentsurl') {
                                                $url['href'] = 'commentsurl';
                                            } else if ($attributes['linkWrapperSourceDynamic'] === 'commentsurl') {
                                                $url['href'] = 'internalurl';
                                            } else if ($attributes['linkWrapperSourceDynamic'] === 'shortcode' && cc_attribute_checker($attributes, 'linkWrapperDynamicShortcode', 'true')) {
                                                $url['href'] = array('source' => 'shortcode', 'one' => $attributes['linkWrapperDynamicShortcode']);
                                            } else if ($attributes['linkWrapperSourceDynamic'] === 'woocheckouturl') {
                                                $url['href'] = `woocheckouturl`;
                                            } else if ($attributes['linkWrapperSourceDynamic'] === 'woocarturl') {
                                                $url['href'] = `woocarturl`;
                                            }
                                            break;
                                    }
                                }
                                // } else if (cc_attribute_checker($attributes, 'linkWrapperSourceDynamic', 'true') && $attributes['linkWrapperSourceDynamic'] === 'acffield' && cc_attribute_checker($attributes, 'linkWrapperAcfGroup', 'true') && cc_attribute_checker($attributes, 'linkWrapperAcfFields', 'true')) {
                                //     $url['href'] = array('source' => 'acffield', 'one' => $attributes['linkWrapperAcfFields']);
                                // }
                            }
                        }
                        break;
                }
            }
            return array(
                'rel' => $rel,
                'title' => $title,
                'target' => $target,
                'url' => $url,
            );
        }
        return array();
    }

    private function repeater($attributes, $blockName)
    {
        if ($blockName === 'cwicly/repeater') {
            $contenter = array();
            if (cc_attribute_checker($attributes, 'dynamic', 'true') && $attributes['dynamic'] === 'acf' && cc_attribute_checker($attributes, 'dynamicACFGroup', 'true') && cc_attribute_checker($attributes, 'dynamicACFField', 'true')) {
                $location = '';
                if (cc_attribute_checker($attributes, 'dynamicACFFieldLocation', 'true')) {
                    switch ($attributes['dynamicACFFieldLocation']) {
                        case "postid":
                            if (cc_attribute_checker($attributes, 'dynamicACFFieldLocationID', 'true') && $attributes['dynamicACFFieldLocationID']) {
                                $location = $attributes['dynamicACFFieldLocationID'];
                            }
                            break;

                        case "userid":
                            if (cc_attribute_checker($attributes, 'dynamicACFFieldLocationID', 'true') && $attributes['dynamicACFFieldLocationID']) {
                                $location = 'user_' . $attributes['dynamicACFFieldLocationID'] . '';
                            }
                            break;

                        case "option":
                        case "currentuser":
                        case "termid":
                        case "termquery":
                        case "userquery":
                            $location = $attributes['dynamicACFFieldLocation'];
                            break;
                    }
                }

                $contenter = array(
                    'source' => 'acf',
                    'group' => $attributes['dynamicACFGroup'],
                    'field' => $attributes['dynamicACFField'],
                    'location' => $location,
                );
            } else if (cc_attribute_checker($attributes, 'dynamic', 'true') && $attributes['dynamic'] === 'woocartitems') {
                $contenter = array(
                    'source' => 'woocartitems',
                );
            } else if (cc_attribute_checker($attributes, 'dynamic', 'true') && $attributes['dynamic'] === 'woocartitemvariation') {
                $contenter = array(
                    'source' => 'woocartitemvariation',
                );
            } else if (cc_attribute_checker($attributes, 'dynamic', 'true') && $attributes['dynamic'] === 'woocrosssellproducts') {
                $contenter = array(
                    'source' => 'woocrosssellproducts',
                );
            } else if (cc_attribute_checker($attributes, 'dynamic', 'true') && $attributes['dynamic'] === 'woovariable') {
                $contenter = array(
                    'source' => 'woovariable',
                );
            } else if (cc_attribute_checker($attributes, 'dynamic', 'true') && $attributes['dynamic'] === 'woogrouped') {
                $contenter = array(
                    'source' => 'woogrouped',
                );
            } else if (cc_attribute_checker($attributes, 'dynamic', 'true') && $attributes['dynamic'] === 'woogallery') {
                $contenter = array(
                    'source' => 'woogallery',
                );
            }

            if (cc_attribute_checker($attributes, 'repeaterSlider', 'true')) {
                $contenter['repeaterSlider'] = true;
                if (cc_attribute_checker($attributes, 'repeaterSliderOptionsR', 'true')) {
                    $contenter['repeaterSliderOptionsR'] = $attributes['repeaterSliderOptionsR'];
                }
                if (cc_attribute_checker($attributes, 'repeaterSliderOptions', 'true')) {
                    $contenter['repeaterSliderOptions'] = $attributes['repeaterSliderOptions'];
                }
            }
            return $contenter;
        }
    }

    private function taxonomy_terms($attributes, $blockName)
    {
        if ($blockName === 'cwicly/taxonomyterms') {
            $contenter = array();
            if (cc_attribute_checker($attributes, 'taxtermsSource', 'true')) {
                $contenter['taxtermsSource'] = $attributes['taxtermsSource'];
            }
            if (cc_attribute_checker($attributes, 'taxtermsNumber', 'true')) {
                $contenter['taxtermsNumber'] = $attributes['taxtermsNumber'];
            }
            if (cc_attribute_checker($attributes, 'taxtermsPostType', 'true')) {
                $contenter['taxtermsPostType'] = $attributes['taxtermsPostType'];
            }
            if (cc_attribute_checker($attributes, 'taxtermsTaxonomies', 'true')) {
                $contenter['taxtermsTaxonomies'] = $attributes['taxtermsTaxonomies'];
            }
            if (cc_attribute_checker($attributes, 'taxtermsExclude', 'true')) {
                $contenter['taxtermsExclude'] = $attributes['taxtermsExclude'];
            }
            if (cc_attribute_checker($attributes, 'taxtermsInclude', 'true')) {
                $contenter['taxtermsInclude'] = $attributes['taxtermsInclude'];
            }
            if (cc_attribute_checker($attributes, 'taxtermsExcludeCurrent', 'true')) {
                $contenter['taxtermsExcludeCurrent'] = $attributes['taxtermsExcludeCurrent'];
            }
            if (cc_attribute_checker($attributes, 'taxtermsOrderBy', 'true')) {
                $contenter['taxtermsOrderBy'] = $attributes['taxtermsOrderBy'];
            }
            if (cc_attribute_checker($attributes, 'taxtermsOrderDirection', 'true')) {
                $contenter['taxtermsOrderDirection'] = $attributes['taxtermsOrderDirection'];
            }
            if (cc_attribute_checker($attributes, 'taxtermsHideEmpty', 'true')) {
                $contenter['taxtermsHideEmpty'] = $attributes['taxtermsHideEmpty'];
            }
            if (cc_attribute_checker($attributes, 'repeaterMasonry', 'true')) {
                $contenter['repeaterMasonry'] = $attributes['repeaterMasonry'];
            }
            return $contenter;
        }
    }

    private function accordions($attributes)
    {
        $contenter = array();
        if (cc_attribute_checker($attributes, 'accordionLinked', 'true') && $attributes['accordionLinked'] && cc_attribute_checker($attributes, 'accordionGroup', 'true') && $attributes['accordionGroup']) {
            $contenter['accordionGroup'] = $attributes['accordionGroup'];
        }
        return $contenter;
    }

    private function accordion($attributes)
    {
        $contenter = array();
        if (cc_attribute_checker($attributes, 'accordionLinked', 'true') && $attributes['accordionLinked'] && cc_attribute_checker($attributes, 'accordionGroup', 'true') && $attributes['accordionGroup']) {
            $contenter['accordionGroup'] = $attributes['accordionGroup'];
        }
        return $contenter;
    }

    private function tab($attributes)
    {
        $contenter = array();
        if (cc_attribute_checker($attributes, 'tabContentActive', 'true') && $attributes['tabContentActive']) {
            $contenter['tabContentActive'] = $attributes['tabContentActive'];
        }
        return $contenter;
    }

    private function tabList($attributes)
    {
        $contenter = array();
        if (cc_attribute_checker($attributes, 'tabContentsID', 'true') && $attributes['tabContentsID']) {
            $contenter['tabContentsID'] = $attributes['tabContentsID'];
        }
        return $contenter;
    }

    private function tabContent($attributes)
    {
        $contenter = array();
        if (cc_attribute_checker($attributes, 'tabContentActive', 'true') && $attributes['tabContentActive']) {
            $contenter['tabContentActive'] = $attributes['tabContentActive'];
        }
        return $contenter;
    }

    private function popover($attributes)
    {
        $contenter = array();
        if (cc_attribute_checker($attributes, 'popoverOptions', 'true') && $attributes['popoverOptions']) {
            $contenter['popoverOptions'] = $attributes['popoverOptions'];
        }
        return $contenter;
    }

    private function swatch($attributes)
    {
        $contenter = array();
        if (cc_attribute_checker($attributes, 'swatchSlug', 'true') && $attributes['swatchSlug']) {
            $contenter['slug'] = $attributes['swatchSlug'];
        }
        if (cc_attribute_checker($attributes, 'swatchType', 'true') && $attributes['swatchType']) {
            $contenter['type'] = $attributes['swatchType'];
        }
        if (cc_attribute_checker($attributes, 'swatchText', 'true') && $attributes['swatchText']) {
            $contenter['text'] = $attributes['swatchText'];
        }
        return $contenter;
    }

    private function tooltip($attributes)
    {
        $contenter = array();
        if (cc_attribute_checker($attributes, 'tooltipActive', 'true') && $attributes['tooltipActive']) {
            $contenter['tooltipActive'] = $attributes['tooltipActive'];
        }
        if (cc_attribute_checker($attributes, 'tooltipSource', 'true') && $attributes['tooltipSource']) {
            $contenter['tooltipSource'] = $attributes['tooltipSource'];
        }
        if (cc_attribute_checker($attributes, 'tooltipACFGroup', 'true') && $attributes['tooltipACFGroup']) {
            $contenter['tooltipACFGroup'] = $attributes['tooltipACFGroup'];
        }
        if (cc_attribute_checker($attributes, 'tooltipACFField', 'true') && $attributes['tooltipACFField']) {
            $contenter['tooltipACFField'] = $attributes['tooltipACFField'];
        }
        if (cc_attribute_checker($attributes, 'tooltipCustom', 'true') && $attributes['tooltipCustom']) {
            $contenter['tooltipCustom'] = $attributes['tooltipCustom'];
        }
        if (cc_attribute_checker($attributes, 'tooltipExtra', 'true') && $attributes['tooltipExtra']) {
            $contenter['tooltipExtra'] = $attributes['tooltipExtra'];
        }
        if (cc_attribute_checker($attributes, 'dynamicWordPressExtra', 'true') && $attributes['dynamicWordPressExtra']) {
            $contenter['dynamicWordPressExtra'] = $attributes['dynamicWordPressExtra'];
        }
        if (cc_attribute_checker($attributes, 'tooltipContent', 'true') && $attributes['tooltipContent']) {
            $contenter['tooltipContent'] = $attributes['tooltipContent'];
        }
        if (cc_attribute_checker($attributes, 'tooltipArrow', 'true') && $attributes['tooltipArrow']) {
            $contenter['tooltipArrow'] = $attributes['tooltipArrow'];
        }
        if (cc_attribute_checker($attributes, 'tooltipAnimation', 'true') && $attributes['tooltipAnimation']) {
            $contenter['tooltipAnimation'] = $attributes['tooltipAnimation'];
        }
        if (cc_attribute_checker($attributes, 'tooltiphideclick', 'true') && $attributes['tooltiphideclick']) {
            $contenter['tooltiphideclick'] = $attributes['tooltiphideclick'];
        }
        if (cc_attribute_checker($attributes, 'tooltipplace', 'true') && $attributes['tooltipplace']) {
            $contenter['tooltipplace'] = $attributes['tooltipplace'];
        }
        if (cc_attribute_checker($attributes, 'tooltipduration', 'true') && $attributes['tooltipduration']) {
            $contenter['tooltipduration'] = $attributes['tooltipduration'];
        }
        if (cc_attribute_checker($attributes, 'tooltipfollow', 'true') && $attributes['tooltipfollow']) {
            $contenter['tooltipfollow'] = $attributes['tooltipfollow'];
        }
        if (cc_attribute_checker($attributes, 'tooltipTheme', 'true') && $attributes['tooltipTheme']) {
            $contenter['tooltipTheme'] = $attributes['tooltipTheme'];
        }
        return $contenter;
    }
}
