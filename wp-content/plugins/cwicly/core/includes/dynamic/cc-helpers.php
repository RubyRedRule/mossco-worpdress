<?php

/**
 * Cwicly Helpers
 *
 * Functions for creating and managing all Cwicly mains
 *
 * @package Cwicly\Functions
 * @version 1.1
 */

/**
 * Cwicly Helpers
 *
 * Query Prev-Next linker
 *
 * @package Cwicly\Functions
 * @version 1.1
 */
function cc_block_query_prev_next($block, $type)
{
    if (!is_admin()) {
        $content = '';

        $page = 0;
        if (isset($block->context['queryPageKey']) && $block->context['queryPageKey']) {
            $page = empty($_GET[$block->context['queryPageKey']]) ? 1 : (int) $_GET[$block->context['queryPageKey']];
        }
        $total = 0;
        if (isset($block->context['queryTotal'])) {
            $total = $block->context['queryTotal'];
        }

        if ($type === 'prev') {
            if (isset($block->context['queryInherit']) && $block->context['queryInherit']) {
                global $paged;
                if ($paged === 0) {
                } else {
                    $content = previous_posts(false);
                }
            } else if ($page - 1 > 0) {
                $content = esc_url(add_query_arg($block->context['queryPageKey'], $page - 1));
            }
        } else if ($type === 'next') {
            if (isset($block->context['queryInherit']) && $block->context['queryInherit']) {
                if ($total) {
                    $content = next_posts($total, false);
                }
            } else {
                $nextpage = (int) $page + 1;
                if ($nextpage <= $total) {
                    $content = esc_url(add_query_arg($block->context['queryPageKey'], $page + 1));
                }
            }
        }
        return $content;
    }
}

/**
 * Cwicly Helpers
 *
 * Query Preparation for Arguments on Frontend
 *
 * @package Cwicly\Functions
 * @version 1.1
 */
function cc_query_front_args($attributes, $returnparams, $block)
{
    if (!is_admin()) { // Needed otherwise error on the backend
        $queryType = $attributes['queryType'];
        $postId = get_the_ID();

        $queryMaxItems = isset($attributes['queryMaxItems']) ? $attributes['queryMaxItems'] : '';

        $querySticky = isset($attributes['querySticky']) ? $attributes['querySticky'] : '';
        $queryPage = isset($attributes['queryPage']) ? $attributes['queryPage'] : '';
        $queryPostType = isset($attributes['queryPostType']) ? $attributes['queryPostType'] : '';
        $queryPerPage = isset($attributes['queryPerPage']) ? $attributes['queryPerPage'] : '';
        $queryOffset = isset($attributes['queryOffset']) ? $attributes['queryOffset'] : '';
        $queryExcludeCurrent = isset($attributes['queryExcludeCurrent']) ? $attributes['queryExcludeCurrent'] : '';
        $queryOrderBy = isset($attributes['queryOrderBy']) ? $attributes['queryOrderBy'] : '';
        $queryMetaKey = isset($attributes['queryMetaKey']) ? $attributes['queryMetaKey'] : '';
        $queryOrder = isset($attributes['queryOrder']) ? $attributes['queryOrder'] : '';
        $queryInclude = isset($attributes['queryInclude']) ? $attributes['queryInclude'] : '';
        $queryExclude = isset($attributes['queryExclude']) ? $attributes['queryExclude'] : '';
        $queryPostParent = isset($attributes['queryPostParent']) ? $attributes['queryPostParent'] : '';
        $queryInParent = isset($attributes['queryInParent']) ? $attributes['queryInParent'] : '';
        $queryNotInParent = isset($attributes['queryNotInParent']) ? $attributes['queryNotInParent'] : '';
        $queryTaxonomy = isset($attributes['queryTaxonomy']) ? $attributes['queryTaxonomy'] : '';
        $queryMeta = isset($attributes['queryMeta']) ? $attributes['queryMeta'] : '';
        $queryTaxonomyRelation = isset($attributes['queryTaxonomyRelation']) ? $attributes['queryTaxonomyRelation'] : '';
        $queryMetaRelation = isset($attributes['queryMetaRelation']) ? $attributes['queryMetaRelation'] : '';
        $queryPassword = isset($attributes['queryPassword']) ? $attributes['queryPassword'] : '';
        $queryPostPassword = isset($attributes['queryPostPassword']) ? $attributes['queryPostPassword'] : '';
        $queryAuthor = isset($attributes['queryAuthor']) ? $attributes['queryAuthor'] : '';
        $queryAuthorName = isset($attributes['queryAuthorName']) ? $attributes['queryAuthorName'] : '';
        $queryAuthorIn = isset($attributes['queryAuthorIn']) ? $attributes['queryAuthorIn'] : '';
        $queryAuthorNotIn = isset($attributes['queryAuthorNotIn']) ? $attributes['queryAuthorNotIn'] : '';
        $querySearch = isset($attributes['querySearch']) ? $attributes['querySearch'] : '';
        $queryPostStatus = isset($attributes['queryPostStatus']) ? $attributes['queryPostStatus'] : '';
        $queryCommentCount = isset($attributes['queryCommentCount']) ? $attributes['queryCommentCount'] : '';
        $queryCommentCompare = isset($attributes['queryCommentCompare']) ? $attributes['queryCommentCompare'] : '';
        $queryPerm = isset($attributes['queryPerm']) ? $attributes['queryPerm'] : '';
        $queryMimeType = isset($attributes['queryMimeType']) ? $attributes['queryMimeType'] : '';
        $queryDate = isset($attributes['queryDate']) ? $attributes['queryDate'] : '';
        $queryDateRelation = isset($attributes['queryDateRelation']) ? $attributes['queryDateRelation'] : '';

        $queryTaxonomies = isset($attributes['queryTaxonomies']) ? $attributes['queryTaxonomies'] : '';
        $queryObjectIDs = isset($attributes['queryObjectIDs']) ? $attributes['queryObjectIDs'] : '';
        $queryHideEmpty = isset($attributes['queryHideEmpty']) ? $attributes['queryHideEmpty'] : '';
        $queryCount = isset($attributes['queryCount']) ? $attributes['queryCount'] : '';
        $queryPadCount = isset($attributes['queryPadCount']) ? $attributes['queryPadCount'] : '';
        $queryExcludeTree = isset($attributes['queryExcludeTree']) ? $attributes['queryExcludeTree'] : '';
        $queryNumber = isset($attributes['queryNumber']) ? $attributes['queryNumber'] : '';
        $queryFields = isset($attributes['queryFields']) ? $attributes['queryFields'] : '';
        $queryName = isset($attributes['queryName']) ? $attributes['queryName'] : '';
        $querySlug = isset($attributes['querySlug']) ? $attributes['querySlug'] : '';
        $queryHierarchical = isset($attributes['queryHierarchical']) ? $attributes['queryHierarchical'] : '';
        $queryNameLike = isset($attributes['queryNameLike']) ? $attributes['queryNameLike'] : '';
        $queryDescriptionLike = isset($attributes['queryDescriptionLike']) ? $attributes['queryDescriptionLike'] : '';
        $queryGet = isset($attributes['queryGet']) ? $attributes['queryGet'] : '';
        $queryChildOf = isset($attributes['queryChildOf']) ? $attributes['queryChildOf'] : '';
        $queryParent = isset($attributes['queryParent']) ? $attributes['queryParent'] : '';
        $queryChildless = isset($attributes['queryChildless']) ? $attributes['queryChildless'] : '';

        $queryRole = isset($attributes['queryRole']) ? $attributes['queryRole'] : '';
        $queryRoleIn = isset($attributes['queryRoleIn']) ? $attributes['queryRoleIn'] : '';
        $queryRoleNotIn = isset($attributes['queryRoleNotIn']) ? $attributes['queryRoleNotIn'] : '';
        $queryBlogID = isset($attributes['queryBlogID']) ? $attributes['queryBlogID'] : '';
        $querySearchColumn = isset($attributes['querySearchColumn']) ? $attributes['querySearchColumn'] : '';
        $queryWho = isset($attributes['queryWho']) ? $attributes['queryWho'] : '';
        $queryTotalCount = isset($attributes['queryTotalCount']) ? $attributes['queryTotalCount'] : '';
        $queryHasPublished = isset($attributes['queryHasPublished']) ? $attributes['queryHasPublished'] : '';

        $queryCommentParent = isset($attributes['queryCommentParent']) ? $attributes['queryCommentParent'] : '';
        $queryCommentInParent = isset($attributes['queryCommentInParent']) ? $attributes['queryCommentInParent'] : '';
        $queryCommentNotParent = isset($attributes['queryCommentNotParent']) ? $attributes['queryCommentNotParent'] : '';
        $queryCommentPostID = isset($attributes['queryCommentPostID']) ? $attributes['queryCommentPostID'] : '';
        $queryCommentID = isset($attributes['queryCommentID']) ? $attributes['queryCommentID'] : '';
        $queryCommentNotID = isset($attributes['queryCommentNotID']) ? $attributes['queryCommentNotID'] : '';
        $queryCommentIncludeUnapproved = isset($attributes['queryCommentIncludeUnapproved']) ? $attributes['queryCommentIncludeUnapproved'] : '';
        $queryCommentKarma = isset($attributes['queryCommentKarma']) ? $attributes['queryCommentKarma'] : '';
        $queryAuthorEmail = isset($attributes['queryAuthorEmail']) ? $attributes['queryAuthorEmail'] : '';
        $queryAuthorURL = isset($attributes['queryAuthorURL']) ? $attributes['queryAuthorURL'] : '';
        $queryCommentAuthorIn = isset($attributes['queryCommentAuthorIn']) ? $attributes['queryCommentAuthorIn'] : '';
        $queryCommentAuthorNotIn = isset($attributes['queryCommentAuthorNotIn']) ? $attributes['queryCommentAuthorNotIn'] : '';

        $queryWooType = isset($attributes['queryWooType']) ? $attributes['queryWooType'] : '';
        $queryWooParentExclude = isset($attributes['queryWooParentExclude']) ? $attributes['queryWooParentExclude'] : '';
        $queryWooSKU = isset($attributes['queryWooSKU']) ? $attributes['queryWooSKU'] : '';
        $queryWooTag = isset($attributes['queryWooTag']) ? $attributes['queryWooTag'] : '';
        $queryWooCategory = isset($attributes['queryWooCategory']) ? $attributes['queryWooCategory'] : '';
        $queryWooWidth = isset($attributes['queryWooWidth']) ? $attributes['queryWooWidth'] : '';
        $queryWooHeight = isset($attributes['queryWooHeight']) ? $attributes['queryWooHeight'] : '';
        $queryWooWeight = isset($attributes['queryWooWeight']) ? $attributes['queryWooWeight'] : '';
        $queryWooLength = isset($attributes['queryWooLength']) ? $attributes['queryWooLength'] : '';
        $queryWooPrice = isset($attributes['queryWooPrice']) ? $attributes['queryWooPrice'] : '';
        $queryWooRegularPrice = isset($attributes['queryWooRegularPrice']) ? $attributes['queryWooRegularPrice'] : '';
        $queryWooSalePrice = isset($attributes['queryWooSalePrice']) ? $attributes['queryWooSalePrice'] : '';
        $queryWooTotalSales = isset($attributes['queryWooTotalSales']) ? $attributes['queryWooTotalSales'] : '';
        $queryWooVirtual = isset($attributes['queryWooVirtual']) ? $attributes['queryWooVirtual'] : '';
        $queryWooDownloadable = isset($attributes['queryWooDownloadable']) ? $attributes['queryWooDownloadable'] : '';
        $queryWooFeatured = isset($attributes['queryWooFeatured']) ? $attributes['queryWooFeatured'] : '';
        $queryWooSoldIndividually = isset($attributes['queryWooSoldIndividually']) ? $attributes['queryWooSoldIndividually'] : '';
        $queryWooManageStock = isset($attributes['queryWooManageStock']) ? $attributes['queryWooManageStock'] : '';
        $queryWooReviewsAllowed = isset($attributes['queryWooReviewsAllowed']) ? $attributes['queryWooReviewsAllowed'] : '';
        $queryWooBackorders = isset($attributes['queryWooBackorders']) ? $attributes['queryWooBackorders'] : '';
        $queryWooVisibility = isset($attributes['queryWooVisibility']) ? $attributes['queryWooVisibility'] : '';
        $queryWooStockQuantity = isset($attributes['queryWooStockQuantity']) ? $attributes['queryWooStockQuantity'] : '';
        $queryWooStockStatus = isset($attributes['queryWooStockStatus']) ? $attributes['queryWooStockStatus'] : '';
        $queryWooTaxStatus = isset($attributes['queryWooTaxStatus']) ? $attributes['queryWooTaxStatus'] : '';
        $queryWooTaxClass = isset($attributes['queryWooTaxClass']) ? $attributes['queryWooTaxClass'] : '';
        $queryWooShippingClass = isset($attributes['queryWooShippingClass']) ? $attributes['queryWooShippingClass'] : '';
        $queryWooDownloadLimit = isset($attributes['queryWooDownloadLimit']) ? $attributes['queryWooDownloadLimit'] : '';
        $queryWooDownloadExpiry = isset($attributes['queryWooDownloadExpiry']) ? $attributes['queryWooDownloadExpiry'] : '';
        $queryWooAverageRating = isset($attributes['queryWooAverageRating']) ? $attributes['queryWooAverageRating'] : '';
        $queryWooReviewCount = isset($attributes['queryWooReviewCount']) ? $attributes['queryWooReviewCount'] : '';
        $queryWooDateCreated = isset($attributes['queryWooDateCreated']) ? $attributes['queryWooDateCreated'] : '';
        $queryWooDateModified = isset($attributes['queryWooDateModified']) ? $attributes['queryWooDateModified'] : '';
        $queryWooDateOnSaleFrom = isset($attributes['queryWooDateOnSaleFrom']) ? $attributes['queryWooDateOnSaleFrom'] : '';
        $queryWooDateOnSaleTo = isset($attributes['queryWooDateOnSaleTo']) ? $attributes['queryWooDateOnSaleTo'] : '';

        $blockContext = array();

        if (isset($block->context)) {
            $blockContext = $block->context;
        }

        $args_class = new CC_Query_Args($blockContext);
        $args = $args_class->cc_query_preparation(
            $queryType,
            $postId,

            $queryMaxItems,

            $querySticky,
            $queryPage,
            $queryPostType,
            $queryPerPage,
            $queryOffset,
            $queryExcludeCurrent,
            $queryMetaKey,
            $queryOrderBy,
            $queryOrder,
            $queryInclude,
            $queryExclude,
            $queryPostParent,
            $queryInParent,
            $queryNotInParent,
            $queryTaxonomy,
            $queryMeta,
            $queryTaxonomyRelation,
            $queryMetaRelation,
            $queryPassword,
            $queryPostPassword,
            $queryAuthor,
            $queryAuthorName,
            $queryAuthorIn,
            $queryAuthorNotIn,
            $querySearch,
            $queryPostStatus,
            $queryCommentCount,
            $queryCommentCompare,
            $queryPerm,
            $queryMimeType,
            $queryDate,
            $queryDateRelation,

            $queryTaxonomies,
            $queryObjectIDs,
            $queryHideEmpty,
            $queryCount,
            $queryPadCount,
            $queryExcludeTree,
            $queryNumber,
            $queryFields,
            $queryName,
            $querySlug,
            $queryHierarchical,
            $queryNameLike,
            $queryDescriptionLike,
            $queryGet,
            $queryChildOf,
            $queryParent,
            $queryChildless,

            $queryRole,
            $queryRoleIn,
            $queryRoleNotIn,
            $queryBlogID,
            $querySearchColumn,
            $queryWho,
            $queryTotalCount,
            $queryHasPublished,

            $queryCommentParent,
            $queryCommentInParent,
            $queryCommentNotParent,
            $queryCommentPostID,
            $queryCommentID,
            $queryCommentNotID,
            $queryCommentIncludeUnapproved,
            $queryCommentKarma,
            $queryAuthorEmail,
            $queryAuthorURL,
            $queryCommentAuthorIn,
            $queryCommentAuthorNotIn,

            $queryWooType,
            $queryWooParentExclude,
            $queryWooSKU,
            $queryWooTag,
            $queryWooCategory,
            $queryWooWidth,
            $queryWooHeight,
            $queryWooWeight,
            $queryWooLength,
            $queryWooPrice,
            $queryWooRegularPrice,
            $queryWooSalePrice,
            $queryWooTotalSales,
            $queryWooVirtual,
            $queryWooDownloadable,
            $queryWooFeatured,
            $queryWooSoldIndividually,
            $queryWooManageStock,
            $queryWooReviewsAllowed,
            $queryWooBackorders,
            $queryWooVisibility,
            $queryWooStockQuantity,
            $queryWooStockStatus,
            $queryWooTaxStatus,
            $queryWooTaxClass,
            $queryWooShippingClass,
            $queryWooDownloadLimit,
            $queryWooDownloadExpiry,
            $queryWooAverageRating,
            $queryWooReviewCount,
            $queryWooDateCreated,
            $queryWooDateModified,
            $queryWooDateOnSaleFrom,
            $queryWooDateOnSaleTo,
            $returnparams
        );
        return $args;
    }
}

