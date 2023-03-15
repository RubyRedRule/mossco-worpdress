<?php

namespace Cwicly;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


class CCPostBlocks
{
    /**
     * @param \WP_Post|int $post
     * @param callable     $callback
     *
     * @return string
     */
    public static function getNewContent($post, $callback)
    {
        // $post    = get_post($post);
        $content = $post->post_content;

        if (has_blocks($post->post_content)) {
            $blocks       = parse_blocks($post->post_content);
            $parsedBlocks = self::parseBlocks($blocks, $callback);

            $content = serialize_blocks($parsedBlocks);
        }

        return $content;
    }

    /**
     * @param \WP_Block_Parser_Block[]|array[] $blocks
     * @param callable                 $callback
     *
     * @return \WP_Block_Parser_Block[]
     */
    protected static function parseBlocks($blocks, $callback): array
    {
        $allBlocks = [];

        foreach ($blocks as $block) {
            // Go into inner blocks and run this method recursively
            if (!empty($block['innerBlocks'])) {
                $block['innerBlocks'] = self::parseBlocks($block['innerBlocks'], $callback);
            }

            // Make sure that is a valid block (some block names may be NULL)
            if (!empty($block['blockName'])) {
                $allBlocks[] = $callback($block); // the magic is here...
                continue;
            }

            // Continuously create back the blocks array.
            $allBlocks[] = $block;
        }

        return $allBlocks;
    }
}
