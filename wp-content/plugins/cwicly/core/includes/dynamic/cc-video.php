<?php

/**
 * Cwicly Video
 *
 * Functions for creating and managing Videos
 *
 * @package Cwicly\Functions
 * @version 1.1
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function cc_video_url($attributes, $field)
{
    $embedURL = '';
    if (strpos(get_field($field), 'youtube') > 0) {
        $branding = 0;
        if (isset($attributes['videoBranding']) && $attributes['videoBranding']) {
            $branding = 1;
        }
        $youtubeURL = 'youtube';
        if (isset($attributes['videoPrivacy']) && $attributes['videoPrivacy']) {
            $youtubeURL = 'youtube-nocookie';
        }
        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", get_field($attributes['videoDynamicAcfField']), $vidid);
        $embedURL = 'https://www.youtube.com/embed/' . $vidid[1] . '?modestbranding=' . $branding . '';
        if (isset($attributes['videoStart']) && $attributes['videoStart']) {
            $embedURL .= '&start=' . $attributes['videoStart'] . '';
        }
        if (isset($attributes['videoEnd']) && $attributes['videoEnd']) {
            $embedURL .= '&end=' . $attributes['videoEnd'] . '';
        }
        if (isset($attributes['videoAutoplay']) && $attributes['videoAutoplay']) {
            $embedURL .= '&autoplay=1';
        }
        if (isset($attributes['videoMute']) && $attributes['videoMute']) {
            $embedURL .= '&mute=1';
        }
        if (isset($attributes['videoLoop']) && $attributes['videoLoop']) {
            $embedURL .= '&loop=1';
        }
        if (isset($attributes['videoControls']) && !$attributes['videoControls']) {
            $embedURL .= '&controls=0';
        }
    } elseif (strpos(get_field($field), 'vimeo') > 0) {
        preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', get_field($attributes['videoDynamicAcfField']), $vidid);
        $embedURL = 'https://player.vimeo.com/video/' . $vidid[3] . '?transparent=1';
        if (isset($attributes['videoStart']) && $attributes['videoStart']) {
            $embedURL .= '&#t=' . $attributes['videoStart'] . '';
        }
        if (isset($attributes['videoAutoplay']) && $attributes['videoAutoplay']) {
            $embedURL .= '&autoplay=true';
        }
        if (isset($attributes['videoMute']) && $attributes['videoMute']) {
            $embedURL .= '&muted=1';
        }
        if (isset($attributes['videoLoop']) && $attributes['videoLoop']) {
            $embedURL .= '&loop=1';
        }
        if (isset($attributes['videoPrivacy']) && $attributes['videoPrivacy']) {
            $embedURL .= '&dnt=1';
        }
    } elseif (get_field($field)) {
        $embedURL = get_field($field);
    }
    return $embedURL;
}

function cc_video_final_maker_v2($attributes)
{
    $embedURL = '';
    $final = '';
    if (isset($attributes['videoType']) && $attributes['videoType'] === 'dynamic') {
        if (isset($attributes['videoDynamicType']) && $attributes['videoDynamicType'] === 'acf') {
            if (isset($attributes['videoDynamicAcfGroup']) && $attributes['videoDynamicAcfGroup']) {
                if (isset($attributes['videoDynamicAcfField']) && $attributes['videoDynamicAcfField']) {
                    if (strpos(get_field($attributes['videoDynamicAcfField']), 'youtube') > 0) {
                        $branding = 0;
                        if (isset($attributes['videoBranding']) && $attributes['videoBranding']) {
                            $branding = 1;
                        }
                        $youtubeURL = 'youtube';
                        if (isset($attributes['videoPrivacy']) && $attributes['videoPrivacy']) {
                            $youtubeURL = 'youtube-nocookie';
                        }
                        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", get_field($attributes['videoDynamicAcfField']), $vidid);
                        $embedURL = 'https://www.youtube.com/embed/' . $vidid[1] . '?modestbranding=' . $branding . '';
                        if (isset($attributes['videoStart']) && $attributes['videoStart']) {
                            $embedURL .= '&start=' . $attributes['videoStart'] . '';
                        }
                        if (isset($attributes['videoEnd']) && $attributes['videoEnd']) {
                            $embedURL .= '&end=' . $attributes['videoEnd'] . '';
                        }
                        if (isset($attributes['videoAutoplay']) && $attributes['videoAutoplay']) {
                            $embedURL .= '&autoplay=1';
                        }
                        if (isset($attributes['videoMute']) && $attributes['videoMute']) {
                            $embedURL .= '&mute=1';
                        }
                        if (isset($attributes['videoLoop']) && $attributes['videoLoop']) {
                            $embedURL .= '&loop=1';
                        }
                        if (isset($attributes['videoControls']) && !$attributes['videoControls']) {
                            $embedURL .= '&controls=0';
                        }
                        // $final .= '<div id="' . $attributes['id'] . '-videoe-iframe" class="cc-iframe-container">';
                        $final .= '<div class="cc-iframe-container">';
                        if (isset($attributes['videoImageOverlay']) && $attributes['videoImageOverlay']) {
                            $final .= '<iframe width="560" height="315" src="' . $embedURL . '" srcdoc="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                        } else {
                            $final .= '<iframe width="560" height="315" src="' . $embedURL . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                        }
                        $final .= '</div>';
                    } elseif (strpos(get_field($attributes['videoDynamicAcfField']), 'vimeo') > 0) {
                        preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', get_field($attributes['videoDynamicAcfField']), $vidid);
                        $embedURL = 'https://player.vimeo.com/video/' . $vidid[3] . '?transparent=1';
                        if (isset($attributes['videoStart']) && $attributes['videoStart']) {
                            $embedURL .= '&#t=' . $attributes['videoStart'] . '';
                        }
                        if (isset($attributes['videoAutoplay']) && $attributes['videoAutoplay']) {
                            $embedURL .= '&autoplay=true';
                        }
                        if (isset($attributes['videoMute']) && $attributes['videoMute']) {
                            $embedURL .= '&muted=1';
                        }
                        if (isset($attributes['videoLoop']) && $attributes['videoLoop']) {
                            $embedURL .= '&loop=1';
                        }
                        if (isset($attributes['videoPrivacy']) && $attributes['videoPrivacy']) {
                            $embedURL .= '&dnt=1';
                        }
                        // $final .= '<div id="' . $attributes['id'] . '-videoe-iframe" class="cc-iframe-container">';
                        $final .= '<div class="cc-iframe-container">';
                        if (isset($attributes['videoImageOverlay']) && $attributes['videoImageOverlay']) {
                            $final .= '<iframe width="560" height="315" src="' . $embedURL . '" srcdoc="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                        } else {
                            $final .= '<iframe width="560" height="315" src="' . $embedURL . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                        }
                        $final .= '</div>';
                    } elseif (get_field($attributes['videoDynamicAcfField'])) {
                        $embedURL = get_field($attributes['videoDynamicAcfField']);
                        $autoPlay = '';
                        $mute = '';
                        $loop = '';
                        $controls = '';
                        $dataAutoplay = '';
                        if (isset($attributes['videoAutoplay']) && $attributes['videoAutoplay']) {
                            $autoPlay = 'autoplay';
                            $dataAutoplay = 'data-autoplay';
                        }
                        if (isset($attributes['videoMute']) && $attributes['videoMute']) {
                            $mute = 'muted="muted"';
                        }
                        if (isset($attributes['videoLoop']) && $attributes['videoLoop']) {
                            $loop = 'loop';
                        }
                        if (isset($attributes['videoControls']) && $attributes['videoControls']) {
                            $controls = 'controls';
                        }
                        if (isset($attributes['videoImageOverlay']) && $attributes['videoImageOverlay']) {
                            // $final .= '<iframe width="560" height="315" src="' . $embedURL . '" srcdoc="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                            $final .= '<video id="' . $attributes['id'] . '-videoe-local"></video>';
                        } else {
                            $final = '<video id="' . $attributes['id'] . '-videoe-local" src="' . $embedURL . '" ' . $autoPlay . ' ' . $loop . ' ' . $mute . ' ' . $controls . ' ' . $dataAutoplay . ' controlslist="nodownload" >Sorry, your browser doesn\'t support embedded videos.</video>';
                        }
                    }
                }
            }
        }
    }
    return $final;
}