function cc_query_front_prep($attributes, $block)
{
    // $max_page = isset($attributes['queryPerPage']['field']) ? (int) $attributes['queryPerPage']['field'] : 0;
    // NOT USED
    $max_page = '';

    $query_args = cc_query_front_args($attributes, false, $block);

    // MAKE TAX AND META IF EMPTY
    if (isset($query_args['tax_query'])) {
        foreach ($query_args['tax_query'] as $index => $tax_query) {
            if ($index !== 'relation') {
                if (is_string($index)) {
                    if (!isset($tax_query->terms) || (isset($tax_query->terms) && !$tax_query->terms)) {
                        if ($index !== 'relation') {
                            $query_args['tax_query']->$index->operator = 'XXX';
                        }
                    }
                } else {
                    if (!isset($tax_query['terms']) || (isset($tax_query['terms']) && !$tax_query['terms'])) {
                        if ($index !== 'relation') {$query_args['tax_query'][$index]['operator'] = 'XXX';
                        }
                    }
                }
            }
        }
    }
    if (isset($query_args['meta_query'])) {
        foreach ($query_args['meta_query'] as $index => $meta_query) {
            if ($index !== 'relation') {
                if (is_string($index)) {
                    if (!isset($meta_query->value) || !Cwicly\Helpers::check_if_exists($meta_query->value)) {
                        if ($index !== 'relation') {
                            $query_args['meta_query']->$index->value = [];
                        }
                    }
                } else {
                    if (!isset($meta_query['value']) || !Cwicly\Helpers::check_if_exists($meta_query['value'])) {
                        if ($index !== 'relation') {$query_args['meta_query'][$index]['value'] = [];
                        }
                    }
                }
            }
        }
    }
    // MAKE TAX AND META IF EMPTY

    $starting_offset = '';
    if (isset($query_args['offset']) && $query_args['offset']) {
        $starting_offset = $query_args['offset'];
    }

    if (isset($attributes['queryPage']['field']) && $attributes['queryPage']['field']) {
        $page_key = $attributes['queryPage']['field'];
    } else {
        $page_key = isset($attributes['queryId']) ? 'query-' . $attributes['queryId'] . '-page' : 'query-page';
        if (empty($_GET[$page_key])) {
            $query_args['paged'] = 1;
            $query_args['page'] = 1;
        } else {
            $query_args['paged'] = (int) $_GET[$page_key];
            $query_args['page'] = (int) $_GET[$page_key];
        }
    }

    // FOR OFFSETING CORRECTLY
    if (isset($query_args['offset']) && $query_args['offset']) {
        if (isset($query_args['paged']) && $query_args['paged']) {
            if (isset($query_args['posts_per_page']) && $query_args['posts_per_page']) {
                $query_args['offset'] = (intval($query_args['posts_per_page']) * (intval($query_args['paged']) - 1)) + (intval($query_args['offset']));
            } else {
                $default_posts_per_page = get_option('posts_per_page');
                $query_args['offset'] = (intval($default_posts_per_page) * (intval($query_args['paged']) - 1)) + (intval($query_args['offset']));
            }
        }
    } else if (($attributes['queryType'] === 'terms' || $attributes['queryType'] === 'users') && isset($query_args['number']) && $query_args['number'] && isset($query_args['offset']) && $query_args['offset']) {
        if (isset($query_args['paged']) && $query_args['paged']) {
            $query_args['offset'] = (intval($query_args['number']) * (intval($query_args['paged']) - 1)) + (intval($query_args['offset']));
        }
    } else if (($attributes['queryType'] === 'terms' || $attributes['queryType'] === 'users') && isset($query_args['number']) && $query_args['number']) {
        if (isset($query_args['paged']) && $query_args['paged']) {
            $query_args['offset'] = (intval($query_args['number']) * (intval($query_args['paged']) - 1));
        }
    }
    // FOR OFFSETING CORRECTLY

    // Override the custom query with the global query if needed.
    $use_global_query = (isset($attributes['queryInherit']) && $attributes['queryInherit']);
    if ($use_global_query) {
        global $wp_query;
        if ($wp_query && isset($wp_query->query_vars) && is_array($wp_query->query_vars)) {
            unset($query_args['offset']);
            $query_args = wp_parse_args($wp_query->query_vars, $query_args);

            if (empty($query_args['post_type']) && is_singular()) {
                $query_args['post_type'] = get_post_type(get_the_ID());
            }
        }
    }

    $query = '';
    if ($attributes['queryType'] === 'posts') {
        $query = new WP_Query($query_args);
    } else if ($attributes['queryType'] === 'terms') {
        $query = new WP_Term_Query($query_args);
    } else if ($attributes['queryType'] === 'users') {
        $query = new WP_User_Query($query_args);
    } else if ($attributes['queryType'] === 'comments') {
        $query = new WP_Comment_Query($query_args);
    } else if (CC_WOOCOMMERCE && $attributes['queryType'] === 'products') {
        $query = new WC_Product_Query($query_args);

        $query_args['paginate'] = true;
        $wcquery = wc_get_products($query_args);
    }

    $has_posts = false;
    if (!Cwicly\Helpers::is_rest()) {
        if (CC_WOOCOMMERCE && $attributes['queryType'] === 'products' && $wcquery && isset($wcquery->products) && count($wcquery->products) > 0) {
            $has_posts = true;
        } else if ($attributes['queryType'] === 'terms' && $query && isset($query->terms) && count($query->terms) > 0) {
            $has_posts = true;
        } else if ($attributes['queryType'] === 'users' && $query && isset($query->results) && count($query->results) > 0) {
            $has_posts = true;
        } else if ($attributes['queryType'] === 'comments' && $query && isset($query->comments) && count($query->comments) > 0) {
            $has_posts = true;
        } else if ($attributes['queryType'] === 'posts' && $query->have_posts()) {
            $has_posts = true;
        }
    }

    $total = '';
    if ($attributes['queryType'] === 'products' && isset($query_args['limit']) && $query_args['limit'] && isset($query_args['offset']) && $query_args['offset']) {
        $total_rows = max(0, $query->found_posts - $starting_offset);
        $total = ceil($total_rows / $query_args['limit']);
    } else if (isset($query_args['posts_per_page']) && $query_args['posts_per_page'] && isset($query_args['offset']) && $query_args['offset']) {
        $total_rows = max(0, $query->found_posts - $starting_offset);
        $total = ceil($total_rows / $query_args['posts_per_page']);
    } else if ($attributes['queryType'] === 'terms' && isset($query_args['number']) && $query_args['number']) {
        $new_query_args = $query_args;
        $new_query_args['fields'] = 'ids';
        $new_query_args['number'] = '';
        $queryForCount = new WP_Term_Query($new_query_args);
        $count = count($queryForCount->terms);
        $total = ceil($count / $query_args['number']);
    } else if ($attributes['queryType'] === 'users' && isset($query_args['number']) && $query_args['number']) {
        $total = ceil($query->total_users / $query_args['number']);
    } else if ($attributes['queryType'] === 'comments' && isset($query_args['number']) && $query_args['number']) {
        $new_query_args = $query_args;
        $new_query_args['fields'] = 'ids';
        $new_query_args['number'] = '';
        $queryForCount = new WP_Comment_Query($new_query_args);
        $count = count($queryForCount->comments);
        $total = ceil($count / $query_args['number']);
    } else if (CC_WOOCOMMERCE && $attributes['queryType'] === 'products') {
        $total = !$max_page || $max_page > $wcquery->max_num_pages ? $wcquery->max_num_pages : $max_page;
    } else if ($attributes['queryType'] != 'terms') {
        $total = isset($query) && $query && (!$max_page || $max_page > $query->max_num_pages) ? $query->max_num_pages : $max_page;
    } else if ($attributes['queryType'] === 'terms') {
        $default_posts_per_page = get_option('posts_per_page');
        $new_query_args = $query_args;
        $new_query_args['fields'] = 'ids';
        $queryForCount = new WP_Term_Query($new_query_args);
        $count = count($queryForCount->terms);
        $total = ceil($count / $default_posts_per_page);
    } else {
        $total = !$max_page || $max_page > $query->max_num_pages ? $query->max_num_pages : $max_page;
    }

    $content = '';

    $page = empty($_GET[$page_key]) ? 1 : (int) $_GET[$page_key];
    $paginate_args = array(
        'base' => str_replace('%_%', 1 == $page ? '' : "?$page_key=%#%", "?$page_key=%#%"),
        'format' => "?$page_key=%#%",
        'current' => max(1, $page),
        'total' => $total,
        'prev_next' => false,
    );

    if (isset($block->parsed_block['innerBlocks']) && $block->parsed_block['innerBlocks']) {
        foreach ($block->parsed_block['innerBlocks'] as $innerBlock) {
            $content .= (new WP_Block(
                $innerBlock,
                array(
                    'queryId' => isset($attributes['queryId']) && $attributes['queryId'] ? $attributes['queryId'] : 0,
                    'queryRendered' => $query,
                    'queryTotal' => $total,
                    'queryPageKey' => $page_key,
                    'paginateArgs' => $paginate_args,
                    'queryType' => $attributes['queryType'],
                    'queryInherit' => $attributes['queryInherit'],
                    'queryPage' => $page,
                    'rendered' => true,
                    'hasPosts' => $has_posts,
                )
            ))->render(array('dynamic' => true));
        }
    }
    return array(
        'content' => $content,
        'hasPosts' => $has_posts,
    );
}

function cc_query_front_maker($attributes, $block)
{
    $mason = '';
    if (isset($attributes['repeaterMasonry']) && $attributes['repeaterMasonry']) {
        $mason = ' cc-masonry-item';
    }

    $content = '';
    $query = '';

    if (isset($block->context['queryRendered']) && $block->context['queryRendered']) {
        $query = $block->context['queryRendered'];
    }

    if (!is_admin() && $query) {
        if ($block->context['queryType'] === 'posts') {
            if ($query && $query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $block_content = '';
                    foreach ($block->parsed_block['innerBlocks'] as $innerBlock) {
                        $block_content .= (new WP_Block(
                            $innerBlock,
                            array(
                                'postType' => get_post_type(),
                                'postId' => get_the_ID(),
                                'query_index' => $query->current_post + 1,
                                'queryId' => $block->context['queryId'],
                                'rendered' => true,
                            )
                        ))->render(array('dynamic' => true));
                    }
                    $lastQuery = '';
                    if ($query->current_post + 1 == $query->post_count) {
                        if (isset($block->context['queryPage']) && $block->context['queryPage'] && is_integer($block->context['queryPage'])) {
                            $lastQuery = ' data-lastpost="' . $block->context['queryPage'] . '"';
                        }
                    }
                    if (isset($attributes['repeaterSlider']) && $attributes['repeaterSlider']) {
                        $content .= '<li class="splide__slide">' . $block_content . '</li>';
                    } else {
                        $content .= '<div class="cc-query-item' . $mason . '"' . $lastQuery . '>' . $block_content . '</div>';
                    }
                    // $content .= "\n<div class=\"cc-query$mason\"$lastQuery>$block_content</div>\n";
                }
                wp_reset_postdata();
            }
        } else if ($block->context['queryType'] === 'terms') {
            if ($query->terms && !empty($query->terms)) {
                foreach ($query->terms as $index => $term) {
                    $block_content = '';
                    foreach ($block->parsed_block['innerBlocks'] as $innerBlock) {
                        $block_content .= (new WP_Block(
                            $innerBlock,
                            array(
                                'postType' => get_post_type(),
                                'postId' => get_the_ID(),
                                'query_index' => $index + 1,
                                'queryId' => $block->context['queryId'],
                                'termQuery' => $term,
                                'rendered' => true,
                            )
                        ))->render(array('dynamic' => true));
                    }
                    $lastQuery = '';
                    // if ($query->current_post + 1 == $query->post_count) {
                    //     $lastQuery = ' data-lastpost=' . $page . '';
                    // }

                    if (isset($attributes['repeaterSlider']) && $attributes['repeaterSlider']) {
                        $content .= '<li class="splide__slide">' . $block_content . '</li>';
                    } else {
                        $content .= '<div class="cc-query-item' . $mason . '"' . $lastQuery . '>' . $block_content . '</div>';
                    }
                }
            }
        } else if ($block->context['queryType'] === 'comments') {
            if ($query->comments && !empty($query->comments)) {
                $content .= wp_list_comments(array('walker' => new Cwicly_Comment_Walker, 'callback' => 'cc_comment_list', 'echo' => false, 'style' => 'div', 'status' => $query->query_vars['status'], 'mason' => $mason, 'queryId' => $block->context['queryId'], 'innerBlocks' => $block->parsed_block['innerBlocks']), $query->comments);
            }
        } else if ($block->context['queryType'] === 'users') {
            $result = $query->get_results();
            if ($result) {
                if (!empty($result)) {
                    foreach ($result as $index => $user) {
                        $block_content = '';
                        foreach ($block->parsed_block['innerBlocks'] as $innerBlock) {
                            $block_content .= (new WP_Block(
                                $innerBlock,
                                array(
                                    'postType' => get_post_type(),
                                    'postId' => get_the_ID(),
                                    'query_index' => $index + 1,
                                    'queryId' => $block->context['queryId'],

                                    'userQuery' => $user,
                                    'rendered' => true,
                                )
                            ))->render(array('dynamic' => true));
                        }
                        $lastQuery = '';
                        // if ($query->current_post + 1 == $query->post_count) {
                        //     $lastQuery = ' data-lastpost=' . $page . '';
                        // }
                        if (isset($attributes['repeaterSlider']) && $attributes['repeaterSlider']) {
                            $content .= '<li class="splide__slide">' . $block_content . '</li>';
                        } else {
                            $content .= '<div class="cc-query-item' . $mason . '"' . $lastQuery . '>' . $block_content . '</div>';
                        }
                    }
                }
            }
        } else if ($block->context['queryType'] === 'products') {
            if ($query) {
                $products = $query->get_products();

                foreach ($products as $index => $product) {

                    global $post;
                    $post = get_post($product->get_id());

                    $type = ' data-cc-woo-type="' . $product->get_type() . '"';
                    $id = ' data-cc-id="' . $product->get_id() . '"';
                    $variations = [];
                    $default_variations = [];
                    if ($product->get_type() === 'variable' && $product->get_attributes()) {
                        $attributers = array_keys($product->get_attributes());
                        $default_attributes = $product->get_default_attributes();
                        foreach ($attributers as $attribute) {
                            if (isset($default_attributes[$attribute])) {
                                $default_variations[$attribute] = $default_attributes[$attribute];
                            } else {
                                $default_variations[$attribute] = '';
                            }
                        }
                        $variations = ' data-cc-woo-variations="' . htmlspecialchars(wp_json_encode($product->get_available_variations())) . '"';
                        $default_variations = ' data-cc-woo-default-variations="' . htmlspecialchars(wp_json_encode($default_variations)) . '"';
                        // $variations = ' data-cc-woo-variations="' . implode(',', array_keys($product->get_attributes())) . '"';
                    } else {
                        $variations = '';
                        $default_variations = '';
                    }

                    $block_content = '';
                    if (isset($block->parsed_block['innerBlocks']) && $block->parsed_block['innerBlocks']) {
                        foreach ($block->parsed_block['innerBlocks'] as $innerBlock) {
                            $block_content .= (new WP_Block(
                                $innerBlock,
                                array(
                                    'postType' => get_post_type(),
                                    'postId' => $product->get_id(),
                                    'product' => $product,
                                    'query_index' => $index + 1,
                                    'queryId' => $block->context['queryId'],
                                    'return' => 'ids',
                                    'rendered' => true,
                                )
                            ))->render(array('dynamic' => true));
                        }
                    }
                    $lastQuery = '';
                    // $content .= "\n<div class=\"cc-query$mason\"$type$id$variations$default_variations$lastQuery>$block_content</div>\n";

                    if (isset($attributes['repeaterSlider']) && $attributes['repeaterSlider']) {
                        $content .= '<li class="splide__slide"' . $type . $id . $variations . $default_variations . $lastQuery . '>' . $block_content . '</li>';
                    } else {
                        $content .= '<div class="cc-query-item' . $mason . '"' . $type . $id . $variations . $default_variations . $lastQuery . '>' . $block_content . '</div>';
                    }
                }
                wp_reset_postdata();
            }
        }
    }

    return $content;
}

function cc_comment_list($comment, $args, $depth)
{
    if ($comment->comment_approved === '1' || $args['status'] === 'hold' || $args['status'] === 'all' || ($comment->comment_approved === '0' && isset(wp_get_current_commenter()['comment_author_email']) && wp_get_current_commenter()['comment_author_email'] === $comment->comment_author_email)) {
        $id = 'comment-' . $comment->comment_ID . '';
        $div = '';
        $close_div = '';
        // if ($depth > 1) {
        //     $div = '<div class="cc-query-child">';
        //     // $close_div = '</div>';
        // } else {
        //     $div = '<div class="cc-query">';
        //     // $close_div = '</div>';
        // }
        // $comment_class = ' ' . comment_class(array('cc-query', $mason), $comment) . '';
        $comment_class = comment_class(array("cc-query{$args['mason']}"), $comment, '', false);
        $block_content = '';
        foreach ($args['innerBlocks'] as $innerBlock) {
            $block_content .= (new WP_Block(
                $innerBlock,
                array(
                    'postType' => get_post_type(),
                    'postId' => get_the_ID(),
                    // 'query_index' => $index + 1,
                    'queryId' => $args['queryId'],
                    'commentQuery' => $comment,
                    'rendered' => true,
                )
            ))->render(array('dynamic' => true));
        }
        $lastQuery = '';
        // if ($query->current_post + 1 == $query->post_count) {
        //     $lastQuery = ' data-lastpost=' . $page . '';
        // }
        echo "\n$div<div id=\"$id\" $comment_class$lastQuery>$block_content</div>$close_div\n";
    }
}

class Cwicly_Comment_Walker extends Walker_Comment
{

    public function start_el(&$output, $comment, $depth = 0, $args = array(), $id = 0)
    {
        $depth++;
        $GLOBALS['comment_depth'] = $depth;
        // $GLOBALS['comment'] = $comment;

        if (!empty($args['callback'])) {
            if ($depth === 1) {
                switch ($args['style']) {
                    case 'div':
                        $output .= '<div class="cc-query">' . "\n";
                        break;
                }
            }
            ob_start();
            call_user_func($args['callback'], $comment, $args, $depth);
            $output .= ob_get_clean();
            return;
        }
    }

    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        $GLOBALS['comment_depth'] = $depth + 1;

        switch ($args['style']) {
            case 'div':
                $output .= '<div class="cc-query-child">' . "\n";
                break;
        }
    }
    public function end_lvl(&$output, $depth = 0, $args = array())
    {
        $GLOBALS['comment_depth'] = $depth + 1;

        switch ($args['style']) {
            case 'div':
                $output .= "</div>\n";
                break;
        }
    }
    public function end_el(&$output, $data_object, $depth = 0, $args = array())
    {
        $depth++;
        if ($depth === 1) {
            if ($output && 'div' === $args['style']) {
                $output .= "</div>\n";
            }
        }
    }
    protected function comment($comment, $depth, $args)
    {
    }
}

function cc_query_comment_tree($comments)
{
    $final = [];
    foreach ($comments as $c) {
        if (!$c->comment_parent) {
            $final[$c->comment_ID] = $c;
            $final[$c->comment_ID]->childrener = $c->get_children();
        }
    }
    foreach ($comments as $c) {
        if (!empty($final[$c->comment_ID]->childrener)) {
            cc_query_comment_tree_recur($final[$c->comment_ID]->childrener, $final[$c->comment_ID]->childrener);
        }
    }
    return $final;
}

function cc_query_comment_tree_recur($comments, $final)
{
    foreach ($comments as $c) {
        $final[$c->comment_ID]->childrener = $c->get_children();
    }
    foreach ($comments as $c) {
        if (!empty($final[$c->comment_ID]->childrener)) {
            cc_query_comment_tree_recur($final[$c->comment_ID]->childrener, $final[$c->comment_ID]->childrener);
        }
    }
}

function cc_acf_field_processor($field, $fallback, $attributes, $blockName, $frontendRender = false, $options = array(), $field_object = null)
{
    if ($field) {
        if (is_array($field)) {
            if (isset($field['url'])) {
                if ($blockName === 'cwicly/image' && isset($field['width']) && isset($field['height'])) {
                    $width = $field['width'];
                    $height = $field['height'];
                    $url = $field['url'];
                    $alt = $field['alt'];
                    $finalAlt = '';
                    if (isset($options[1]) && $alt && $options[1] === '1') {
                        $finalAlt = '" alt="' . $alt . '';
                    }
                    $srcset = '';
                    $finalSrcSet = '';
                    $size = '';
                    if (isset($options[2]) && $options[2] === '1' && $field['id']) {
                        $srcset = wp_get_attachment_image_srcset($field['id']);
                        if ($srcset) {
                            $finalSrcSet = '" srcset="' . $srcset . '';
                        }
                    }
                    if (isset($options[0]) && $options[0] && $options[0] != '0' && $field['sizes'] && isset($field['sizes'][$options[0]])) {
                        if ($field['sizes'][$options[0]]) {
                            $url = $field['sizes'][$options[0]];
                            $height = $field['sizes'][$options[0] . '-height'];
                            $width = $field['sizes'][$options[0] . '-width'];
                            $size = '" sizes="' . wp_get_attachment_image_sizes($field['id'], $options[0]) . '';
                        }
                    }
                    if (!$frontendRender) {
                        return '' . $url . '" height="' . $height . '" width="' . $width . $finalAlt . $finalSrcSet . $size . '';
                    } else {
                        $size = '';
                        if (isset($options[0]) && $options[0]) {
                            $size = wp_get_attachment_image_sizes($field['id'], $options[0]);
                            $height = $field['sizes'][$options[0] . '-height'];
                            $width = $field['sizes'][$options[0] . '-width'];
                        } else {
                            $size = wp_get_attachment_image_sizes($field['id']);
                        }
                        return array(
                            'url' => $url,
                            'width' => $width,
                            'height' => $height,
                            'alt' => $alt,
                            'srcset' => $srcset,
                            'size' => $size,
                        );
                    }
                } else {
                    if (isset($options[0])) {
                        if ($options[0] === 'isVideo') {
                            return \Cwicly\Helpers::get_dynamic_video_url($attributes, $field);
                        } else if ($options[0] === 'isVideoOverlay') {
                            return \Cwicly\Helpers::get_dynamic_video_overlay_url($attributes, $field);
                        }
                    }
                    return $field['url'];
                }
            } else if (isset($options[0]) && $options[0] === 'isFEConditions') {
                if ($field_object && $field_object['type'] === 'checkbox') {
                    if ($field_object['return_format'] === 'value' || $field_object['return_format'] === 'label') {
                        return implode(',', $field);
                    } else if ($field_object['return_format'] === 'array') {
                        $final = array();
                        foreach ($field as $f) {
                            $final[] = $f['value'];
                        }
                        return implode(',', $final);
                    }
                }
            }
        } else if (isset($field)) {
            if (is_object($field)) {
                if (isset($field->ID)) {
                    return get_permalink($field->ID);
                }
            } else {
                if (isset($options[0])) {
                    if ($options[0] === 'isVideo') {
                        return \Cwicly\Helpers::get_dynamic_video_url($attributes, $field);
                    } else if ($options[0] === 'isVideoOverlay') {
                        return \Cwicly\Helpers::get_dynamic_video_overlay_url($attributes, $field);
                    }
                }
                return $field;
            }
        } else if ($fallback && $fallback !== 'false') {
            if (is_numeric($fallback) && $blockName === 'cwicly/image') {
                return wp_get_attachment_url($fallback);
            } else {
                return $fallback;
            }
        }
    } else if ($fallback && $fallback !== 'false') {
        if (is_numeric($fallback) && $blockName === 'cwicly/image') {
            return wp_get_attachment_url($fallback);
        } else {
            return $fallback;
        }
    }
}

function cc_condition_checker($conditions)
{
    global $post;
    $templater = '';
    $final = [];
    $conditions = json_encode($conditions);
    $conditions = json_decode($conditions);
    if (isset($conditions) && isset($conditions->include) && $conditions->include) {
        foreach ($conditions->include as $template => $value) {
            $customTemplate = [];
            $send = [];
            if ($value->all === 'true') {
                $send[] = 'true';
            }
            if (sizeof($value->singular) > 0) {
                foreach ($value->singular as $condition) {
                    $uniqueSend = false;
                    if (isset($condition->target) && $condition->target) {
                        if ($condition->target === 'all') {
                            if (is_404()) {
                                $uniqueSend = 'true';
                            }
                            if (is_front_page()) {
                                $uniqueSend = 'true';
                            }
                            if (is_singular()) {
                                $uniqueSend = 'true';
                            }
                        } else {
                            if ($condition->target === '404') {
                                if (is_404()) {
                                    $uniqueSend = 'true';
                                } else {
                                    $uniqueSend = 'false';
                                }
                            } else if ($condition->target === 'frontPage') {
                                if (is_front_page()) {
                                    $uniqueSend = 'true';
                                } else {
                                    $uniqueSend = 'false';
                                }
                            } else if (is_singular()) {
                                if ($condition->target && is_singular($condition->target)) {
                                    if (!isset($condition->data) || ($condition->data && $condition->data === 'all')) {
                                        $uniqueSend = 'true';
                                    } else {
                                        $uniqueSend = 'false';
                                    }
                                    if (isset($condition->data) && $condition->data && $condition->data != 'all') {
                                        if (!isset($condition->data) || ($condition->data && $condition->data === 'directchildof')) {
                                            $parent_id = get_the_ID();
                                            $parent_page = wp_get_post_parent_id($parent_id);
                                            if (isset($condition->extra) && $parent_page == $condition->extra) {
                                                $uniqueSend = 'true';
                                            } else {
                                                $uniqueSend = 'false';
                                            }
                                        } else if (!isset($condition->extra) || ($condition->extra && $condition->extra === 'all')) {
                                            if (!is_array($condition->data) && has_term('', $condition->data)) {
                                                $uniqueSend = 'true';
                                            } else if (is_array($condition->data)) {
                                                foreach ($condition->data as $data) {
                                                    if ($post->ID === $data) {
                                                        $uniqueSend = 'true';
                                                    }
                                                }
                                            } else {
                                                $uniqueSend = 'false';
                                            }
                                        } else if (isset($condition->extra) && $condition->extra && $condition->extra != 'all') {
                                            if (has_term($condition->extra, $condition->data)) {
                                                $uniqueSend = 'true';
                                            } else {
                                                $uniqueSend = 'false';
                                            }
                                            if (isset($condition->extraData) && $condition->extraData && $condition->extraData != 'all') {
                                                if ($condition->extraData === get_the_ID()) {
                                                    $uniqueSend = 'true';
                                                } else {
                                                    $uniqueSend = 'false';
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $send[] = $uniqueSend;
                }
            }
            if (sizeof($value->archive) > 0) {
                foreach ($value->archive as $condition) {
                    $uniqueSend = false;

                    if ($condition->target === 'search' && is_search()) {
                        $uniqueSend = 'true';
                    }
                    if (is_archive()) {
                        if (isset($condition->target) && $condition->target) {
                            $postType = get_taxonomy(get_queried_object()->taxonomy)->object_type[0];
                            if ($condition->target === 'all') {
                                $uniqueSend = 'true';
                            } else if ((!isset($condition->data) || ($condition->data && $condition->data === 'all')) && $postType === $condition->target) {
                                $uniqueSend = 'true';
                            } else if ($postType === $condition->target && isset($condition->data) && $condition->data === get_queried_object()->taxonomy && (!isset($condition->extra) || ($condition->extra && $condition->extra === 'all'))) {
                                $uniqueSend = 'true';
                            } else if ($postType === $condition->target && isset($condition->data) && $condition->data === get_queried_object()->taxonomy && isset($condition->extra) && $condition->extra === get_queried_object()->term_id) {
                                $uniqueSend = 'true';
                            }
                        }
                    }
                    $send[] = $uniqueSend;
                }
            }
            if (sizeof($value->author) > 0) {
                foreach ($value->author as $condition) {
                    $uniqueSend = false;
                    if ($condition === true) {
                        $uniqueSend = 'true';
                    } else if (isset($condition->target) && $condition->target && $post->post_author && intval($post->post_author) === $condition->target) {
                        $uniqueSend = 'true';
                    }
                    $send[] = $uniqueSend;
                }
            }
            if (sizeof($value->custom) > 0) {
                $current_user = wp_get_current_user();
                foreach ($value->custom as $condition) {
                    $uniqueSend = false;
                    $conditioner = '';
                    if ($condition->target === 'date') {
                        $conditioner = date("m/d/Y");
                    }
                    if ($condition->target === 'dayweek') {
                        $conditioner = date("l");
                    }
                    if ($condition->target === 'daymonth') {
                        $conditioner = date("d");
                    }
                    if ($condition->target === 'time') {
                        $conditioner = date("H:i:s");
                    }
                    if ($condition->target === 'username') {
                        $conditioner = $current_user->user_login;
                    }
                    if ($condition->target === 'userid') {
                        $conditioner = strval($current_user->ID);
                    }
                    if ($condition->target === 'usercapabilities') {
                        if (current_user_can($condition->extraData)) {
                            $conditioner = 'true';
                        }
                    }
                    if ($condition->target === 'urlparameter') {
                        if (isset($condition->key) && $condition->key) {
                            if (isset($_GET[$condition->key]) && $_GET[$condition->key]) {
                                $key = htmlspecialchars($_GET[$condition->key], ENT_QUOTES, 'UTF-8');
                                if ($condition->extra === 'true' || $condition->extra === 'false') {
                                    $conditioner = filter_var($key, FILTER_VALIDATE_BOOLEAN);
                                } else {
                                    $conditioner = $key;
                                }
                            }
                        }
                    }
                    switch ($condition->extra) {
                        case "===":
                            if ($condition->target === 'cookie') {
                                $loop = true;
                                foreach ($_COOKIE as $key => $val) {
                                    if ($key === $condition->extraData) {
                                        $uniqueSend = 'true';
                                        $loop = false;
                                        break;
                                    }
                                }
                                if ($loop) {
                                    $uniqueSend = 'false';
                                }
                            } else if ($condition->target === 'dayweek') {
                                $date_now = strtotime('today');
                                $date_compared = strtotime('' . $condition->extraData . ' this week');
                                if ($date_now === $date_compared) {
                                    $uniqueSend = 'true';
                                }
                            } else if ($condition->target === 'userrole') {
                                if (in_array($condition->extraData, $current_user->roles, true)) {
                                    $uniqueSend = 'true';
                                }
                            } else if ($condition->target === 'usercapabilities') {
                                if (current_user_can($condition->extraData)) {
                                    $uniqueSend = 'true';
                                }
                            } else if ($condition->target === 'acf') {
                                if (isset($condition->group) && isset($condition->field)) {
                                    $location = false;
                                    if (isset($condition->acfLocation)) {
                                        if ($condition->acfLocation === 'currentpost') {
                                            $location = get_the_ID();
                                        } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                            $location = $condition->acfLocationID;
                                        } else if ($condition->acfLocation === 'currentuser') {
                                            $location = 'user_' . get_current_user_id() . '';
                                        } else if ($condition->acfLocation === 'currentauthor') {
                                            $location = 'user_' . get_the_author_meta('ID') . '';
                                        } else if ($condition->acfLocation === 'option') {
                                            $location = 'option';
                                        } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                            $term = get_term($condition->acfLocationID->value);
                                            $location = $term->taxonomy . '_' . $term->term_id;
                                        } else if (isset($condition->acfLocationID)) {
                                            $location = $condition->acfLocationID;
                                        }
                                    }

                                    $field = get_field($condition->field, $location);
                                    if (is_array($field)) {
                                        $field = implode(" ", $field);
                                    } else {
                                        $field = strval($field);
                                    }

                                    if ($field === $condition->extraData) {
                                        $uniqueSend = 'true';
                                    }
                                }
                            } else {
                                if ($conditioner === $condition->extraData) {
                                    $uniqueSend = 'true';
                                }
                            }
                            break;
                        case "!=":
                            if ($condition->target === 'cookie') {
                                $loop = true;
                                foreach ($_COOKIE as $key => $val) {
                                    if ($key === $condition->extraData) {
                                        $uniqueSend = 'false';
                                        $loop = false;
                                        break;
                                    }
                                }
                                if ($loop) {
                                    $uniqueSend = 'true';
                                }
                            } else if ($condition->target === 'dayweek') {
                                $date_now = strtotime('today');
                                $date_compared = strtotime('' . $condition->extraData . ' this week');
                                if ($date_now != $date_compared) {
                                    $uniqueSend = 'true';
                                }
                            } else if ($condition->target === 'userrole') {
                                if (!in_array($condition->extraData, $current_user->roles, true)) {
                                    $uniqueSend = 'true';
                                }
                            } else if ($condition->target === 'usercapabilities') {
                                if (!current_user_can($condition->extraData)) {
                                    $uniqueSend = 'true';
                                }
                            } else if ($condition->target === 'acf') {
                                if (isset($condition->group) && isset($condition->field)) {
                                    $location = false;
                                    if (isset($condition->acfLocation)) {
                                        if ($condition->acfLocation === 'currentpost') {
                                            $location = get_the_ID();
                                        } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                            $location = $condition->acfLocationID;
                                        } else if ($condition->acfLocation === 'currentuser') {
                                            $location = 'user_' . get_current_user_id() . '';
                                        } else if ($condition->acfLocation === 'currentauthor') {
                                            $location = 'user_' . get_the_author_meta('ID') . '';
                                        } else if ($condition->acfLocation === 'option') {
                                            $location = 'option';
                                        } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                            $term = get_term($condition->acfLocationID->value);
                                            $location = $term->taxonomy . '_' . $term->term_id;
                                        } else if (isset($condition->acfLocationID)) {
                                            $location = $condition->acfLocationID;
                                        }
                                    }

                                    $field = get_field($condition->field, $location);
                                    if (is_array($field)) {
                                        $field = implode(" ", $field);
                                    } else {
                                        $field = strval($field);
                                    }

                                    if ($field != $condition->extraData) {
                                        $uniqueSend = 'true';
                                    }
                                }
                            } else {
                                if ($conditioner != $condition->extraData) {
                                    $uniqueSend = 'true';
                                }
                            }
                            break;
                        case "contains":
                            if ($condition->target === 'cookie') {
                                $loop = true;
                                foreach ($_COOKIE as $key => $val) {
                                    if (strpos($key, $condition->extraData) !== false) {
                                        $uniqueSend = 'true';
                                        $loop = false;
                                        break;
                                    }
                                }
                                if ($loop) {
                                    $uniqueSend = 'false';
                                }
                            } else {
                                if (strpos($conditioner, $condition->extraData) !== false) {
                                    $uniqueSend = 'true';
                                }
                            }
                            break;
                        case "notcontain":
                            if ($condition->target === 'cookie') {
                                $loop = true;
                                foreach ($_COOKIE as $key => $val) {
                                    if (strpos($key, $condition->extraData) === false) {
                                        $uniqueSend = 'true';
                                        $loop = false;
                                        break;
                                    }
                                }
                                if ($loop) {
                                    $uniqueSend = 'false';
                                }
                            } else {
                                if (strpos($conditioner, $condition->extraData) === false) {
                                    $uniqueSend = 'true';
                                }
                            }
                            break;
                        case "before":
                            if ($condition->target === 'dayweek') {
                                $date_now = strtotime('today');
                                $date_compared = strtotime('' . $condition->extraData . ' this week');
                                if ($date_now < $date_compared) {
                                    $uniqueSend = 'true';
                                }
                            } else {
                                if ($conditioner < $condition->extraData) {
                                    $uniqueSend = 'true';
                                }
                            }
                            break;
                        case "after":
                            if ($condition->target === 'dayweek') {
                                $date_now = strtotime('today');
                                $date_compared = strtotime('' . $condition->extraData . ' this week');
                                if ($date_now > $date_compared) {
                                    $uniqueSend = 'true';
                                }
                            } else {
                                if ($conditioner > $condition->extraData) {
                                    $uniqueSend = 'true';
                                }
                            }
                            break;
                        case "<":
                            if ($conditioner < $condition->extraData) {
                                $uniqueSend = 'true';
                            }
                            break;
                        case ">":
                            if ($conditioner > $condition->extraData) {
                                $uniqueSend = 'true';
                            }
                            break;
                        case ">=":
                            if ($conditioner >= $condition->extraData) {
                                $uniqueSend = 'true';
                            }
                            break;
                        case "<=":
                            if ($conditioner <= $condition->extraData) {
                                $uniqueSend = 'true';
                            }
                            break;
                        case "empty":
                            if ($condition->target === 'acf' && isset($condition->extraData)) {
                                if (isset($condition->group) && isset($condition->field)) {
                                    $location = false;
                                    if (isset($condition->acfLocation)) {
                                        if ($condition->acfLocation === 'currentpost') {
                                            $location = get_the_ID();
                                        } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                            $location = $condition->acfLocationID;
                                        } else if ($condition->acfLocation === 'currentuser') {
                                            $location = 'user_' . get_current_user_id() . '';
                                        } else if ($condition->acfLocation === 'currentauthor') {
                                            $location = 'user_' . get_the_author_meta('ID') . '';
                                        } else if ($condition->acfLocation === 'option') {
                                            $location = 'option';
                                        } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                            $term = get_term($condition->acfLocationID->value);
                                            $location = $term->taxonomy . '_' . $term->term_id;
                                        } else if (isset($condition->acfLocationID)) {
                                            $location = $condition->acfLocationID;
                                        }
                                    }

                                    $field = get_field($condition->field, $location);
                                    if (is_array($field)) {
                                        $field = implode(" ", $field);
                                    } else {
                                        $field = strval($field);
                                    }

                                    if (empty($field)) {
                                        $uniqueSend = 'true';
                                    }
                                }
                            }
                            break;
                        case "notempty":
                            if ($condition->target === 'acf') {
                                if (isset($condition->group) && isset($condition->field)) {
                                    $location = false;
                                    if (isset($condition->acfLocation)) {
                                        if ($condition->acfLocation === 'currentpost') {
                                            $location = get_the_ID();
                                        } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                            $location = $condition->acfLocationID;
                                        } else if ($condition->acfLocation === 'currentuser') {
                                            $location = 'user_' . get_current_user_id() . '';
                                        } else if ($condition->acfLocation === 'currentauthor') {
                                            $location = 'user_' . get_the_author_meta('ID') . '';
                                        } else if ($condition->acfLocation === 'option') {
                                            $location = 'option';
                                        } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                            $term = get_term($condition->acfLocationID->value);
                                            $location = $term->taxonomy . '_' . $term->term_id;
                                        } else if (isset($condition->acfLocationID)) {
                                            $location = $condition->acfLocationID;
                                        }
                                    }

                                    $field = get_field($condition->field, $location);
                                    if (is_array($field)) {
                                        $field = implode(" ", $field);
                                    } else {
                                        $field = strval($field);
                                    }

                                    if (!empty($field)) {
                                        $uniqueSend = 'true';
                                    }
                                }
                            }
                            break;
                        case "true":
                            if ($condition->target === 'shortcode') {
                                $shortcode = do_shortcode('[' . $condition->extraData . ']');
                                if ($shortcode) {
                                    $uniqueSend = 'true';
                                }
                            } else if ($condition->target === 'acf') {
                                if (isset($condition->group) && isset($condition->field)) {
                                    $location = false;
                                    if (isset($condition->acfLocation)) {
                                        if ($condition->acfLocation === 'currentpost') {
                                            $location = get_the_ID();
                                        } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                            $location = $condition->acfLocationID;
                                        } else if ($condition->acfLocation === 'currentuser') {
                                            $location = 'user_' . get_current_user_id() . '';
                                        } else if ($condition->acfLocation === 'currentauthor') {
                                            $location = 'user_' . get_the_author_meta('ID') . '';
                                        } else if ($condition->acfLocation === 'option') {
                                            $location = 'option';
                                        } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                            $term = get_term($condition->acfLocationID->value);
                                            $location = $term->taxonomy . '_' . $term->term_id;
                                        } else if (isset($condition->acfLocationID)) {
                                            $location = $condition->acfLocationID;
                                        }
                                    }

                                    $field = get_field($condition->field, $location);
                                    if (is_array($field)) {
                                        $field = $field[0];
                                    } else {
                                        $field = strval($field);
                                    }
                                    if (boolval($field) === true) {
                                        $uniqueSend = 'true';
                                    } else {
                                        $uniqueSend = 'false';
                                    }
                                }
                            }
                            break;
                        case "false":
                            if ($condition->target === 'shortcode') {
                                $shortcode = do_shortcode('[' . $condition->extraData . ']');
                                if (!$shortcode) {
                                    $uniqueSend = 'true';
                                }
                            } else if ($condition->target === 'acf') {
                                if (isset($condition->group) && isset($condition->field)) {
                                    $location = false;
                                    if (isset($condition->acfLocation)) {
                                        if ($condition->acfLocation === 'currentpost') {
                                            $location = get_the_ID();
                                        } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                            $location = $condition->acfLocationID;
                                        } else if ($condition->acfLocation === 'currentuser') {
                                            $location = 'user_' . get_current_user_id() . '';
                                        } else if ($condition->acfLocation === 'currentauthor') {
                                            $location = 'user_' . get_the_author_meta('ID') . '';
                                        } else if ($condition->acfLocation === 'option') {
                                            $location = 'option';
                                        } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                            $term = get_term($condition->acfLocationID->value);
                                            $location = $term->taxonomy . '_' . $term->term_id;
                                        } else if (isset($condition->acfLocationID)) {
                                            $location = $condition->acfLocationID;
                                        }
                                    }

                                    $field = get_field($condition->field, $location);
                                    if (is_array($field)) {
                                        $field = $field[0];
                                    } else {
                                        $field = strval($field);
                                    }
                                    if (boolval($field) === false) {
                                        $uniqueSend = 'true';
                                    } else {
                                        $uniqueSend = 'false';
                                    }
                                }
                            }
                            break;
                    }
                    $send[] = $uniqueSend;
                }
            }
            if (isset($value->includeCondition) && $value->includeCondition && $value->includeCondition === 'and' && array_unique($send) == array('true')) {
                $customTemplate[] = get_block_template(get_stylesheet() . '//' . $template, 'wp_template_part');
                $templater = $template;
                // break;
            } else if (isset($value->includeCondition) && $value->includeCondition && $value->includeCondition === 'or' && in_array("true", $send)) {
                $customTemplate[] = get_block_template(get_stylesheet() . '//' . $template, 'wp_template_part');
                $templater = $template;
                // break;
            }

            $exclude = [];
            $noExclude = [];
            if ($templater && $conditions->exclude->$templater) {
                $value = $conditions->exclude->$templater;
                if ($value->all === 'true') {
                    $exclude[] = 'true';
                    $noExclude[] = 'false';
                } else {
                    $noExclude[] = 'true';
                }
                if (sizeof($value->singular) > 0) {
                    foreach ($value->singular as $condition) {
                        $uniqueSend = 'false';
                        if (isset($condition->target) && $condition->target) {
                            if ($condition->target === 'all') {
                                if (is_404()) {
                                    $uniqueSend = 'true';
                                }
                                if (is_front_page()) {
                                    $uniqueSend = 'true';
                                }
                                if (is_singular()) {
                                    $uniqueSend = 'true';
                                }
                            } else {
                                if ($condition->target === '404') {
                                    if (is_404()) {
                                        $uniqueSend = 'true';
                                    } else {
                                        $uniqueSend = 'false';
                                    }
                                } else if ($condition->target === 'frontPage') {
                                    if (is_front_page()) {
                                        $uniqueSend = 'true';
                                    } else {
                                        $uniqueSend = 'false';
                                    }
                                } else if (is_singular()) {
                                    if ($condition->target && is_singular($condition->target)) {
                                        if (!isset($condition->data) || ($condition->data && $condition->data === 'all')) {
                                            $uniqueSend = 'true';
                                        } else {
                                            $uniqueSend = 'false';
                                        }
                                        if (isset($condition->data) && $condition->data && $condition->data != 'all') {
                                            if (!isset($condition->data) || ($condition->data && $condition->data === 'directchildof')) {
                                                $parent_id = get_the_ID();
                                                $parent_page = wp_get_post_parent_id($parent_id);
                                                if (isset($condition->extra) && $parent_page == $condition->extra) {
                                                    $uniqueSend = 'true';
                                                } else {
                                                    $uniqueSend = 'false';
                                                }
                                            } else if (!isset($condition->extra) || ($condition->extra && $condition->extra === 'all')) {
                                                if (!is_array($condition->data) && has_term('', $condition->data)) {
                                                    $uniqueSend = 'true';
                                                } else if (is_array($condition->data)) {
                                                    foreach ($condition->data as $data) {
                                                        if ($post->ID === $data) {
                                                            $uniqueSend = 'true';
                                                        }
                                                    }
                                                } else {
                                                    $uniqueSend = 'false';
                                                }
                                            } else if (isset($condition->extra) && $condition->extra && $condition->extra != 'all') {
                                                if (has_term($condition->extra, $condition->data)) {
                                                    $uniqueSend = 'true';
                                                } else {
                                                    $uniqueSend = 'false';
                                                }
                                                if (isset($condition->extraData) && $condition->extraData && $condition->extraData != 'all') {
                                                    if ($condition->extraData === get_the_ID()) {
                                                        $uniqueSend = 'true';
                                                    } else {
                                                        $uniqueSend = 'false';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $exclude[] = $uniqueSend;
                    }
                    $noExclude[] = 'false';
                } else {
                    $noExclude[] = 'true';
                }
                if (sizeof($value->archive) > 0) {
                    foreach ($value->archive as $condition) {
                        $uniqueSend = 'false';

                        if ($condition->target === 'search' && is_search()) {
                            $uniqueSend = 'true';
                        }
                        if (is_archive()) {
                            if (isset($condition->target) && $condition->target) {
                                $postType = get_taxonomy(get_queried_object()->taxonomy)->object_type[0];
                                if ($condition->target === 'all') {
                                    $uniqueSend = 'true';
                                } else if ((!isset($condition->data) || ($condition->data && $condition->data === 'all')) && $postType === $condition->target) {
                                    $uniqueSend = 'true';
                                } else if ($postType === $condition->target && isset($condition->data) && $condition->data === get_queried_object()->taxonomy && (!isset($condition->extra) || ($condition->extra && $condition->extra === 'all'))) {
                                    $uniqueSend = 'true';
                                } else if ($postType === $condition->target && isset($condition->data) && $condition->data === get_queried_object()->taxonomy && isset($condition->extra) && $condition->extra === get_queried_object()->term_id) {
                                    $uniqueSend = 'true';
                                }
                            }
                        }
                        $exclude[] = $uniqueSend;
                    }
                    $noExclude[] = 'false';
                } else {
                    $noExclude[] = 'true';
                }
                if (sizeof($value->author) > 0) {
                    foreach ($value->author as $condition) {
                        $uniqueSend = 'false';
                        if ($condition === true) {
                            $uniqueSend = 'true';
                        } else if (isset($condition->target) && $condition->target && $post->post_author && intval($post->post_author) === $condition->target) {
                            $uniqueSend = 'true';
                        }
                        $exclude[] = $uniqueSend;
                    }
                    $noExclude[] = 'false';
                } else {
                    $noExclude[] = 'true';
                }
                if (sizeof($value->custom) > 0) {
                    $current_user = wp_get_current_user();
                    foreach ($value->custom as $condition) {
                        $uniqueSend = 'false';
                        $conditioner = '';
                        if ($condition->target === 'date') {
                            $conditioner = date("m/d/Y");
                        }
                        if ($condition->target === 'dayweek') {
                            $conditioner = date("l");
                        }
                        if ($condition->target === 'daymonth') {
                            $conditioner = date("d");
                        }
                        if ($condition->target === 'time') {
                            $conditioner = date("H:i:s");
                        }
                        if ($condition->target === 'username') {
                            $conditioner = $current_user->user_login;
                        }
                        if ($condition->target === 'userid') {
                            $conditioner = strval($current_user->ID);
                        }
                        if ($condition->target === 'usercapabilities') {
                            if (current_user_can($condition->extraData)) {
                                $conditioner = 'true';
                            }
                        }
                        if ($condition->target === 'urlparameter') {
                            if (isset($condition->key) && $condition->key) {
                                if (isset($_GET[$condition->key]) && $_GET[$condition->key]) {
                                    $key = htmlspecialchars($_GET[$condition->key], ENT_QUOTES, 'UTF-8');
                                    if ($condition->extra === 'true' || $condition->extra === 'false') {
                                        $conditioner = filter_var($key, FILTER_VALIDATE_BOOLEAN);
                                    } else {
                                        $conditioner = $key;
                                    }
                                }
                            }
                        }
                        switch ($condition->extra) {
                            case "===":
                                if ($condition->target === 'cookie') {
                                    $loop = true;
                                    foreach ($_COOKIE as $key => $val) {
                                        if ($key === $condition->extraData) {
                                            $uniqueSend = 'true';
                                            $loop = false;
                                            break;
                                        }
                                    }
                                    if ($loop) {
                                        $uniqueSend = 'false';
                                    }
                                } else if ($condition->target === 'dayweek') {
                                    $date_now = strtotime('today');
                                    $date_compared = strtotime('' . $condition->extraData . ' this week');
                                    if ($date_now === $date_compared) {
                                        $uniqueSend = 'true';
                                    }
                                } else if ($condition->target === 'userrole') {
                                    if (in_array($condition->extraData, $current_user->roles, true)) {
                                        $uniqueSend = 'true';
                                    }
                                } else if ($condition->target === 'usercapabilities') {
                                    if (current_user_can($condition->extraData)) {
                                        $uniqueSend = 'true';
                                    }
                                } else if ($condition->target === 'acf') {
                                    if (isset($condition->group) && isset($condition->field)) {
                                        $location = false;
                                        if (isset($condition->acfLocation)) {
                                            if ($condition->acfLocation === 'currentpost') {
                                                $location = get_the_ID();
                                            } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            } else if ($condition->acfLocation === 'currentuser') {
                                                $location = 'user_' . get_current_user_id() . '';
                                            } else if ($condition->acfLocation === 'currentauthor') {
                                                $location = 'user_' . get_the_author_meta('ID') . '';
                                            } else if ($condition->acfLocation === 'option') {
                                                $location = 'option';
                                            } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                                $term = get_term($condition->acfLocationID->value);
                                                $location = $term->taxonomy . '_' . $term->term_id;
                                            } else if (isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            }
                                        }

                                        $field = get_field($condition->field, $location);
                                        if (is_array($field)) {
                                            $field = implode(" ", $field);
                                        } else {
                                            $field = strval($field);
                                        }

                                        if ($field === $condition->extraData) {
                                            $uniqueSend = 'true';
                                        }
                                    }
                                } else {
                                    if ($conditioner === $condition->extraData) {
                                        $uniqueSend = 'true';
                                    }
                                }
                                break;
                            case "!=":
                                if ($condition->target === 'cookie') {
                                    $loop = true;
                                    foreach ($_COOKIE as $key => $val) {
                                        if ($key === $condition->extraData) {
                                            $uniqueSend = 'false';
                                            $loop = false;
                                            break;
                                        }
                                    }
                                    if ($loop) {
                                        $uniqueSend = 'true';
                                    }
                                } else if ($condition->target === 'dayweek') {
                                    $date_now = strtotime('today');
                                    $date_compared = strtotime('' . $condition->extraData . ' this week');
                                    if ($date_now != $date_compared) {
                                        $uniqueSend = 'true';
                                    }
                                } else if ($condition->target === 'userrole') {
                                    if (!in_array($condition->extraData, $current_user->roles, true)) {
                                        $uniqueSend = 'true';
                                    }
                                } else if ($condition->target === 'usercapabilities') {
                                    if (!current_user_can($condition->extraData)) {
                                        $uniqueSend = 'true';
                                    }
                                } else if ($condition->target === 'acf') {
                                    if (isset($condition->group) && isset($condition->field)) {
                                        $location = false;
                                        if (isset($condition->acfLocation)) {
                                            if ($condition->acfLocation === 'currentpost') {
                                                $location = get_the_ID();
                                            } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            } else if ($condition->acfLocation === 'currentuser') {
                                                $location = 'user_' . get_current_user_id() . '';
                                            } else if ($condition->acfLocation === 'currentauthor') {
                                                $location = 'user_' . get_the_author_meta('ID') . '';
                                            } else if ($condition->acfLocation === 'option') {
                                                $location = 'option';
                                            } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                                $term = get_term($condition->acfLocationID->value);
                                                $location = $term->taxonomy . '_' . $term->term_id;
                                            } else if (isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            }
                                        }

                                        $field = get_field($condition->field, $location);
                                        if (is_array($field)) {
                                            $field = implode(" ", $field);
                                        } else {
                                            $field = strval($field);
                                        }

                                        if ($field != $condition->extraData) {
                                            $uniqueSend = 'true';
                                        }
                                    }
                                } else {
                                    if ($conditioner != $condition->extraData) {
                                        $uniqueSend = 'true';
                                    }
                                }
                                break;
                            case "contains":
                                if ($condition->target === 'cookie') {
                                    $loop = true;
                                    foreach ($_COOKIE as $key => $val) {
                                        if (strpos($key, $condition->extraData) !== false) {
                                            $uniqueSend = 'true';
                                            $loop = false;
                                            break;
                                        }
                                    }
                                    if ($loop) {
                                        $uniqueSend = 'false';
                                    }
                                } else {
                                    if (strpos($conditioner, $condition->extraData) !== false) {
                                        $uniqueSend = 'true';
                                    }
                                }
                                break;
                            case "notcontain":
                                if ($condition->target === 'cookie') {
                                    $loop = true;
                                    foreach ($_COOKIE as $key => $val) {
                                        if (strpos($key, $condition->extraData) === false) {
                                            $uniqueSend = 'true';
                                            $loop = false;
                                            break;
                                        }
                                    }
                                    if ($loop) {
                                        $uniqueSend = 'false';
                                    }
                                } else {
                                    if (strpos($conditioner, $condition->extraData) === false) {
                                        $uniqueSend = 'true';
                                    }
                                }
                                break;
                            case "before":
                                if ($condition->target === 'dayweek') {
                                    $date_now = strtotime('today');
                                    $date_compared = strtotime('' . $condition->extraData . ' this week');
                                    if ($date_now < $date_compared) {
                                        $uniqueSend = 'true';
                                    }
                                } else {
                                    if ($conditioner < $condition->extraData) {
                                        $uniqueSend = 'true';
                                    }
                                }
                                break;
                            case "after":
                                if ($condition->target === 'dayweek') {
                                    $date_now = strtotime('today');
                                    $date_compared = strtotime('' . $condition->extraData . ' this week');
                                    if ($date_now > $date_compared) {
                                        $uniqueSend = 'true';
                                    }
                                } else {
                                    if ($conditioner > $condition->extraData) {
                                        $uniqueSend = 'true';
                                    }
                                }
                                break;
                            case "<":
                                if ($conditioner < $condition->extraData) {
                                    $uniqueSend = 'true';
                                }
                                break;
                            case ">":
                                if ($conditioner > $condition->extraData) {
                                    $uniqueSend = 'true';
                                }
                                break;
                            case ">=":
                                if ($conditioner >= $condition->extraData) {
                                    $uniqueSend = 'true';
                                }
                                break;
                            case "<=":
                                if ($conditioner <= $condition->extraData) {
                                    $uniqueSend = 'true';
                                }
                                break;
                            case "empty":
                                if ($condition->target === 'acf') {
                                    if (isset($condition->group) && isset($condition->field)) {
                                        if (isset($condition->group) && isset($condition->field)) {
                                            $location = false;
                                            if (isset($condition->acfLocation)) {
                                                if ($condition->acfLocation === 'currentpost') {
                                                    $location = get_the_ID();
                                                } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                                    $location = $condition->acfLocationID;
                                                } else if ($condition->acfLocation === 'currentuser') {
                                                    $location = 'user_' . get_current_user_id() . '';
                                                } else if ($condition->acfLocation === 'currentauthor') {
                                                    $location = 'user_' . get_the_author_meta('ID') . '';
                                                } else if ($condition->acfLocation === 'option') {
                                                    $location = 'option';
                                                } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                                    $term = get_term($condition->acfLocationID->value);
                                                    $location = $term->taxonomy . '_' . $term->term_id;
                                                } else if (isset($condition->acfLocationID)) {
                                                    $location = $condition->acfLocationID;
                                                }
                                            }

                                            $field = get_field($condition->field, $location);
                                            if (is_array($field)) {
                                                $field = implode(" ", $field);
                                            } else {
                                                $field = strval($field);
                                            }

                                            if ($field != $condition->extraData) {
                                                $uniqueSend = 'true';
                                            }
                                        }
                                        $field = get_field($condition->field);
                                        if (empty($field)) {
                                            $uniqueSend = 'true';
                                        }
                                    }
                                }
                                break;
                            case "notempty":
                                if ($condition->target === 'acf') {
                                    if (isset($condition->group) && isset($condition->field)) {
                                        $location = false;
                                        if (isset($condition->acfLocation)) {
                                            if ($condition->acfLocation === 'currentpost') {
                                                $location = get_the_ID();
                                            } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            } else if ($condition->acfLocation === 'currentuser') {
                                                $location = 'user_' . get_current_user_id() . '';
                                            } else if ($condition->acfLocation === 'currentauthor') {
                                                $location = 'user_' . get_the_author_meta('ID') . '';
                                            } else if ($condition->acfLocation === 'option') {
                                                $location = 'option';
                                            } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                                $term = get_term($condition->acfLocationID->value);
                                                $location = $term->taxonomy . '_' . $term->term_id;
                                            } else if (isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            }
                                        }

                                        $field = get_field($condition->field, $location);
                                        if (is_array($field)) {
                                            $field = implode(" ", $field);
                                        } else {
                                            $field = strval($field);
                                        }

                                        if (!empty($field)) {
                                            $uniqueSend = 'true';
                                        }
                                    }
                                }
                                break;
                            case "true":
                                if ($condition->target === 'shortcode') {
                                    $shortcode = do_shortcode('[' . $condition->extraData . ']');
                                    if ($shortcode) {
                                        $uniqueSend = 'true';
                                    }
                                } else if ($condition->target === 'acf') {
                                    if (isset($condition->group) && isset($condition->field)) {
                                        $location = false;
                                        if (isset($condition->acfLocation)) {
                                            if ($condition->acfLocation === 'currentpost') {
                                                $location = get_the_ID();
                                            } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            } else if ($condition->acfLocation === 'currentuser') {
                                                $location = 'user_' . get_current_user_id() . '';
                                            } else if ($condition->acfLocation === 'currentauthor') {
                                                $location = 'user_' . get_the_author_meta('ID') . '';
                                            } else if ($condition->acfLocation === 'option') {
                                                $location = 'option';
                                            } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                                $term = get_term($condition->acfLocationID->value);
                                                $location = $term->taxonomy . '_' . $term->term_id;
                                            } else if (isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            }
                                        }

                                        $field = get_field($condition->field, $location);
                                        if (is_array($field)) {
                                            $field = $field[0];
                                        } else {
                                            $field = strval($field);
                                        }
                                        if (boolval($field) === true) {
                                            $uniqueSend = 'true';
                                        } else {
                                            $uniqueSend = 'false';
                                        }
                                    }
                                }
                                break;
                            case "false":
                                if ($condition->target === 'shortcode') {
                                    $shortcode = do_shortcode('[' . $condition->extraData . ']');
                                    if (!$shortcode) {
                                        $uniqueSend = 'true';
                                    }
                                } else if ($condition->target === 'acf') {
                                    if (isset($condition->group) && isset($condition->field)) {
                                        $location = false;
                                        if (isset($condition->acfLocation)) {
                                            if ($condition->acfLocation === 'currentpost') {
                                                $location = get_the_ID();
                                            } else if ($condition->acfLocation === 'postid' && isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            } else if ($condition->acfLocation === 'currentuser') {
                                                $location = 'user_' . get_current_user_id() . '';
                                            } else if ($condition->acfLocation === 'currentauthor') {
                                                $location = 'user_' . get_the_author_meta('ID') . '';
                                            } else if ($condition->acfLocation === 'option') {
                                                $location = 'option';
                                            } else if ($condition->acfLocation === 'taxonomyterm' && isset($condition->acfLocationID) && isset($condition->acfLocationID->value)) {
                                                $term = get_term($condition->acfLocationID->value);
                                                $location = $term->taxonomy . '_' . $term->term_id;
                                            } else if (isset($condition->acfLocationID)) {
                                                $location = $condition->acfLocationID;
                                            }
                                        }

                                        $field = get_field($condition->field, $location);
                                        if (is_array($field)) {
                                            $field = $field[0];
                                        } else {
                                            $field = strval($field);
                                        }
                                        if (boolval($field) === false) {
                                            $uniqueSend = 'true';
                                        } else {
                                            $uniqueSend = 'false';
                                        }
                                    }
                                }
                                break;
                        }
                        $exclude[] = $uniqueSend;
                    }
                    $noExclude[] = 'false';
                } else {
                    $noExclude[] = 'true';
                }
            }
            if ($templater) {
                if (array_unique($noExclude) == array('true')) {
                    $final[] = $customTemplate;
                } else if ($templater && $conditions->exclude->$templater->excludeCondition && $conditions->exclude->$templater->excludeCondition === 'and' && array_unique($exclude) != array('true')) {
                    $final[] = $customTemplate;
                } else if ($templater && $conditions->exclude->$templater->excludeCondition && $conditions->exclude->$templater->excludeCondition === 'or' && !in_array("true", $exclude)) {
                    $final[] = $customTemplate;
                }
            }
        }
    }
    return $final;
}

function cc_tag_maker($attributes, $block, $open = false)
{
    $custom_tag = '';
    if (isset($attributes['linkWrapperActive']) && $attributes['linkWrapperActive']) {
        if (isset($attributes['containerLayoutTag']) && $attributes['containerLayoutTag'] && ($attributes['containerLayoutTag'] === 'a' || $attributes['containerLayoutTag'] === 'button')) {
            if ($open) {
                $custom_tag = $attributes['containerLayoutTag'];
            } else {
                $custom_tag = '</' . $attributes['containerLayoutTag'] . '>';
            }
        } else {
            if ($open) {
                $custom_tag = 'a';
            } else {
                $custom_tag = '</a>';
            }
        }
    } else {
        if (isset($attributes['headingTag']) && $attributes['headingTag']) {
            if ($open) {
                $custom_tag = $attributes['headingTag'];
            } else {
                $custom_tag = '</' . $attributes['headingTag'] . '>';
            }
        } else if (isset($attributes['containerLayoutTag']) && $attributes['containerLayoutTag']) {
            if ($open) {
                $custom_tag = $attributes['containerLayoutTag'];
            } else {
                $custom_tag = '</' . $attributes['containerLayoutTag'] . '>';
            }
        } else if (isset($block->name) && $block->name && $block->name === 'cwicly/section') {
            if ($open) {
                $custom_tag = 'section';
            } else {
                $custom_tag = '</section>';
            }
        } else {
            if ($open) {
                $custom_tag = 'div';
            } else {
                $custom_tag = '</div>';
            }
        }
    }
    return $custom_tag;
}

function cc_attribute_checker($attributes, $property, $type)
{
    if ($type === 'true') {
        if (isset($attributes[$property]) && $attributes[$property]) {
            return true;
        } else {
            return false;
        }
    } else if ($type === 'false') {
        if (!isset($attributes[$property]) || (isset($attributes[$property]) && !$attributes[$property])) {
            return true;
        } else {
            return false;
        }
    }
}

function cc_arrays_are_equal($array1, $array2)
{
    array_multisort($array1);
    array_multisort($array2);
    return (serialize($array1) === serialize($array2));
}
