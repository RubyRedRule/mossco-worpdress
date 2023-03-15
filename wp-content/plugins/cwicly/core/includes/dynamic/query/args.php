<?php

/**
 * Cwicly Queries
 *
 * Functions for creating and managing queries
 *
 * @package Cwicly\Functions
 * @version 1.1
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class CC_Query_Args
{
    protected $final;
    protected $urlparams;
    protected $blockContext = array();

    public function __construct($blockContext)
    {
        $this->blockContext = $blockContext;
    }

    private function dynamicURLChecker($attributes, $property)
    {
        if (isset($attributes['group']) && $attributes['group'] === 'urlparameter' && isset($attributes['field']) && Cwicly\Helpers::check_if_exists($attributes['field'])) {
            $this->urlparams[$property] = $attributes['field'];
        }
    }

    private function typeMaker($type, $value)
    {
        $final = $value;
        if ($type == 'string') {
            $final = $value;
        } else if ($type == 'boolean') {
            $bool = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            $final = $bool ? 1 : 0;
        } else if ($type == 'integer') {
            $final = intval($value);
        }
        return $final;
    }

    /**
     * Cwicly Dynamic Query Args Maker
     *
     * Returns the specific dynamic query element
     *
     * @package Cwicly\Functions
     * @version 1.1
     */
    private function dynamicMaker($attributes, $postId, $array = false, $type = '')
    {
        $return = '';
        if (isset($attributes['type']) && $attributes['type'] === 'wordpress') {
            if ($attributes['group'] === 'postid') {
                if (isset($type) && $type === 'integer') {
                    $return = intval($postId);
                } else if (isset($type) && $type === 'string') {
                    $return = '"' . $postId . '"';
                } else {
                    $return = $postId;
                }
            } else if ($attributes['group'] === 'posttype') {
                $return = get_post_type($postId);
            } else if (isset($attributes['group']) && $attributes['group'] === 'posstatus') {
                $return = get_post_status($postId);
            } else if (isset($attributes['group']) && $attributes['group'] === 'customfield' && isset($attributes['field']) && $attributes['field']) {
                $return = get_post_field($attributes['field'], $postId);
            } else if (isset($attributes['group']) && $attributes['group'] === 'featuredimagetitle') {
                $return = get_the_title($postId);
            } else if (isset($attributes['group']) && $attributes['group'] === 'featuredimagealt') {
                $return = get_post_meta(get_post_thumbnail_id($postId), '_wp_attachment_image_alt', true);
            } else if (isset($attributes['group']) && $attributes['group'] === 'featuredimagecaption') {
                $return = wp_get_attachment_caption($postId);
            } else if (isset($attributes['group']) && $attributes['group'] === 'authorname') {
                $return = get_the_author_meta('user_login');
            } else if (isset($attributes['group']) && $attributes['group'] === 'authorcustomfield' && isset($attributes['field']) && $attributes['field']) {
                $return = get_user_meta(get_the_author_meta('ID'), $attributes['field']);
            } else if (isset($attributes['group']) && $attributes['group'] === 'authorid') {
                $return = get_the_author_meta('ID');
            } else if (isset($attributes['group']) && $attributes['group'] === 'userid') {
                $return = get_current_user_id();
            } else if (isset($attributes['group']) && $attributes['group'] === 'username') {
                $return = wp_get_current_user()->user_login;
            } else if (isset($attributes['group']) && $attributes['group'] === 'usercustomfield' && isset($attributes['field']) && $attributes['field']) {
                $return = get_user_meta(get_current_user_id(), $attributes['field']);
            } else if (isset($attributes['group']) && $attributes['group'] === 'shortcode' && isset($attributes['field']) && $attributes['field']) {
                $return = do_shortcode('[' . $attributes['field'] . ']');
            } else if (isset($attributes['group']) && $attributes['group'] === 'siteoption' && isset($attributes['field']) && $attributes['field']) {
                $return = get_option($attributes['field']);
            } else if (isset($attributes['group']) && $attributes['group'] === 'archiveauthorid') {
                if (is_author()) {
                    $return = get_queried_object_id();
                } else {
                    $author = get_queried_object();
                    $return = $author->post_author;
                }
            } else if (isset($attributes['group']) && $attributes['group'] === 'postterms') {
                $terms = cc_custom_taxonomies_terms($postId);
                $return = $terms;
            } else if (isset($attributes['group']) && $attributes['group'] === 'urlparameter' && isset($attributes['field']) && $attributes['field']) {
                if (isset($_GET[$attributes['field']])) {
                    $field = $_GET[$attributes['field']];
                    // if (!empty($field)) {
                    if (Cwicly\Helpers::check_if_exists($field)) {
                        if (!is_array($field) && $array) {
                            $return = explode(',', $field);
                        } else if ($type) {
                            $return = $this->typeMaker($type, $field);
                        } else {
                            $return = $field;
                        }
                    }
                }
            }
        } else if ($attributes['type'] === 'acf' && isset($attributes['group']) && $attributes['group'] && isset($attributes['field']) && $attributes['field']) {
            $field = get_field($attributes['field'], $postId, false);
            if (!is_array($field) && $array) {
                $field = [$field];
            }
            if (isset($type) && $type === 'integer') {
                $return = intval($field);
            } else if (isset($type) && $type === 'string') {
                $return = implode(',', $field);
            } else {
                $return = $field;
            }
        } else if (isset($attributes['type']) && $attributes['type'] === 'taxterms') {
            if ($this->blockContext && isset($this->blockContext['taxterms']) && $this->blockContext['taxterms']) {
                if (isset($attributes['group']) && $attributes['group']) {
                    switch ($attributes['group']) {
                        // case 'taxtermsTaxId':
                        //     if (is_object($this->blockContext['taxterms'])) {
                        //         $return = $this->blockContext['taxterms']->term_taxonomy_id;
                        //     } else if (is_array($this->blockContext['taxterms'])) {
                        //         $return = $this->blockContext['taxterms']['term_taxonomy_id'];
                        //     }
                        //     break;
                        case 'taxtermsTaxSlug':
                            if (is_object($this->blockContext['taxterms'])) {
                                $return = $this->blockContext['taxterms']->taxonomy;
                            } else if (is_array($this->blockContext['taxterms'])) {
                                $return = $this->blockContext['taxterms']['taxonomy'];
                            }
                            break;
                        case 'taxtermsTermId':
                            if (is_object($this->blockContext['taxterms'])) {
                                $return = $this->blockContext['taxterms']->term_id;
                            } else if (is_array($this->blockContext['taxterms'])) {
                                $return = $this->blockContext['taxterms']['term_id'];
                            }
                            break;
                        case 'taxtermsTermSlug':
                            if (is_object($this->blockContext['taxterms'])) {
                                $return = $this->blockContext['taxterms']->slug;
                            } else if (is_array($this->blockContext['taxterms'])) {
                                $return = $this->blockContext['taxterms']['slug'];
                            }
                            break;
                            // case 'taxtermsParent':
                            //     $return = $this->blockContext['taxterms']->parent;
                            //     break;
                    }
                }
            }
        }
        if (!$return && isset($attributes['fallback']) && Cwicly\Helpers::check_if_exists($attributes['fallback'])) {
            if (!is_array($attributes['fallback']) && $array) {
                $return = explode(',', $attributes['fallback']);
            } else if ($type) {
                $return = $this->typeMaker($type, $attributes['fallback']);
            } else {
                $return = $attributes['fallback'];
            }
        }
        return $return;
    }

    private function booleanMaker($attribute, $postId, $type, &$final, $true = true, $false = false)
    {
        if ($attribute && is_array($attribute)) {
            if ($attribute['source'] === 'static' && $attribute['field']) {
                if (isset($attribute['field']) && is_bool($attribute['field'])) {
                    $final[$type] = $attribute['field'] ? $true : $false;
                }
            } else if ($attribute && $attribute['source'] === 'dynamic') {
                $dynamic = $this->dynamicMaker($attribute, $postId, $false);
                $this->dynamicURLChecker($attribute, $type);
                if ($dynamic) {
                    $final[$type] = $dynamic;
                }
            }
        } else if (isset($attribute) && is_bool($attribute)) {
            $final[$type] = $attribute ? $true : $false;
        }
    }

    private function selectorMaker($attribute, $postId, $type, &$final, $array = false)
    {
        if (is_array($attribute)) {
            if ($attribute && $attribute['source'] === 'static' && isset($attribute['field']) && $attribute['field']) {
                if (is_array($attribute['field'])) {
                    $finalPost = [];
                    foreach ($attribute['field'] as $index => $element) {
                        $finalPost[] = $element['value'];
                    }
                    $final[$type] = $finalPost;
                } else {
                    $final[$type] = $attribute['field'];
                }
            } else if ($attribute && $attribute['source'] === 'dynamic') {
                $dynamic = $this->dynamicMaker($attribute, $postId, $array);
                $this->dynamicURLChecker($attribute, $type);
                if ($dynamic) {
                    $final[$type] = $dynamic;
                }
            }
        }
    }

    private function singleValueMaker($attribute, $postId, $type, &$final, $isNumeric = false, $group = false)
    {
        if ($attribute && $attribute['source'] === 'static' && isset($attribute[$group ? 'group' : 'field']) && \Cwicly\Helpers::check_if_exists($attribute[$group ? 'group' : 'field'])) {
            $value = $attribute[$group ? 'group' : 'field'];
            if (is_array($value) || is_object($value)) {
                if (isset($value['value'])) {
                    if ($value['value'] === 'current') {
                        $final[$type] = $postId;
                    } else {
                        $final[$type] = $value['value'];
                    }
                }
            } else if ($isNumeric) {
                if (
                    isset($value) &&
                    is_numeric($value)
                ) {
                    $final[$type] = absint($value);
                }
            } else {
                $final[$type] = $attribute[$group ? 'group' : 'field'];
            }
        } else if ($attribute && $attribute['source'] === 'dynamic') {
            $value = $this->dynamicMaker($attribute, $postId);
            $this->dynamicURLChecker($attribute, $type);
            if ($isNumeric) {
                if (
                    isset($value) &&
                    is_numeric($value)
                ) {
                    $final[$type] = absint($value);
                } else if (isset($value)) {
                    $value = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
                    $final[$type] = intval($value);
                }
            } else {
                $final[$type] = $value;
            }
        }
    }

    public function cc_query_preparation(
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
    ) {

        $this->selectorMaker($queryMaxItems, $postId, 'maxitems', $this->final);

        if ($queryType === 'posts') {
            $this->selectorMaker($queryPostType, $postId, 'post_type', $this->final, true);
            $this->selectorMaker($queryPostStatus, $postId, 'post_status', $this->final);
            $this->selectorMaker($queryAuthorIn, $postId, 'author__in', $this->final);
            $this->selectorMaker($queryAuthorNotIn, $postId, 'author__not_in', $this->final);
            $this->singleValueMaker($queryPostParent, $postId, 'post_parent', $this->final, true);
            $this->selectorMaker($queryInParent, $postId, 'post_parent__in', $this->final, true);
            $this->selectorMaker($queryNotInParent, $postId, 'post_parent__not_in', $this->final, true);
            $this->selectorMaker($queryInclude, $postId, 'post__in', $this->final, true);
            $this->selectorMaker($queryExclude, $postId, 'post__not_in', $this->final, true);
            $this->singleValueMaker($queryMimeType, $postId, 'post_mime_type', $this->final);
            $this->singleValueMaker($queryPerm, $postId, 'perm', $this->final);
            $this->singleValueMaker($queryAuthorName, $postId, 'author_name', $this->final);
            $this->singleValueMaker($queryAuthor, $postId, 'author', $this->final);
            $this->singleValueMaker($querySearch, $postId, 's', $this->final);
            $this->singleValueMaker($queryPassword, $postId, 'has_password', $this->final);
            $this->singleValueMaker($queryPostPassword, $postId, 'post_password', $this->final);
            $this->singleValueMaker($queryPerPage, $postId, 'posts_per_page', $this->final, true);
            $this->final['ignore_sticky_posts'] = $querySticky ? false : true;
            if ($queryExcludeCurrent && $postId) {
                $this->final['post__not_in'][] = $postId;
            }
            if ($queryCommentCompare && $queryCommentCompare['source'] === 'static' && isset($queryCommentCompare['field']) && Cwicly\Helpers::check_if_exists($queryCommentCompare['field'])) {
                $this->final['comment_count']['compare'] = $queryCommentCompare['field'];
            } else if ($queryCommentCompare && $queryCommentCompare['source'] === 'dynamic') {
                $this->final['comment_count']['compare'] = $this->dynamicMaker($queryCommentCompare, $postId);
                $this->dynamicURLChecker($attribute, $type);
            }
            if ($queryCommentCount && $queryCommentCount['source'] === 'static' && isset($queryCommentCount['field']) && Cwicly\Helpers::check_if_exists($queryCommentCount['field'])) {
                $this->final['comment_count']['value'] = $queryCommentCount['field'];
            } else if ($queryCommentCount && $queryCommentCount['source'] === 'dynamic') {
                $this->final['comment_count']['value'] = $this->dynamicMaker($queryCommentCount, $postId);
                $this->dynamicURLChecker($attribute, $type);
            }
        }

        if ($queryType === 'terms') {
            $this->selectorMaker($queryTaxonomies, $postId, 'taxonomy', $this->final, true);
            $this->selectorMaker($queryExcludeTree, $postId, 'exclude_tree', $this->final);
            $this->selectorMaker($queryName, $postId, 'name', $this->final);
            $this->selectorMaker($querySlug, $postId, 'slug', $this->final);
            $this->selectorMaker($queryInclude, $postId, 'include', $this->final);
            $this->selectorMaker($queryExclude, $postId, 'exclude', $this->final);
            $this->singleValueMaker($queryPerPage, $postId, 'number', $this->final);
            $this->singleValueMaker($queryNameLike, $postId, 'name__like', $this->final);
            $this->singleValueMaker($queryDescriptionLike, $postId, 'description__like', $this->final);
            $this->singleValueMaker($querySearch, $postId, 'search', $this->final);
            $this->singleValueMaker($queryGet, $postId, 'get', $this->final);
            $this->singleValueMaker($queryChildOf, $postId, 'child_of', $this->final);
            $this->singleValueMaker($queryParent, $postId, 'parent', $this->final, true);
            $this->final['childless'] = $queryChildless ? true : false;
            $this->final['hide_empty'] = $queryHideEmpty ? true : false;
            $this->final['count'] = $queryCount ? true : false;
            $this->final['pad_counts'] = $queryPadCount ? true : false;
            $this->final['hierarchical'] = $queryHierarchical ? true : false;
        }

        if ($queryType === 'users') {
            $this->singleValueMaker($querySearch, $postId, 'search', $this->final);
            $this->selectorMaker($queryRole, $postId, 'role', $this->final);
            $this->selectorMaker($queryRoleIn, $postId, 'role__in', $this->final);
            $this->selectorMaker($queryRoleNotIn, $postId, 'role__not_in', $this->final);
            $this->selectorMaker($queryInclude, $postId, 'include', $this->final);
            $this->selectorMaker($queryExclude, $postId, 'exclude', $this->final);
            $this->selectorMaker($querySearchColumn, $postId, 'search_columns', $this->final);
            $this->singleValueMaker($queryPerPage, $postId, 'number', $this->final);
            $this->singleValueMaker($queryBlogID, $postId, 'blog_id', $this->final);
            $this->singleValueMaker($queryWho, $postId, 'who', $this->final);
            $this->final['count_total'] = $queryTotalCount ? true : false;
            // $this->final['has_published_posts'] = $queryHasPublished ? true : false;
        }

        if ($queryType === 'comments') {
            $this->singleValueMaker($queryPerPage, $postId, 'number', $this->final);
            $this->singleValueMaker($queryCommentKarma, $postId, 'karma', $this->final);
            $this->selectorMaker($queryCommentID, $postId, 'comment__in', $this->final);
            $this->selectorMaker($queryCommentNotID, $postId, 'comment__not_in', $this->final);
            $this->singleValueMaker($queryAuthorEmail, $postId, 'author_email', $this->final);
            $this->singleValueMaker($queryAuthorURL, $postId, 'author_url', $this->final);
            $this->selectorMaker($queryPostStatus, $postId, 'status', $this->final, true);
            $this->singleValueMaker($querySearch, $postId, 'search', $this->final);
            $this->singleValueMaker($queryCommentPostID, $postId, 'post_id', $this->final);
            $this->booleanMaker($queryCommentIncludeUnapproved, $postId, 'include_unapproved', $this->final);
            $this->selectorMaker($queryPostStatus, $postId, 'status', $this->final, true);
            $this->singleValueMaker($queryCommentKarma, $postId, 'karma', $this->final);
            $this->selectorMaker($queryCommentParent, $postId, 'parent', $this->final);
            $this->selectorMaker($queryCommentNotParent, $postId, 'parent__in', $this->final);
            $this->selectorMaker($queryCommentInParent, $postId, 'parent__not_in', $this->final);
            $this->selectorMaker($queryCommentAuthorIn, $postId, 'author__in', $this->final);
            $this->selectorMaker($queryAuthorIn, $postId, 'post_author__in', $this->final);
            $this->selectorMaker($queryCommentAuthorNotIn, $postId, 'author__not_in', $this->final);
            $this->selectorMaker($queryAuthorNotIn, $postId, 'post_author__not_in', $this->final);
            $this->selectorMaker($queryInclude, $postId, 'post__in', $this->final);
            $this->selectorMaker($queryExclude, $postId, 'post__not_in', $this->final);
            $this->booleanMaker($queryHierarchical, $postId, 'hierarchical', $this->final, 'flat', 'threaded');
            // $this->final['hierarchical'] = 'threaded';
        }

        if ($queryType === 'products') {
            $this->selectorMaker($queryPostStatus, $postId, 'status', $this->final, true);
            $this->selectorMaker($queryWooType, $postId, 'type', $this->final, true);
            $this->selectorMaker($queryInclude, $postId, 'include', $this->final, true);
            $this->selectorMaker($queryExclude, $postId, 'exclude', $this->final, true);
            $this->singleValueMaker($queryParent, $postId, 'parent', $this->final, true);
            $this->singleValueMaker($queryWooParentExclude, $postId, 'parent_exclude', $this->final, true);
            $this->singleValueMaker($queryPerPage, $postId, 'limit', $this->final, true);
            $this->singleValueMaker($queryWooSKU, $postId, 'sku', $this->final);
            $this->selectorMaker($queryWooTag, $postId, 'tag', $this->final);
            $this->singleValueMaker($querySearch, $postId, 's', $this->final);
            $this->selectorMaker($queryWooCategory, $postId, 'category', $this->final, true);
            $this->singleValueMaker($queryWooWidth, $postId, 'width', $this->final, true);
            $this->singleValueMaker($queryWooHeight, $postId, 'height', $this->final, true);
            $this->singleValueMaker($queryWooLength, $postId, 'length', $this->final, true);
            $this->singleValueMaker($queryWooWeight, $postId, 'weight', $this->final, true);
            $this->singleValueMaker($queryWooPrice, $postId, 'price', $this->final, true);
            $this->singleValueMaker($queryWooRegularPrice, $postId, 'regular_price', $this->final, true);
            $this->singleValueMaker($queryWooSalePrice, $postId, 'sale_price', $this->final, true);
            $this->singleValueMaker($queryWooTotalSales, $postId, 'total_sales', $this->final, true);
            $this->booleanMaker($queryWooVirtual, $postId, 'virtual', $this->final);
            $this->booleanMaker($queryWooDownloadable, $postId, 'downloadable', $this->final);
            $this->booleanMaker($queryWooFeatured, $postId, 'featured', $this->final);
            $this->booleanMaker($queryWooSoldIndividually, $postId, 'sold_individually', $this->final);
            $this->booleanMaker($queryWooManageStock, $postId, 'manage_stock', $this->final);
            $this->booleanMaker($queryWooReviewsAllowed, $postId, 'reviews_allowed', $this->final);
            $this->singleValueMaker($queryWooBackorders, $postId, 'backorders', $this->final);
            $this->singleValueMaker($queryWooVisibility, $postId, 'visibility', $this->final);
            $this->singleValueMaker($queryWooStockQuantity, $postId, 'stock_quantity', $this->final, true);
            $this->singleValueMaker($queryWooStockStatus, $postId, 'stock_status', $this->final);
            $this->singleValueMaker($queryWooTaxStatus, $postId, 'tax_status', $this->final);
            $this->singleValueMaker($queryWooTaxClass, $postId, 'tax_class', $this->final);
            $this->singleValueMaker($queryWooShippingClass, $postId, 'shipping_class', $this->final);
            $this->singleValueMaker($queryWooDownloadLimit, $postId, 'download_limit', $this->final, true);
            $this->singleValueMaker($queryWooDownloadExpiry, $postId, 'download_expiry', $this->final, true);
            $this->singleValueMaker($queryWooAverageRating, $postId, 'average_rating', $this->final, true);
            $this->singleValueMaker($queryWooReviewCount, $postId, 'review_count', $this->final, true);
            $this->singleValueMaker($queryWooDateCreated, $postId, 'date_created', $this->final);
            $this->singleValueMaker($queryWooDateModified, $postId, 'date_modified', $this->final);
            $this->singleValueMaker($queryWooDateOnSaleFrom, $postId, 'date_on_sale_from', $this->final);
            $this->singleValueMaker($queryWooDateOnSaleTo, $postId, 'date_on_sale_to', $this->final);
        }

        if ($queryTaxonomy) {
            foreach ($queryTaxonomy as $index => $tax) {
                if ($tax['multiple']) {
                    if ($tax['relation']) {
                        $query_tax_count = count($tax['tax_query']);
                        if ($query_tax_count >= 2) {
                            $this->final['tax_query'][$index]['relation'] = $tax['relation'];
                        }
                    }
                    if ($tax['tax_query']) {
                        foreach ($tax['tax_query'] as $indexer => $taxer) {
                            foreach ($taxer as $key => $taxValuer) {
                                if ($key != 'title') {
                                    if ($taxValuer && $taxValuer['source'] === 'static' && isset($taxValuer['field']) && Cwicly\Helpers::check_if_exists($taxValuer['field'])) {
                                        if (is_array($taxValuer['field'])) {
                                            $finalPost = [];
                                            foreach ($taxValuer['field'] as $indexerer => $post) {
                                                $finalPost[] = $post['value'];
                                            }
                                            $this->final['tax_query'][$index][$indexer][$key] = $finalPost;
                                        } else if (is_string($taxValuer['field'])) {
                                            $this->final['tax_query'][$index][$indexer][$key] = $taxValuer['field'];
                                        } else if (is_bool($taxValuer['field'])) {
                                            $this->final['tax_query'][$index][$indexer][$key] = $taxValuer['field'] ? true : false;
                                        }
                                    } else if (is_array($taxValuer) && $taxValuer && $taxValuer['source'] === 'dynamic') {
                                        $this->final['tax_query'][$index][0][$indexer][$key] = $this->dynamicMaker($taxValuer, $postId);
                                        $this->dynamicURLChecker($taxValuer, $key);
                                    } else if (is_string($taxValuer) && $key != 'multiple') {
                                        $this->final['tax_query'][$index][$indexer][$key] = $taxValuer;
                                    } else if (is_bool($taxValuer)) {
                                        $this->final['tax_query'][$index][$indexer][$key] = $taxValuer ? 'true' : 'false';
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if ($queryTaxonomyRelation) {
                        $query_tax_count = count($queryTaxonomy);
                        if ($query_tax_count >= 2) {
                            $this->final['tax_query']['relation'] = $queryTaxonomyRelation;
                        }
                    }
                    foreach ($tax as $key => $taxValue) {
                        if (is_array($taxValue)) {
                            if ($taxValue && $taxValue['source'] === 'static' && isset($taxValue['field']) && Cwicly\Helpers::check_if_exists($taxValue['field'])) {
                                if (is_array($taxValue['field'])) {
                                    $finalPost = [];
                                    foreach ($taxValue['field'] as $indexer => $post) {
                                        $finalPost[] = $post['value'];
                                    }
                                    $this->final['tax_query'][$index][$key] = $finalPost;
                                    // foreach ($taxValue['field'] as $indexer => $post) {
                                    //     $this->final['tax_query'][$index][$key] = $post['value'];
                                    // }
                                } else if (is_string($taxValue['field'])) {
                                    $this->final['tax_query'][$index][$key] = $taxValue['field'];
                                } else if (is_bool($taxValue['field'])) {
                                    $this->final['tax_query'][$index][$key] = $taxValue['field'] ? true : false;
                                }
                            } else if ($taxValue && $taxValue['source'] === 'dynamic') {
                                $dynamic = $this->dynamicMaker($taxValue, $postId, true);
                                $this->dynamicURLChecker($taxValue, 'tax_query|' . $index . '|' . $key . '');
                                if ($dynamic) {
                                    $this->final['tax_query'][$index][$key] = $dynamic;
                                }
                            }
                        } else if (is_string($taxValue) && $key != 'multiple' && $key != 'relation') {
                            $this->final['tax_query'][$index][$key] = $taxValue;
                        } else if (is_bool($taxValue) && $key != 'multiple') {
                            $this->final['tax_query'][$index][$key] = $taxValue ? true : false;
                        }
                    }
                }
            }
        }
        if (isset($this->final['tax_query']) && $this->final['tax_query']) {
            foreach ($this->final['tax_query'] as $taxIndex => $element) {
                if (isset($element['terms']) && $element['terms']) {
                } else if (isset($element['removeNoTerms']) && $element['removeNoTerms']) {
                    array_splice($this->final['tax_query'], $taxIndex, 1);
                }
            }
        }
        if ($queryMeta) {
            foreach ($queryMeta as $index => $tax) {
                if ($tax['relation']) {
                    $query_tax_count = count($tax['meta_query']);
                    if ($query_tax_count >= 2) {
                        $this->final['meta_query'][$index][0]['relation'] = $tax['relation'];
                    }
                }
                if ($tax['meta_query']) {
                    foreach ($tax['meta_query'] as $indexer => $taxer) {
                        foreach ($taxer as $key => $taxValuer) {
                            if ($key != 'title') {
                                if ($taxValuer && $taxValuer['source'] === 'static' && isset($taxValuer['field']) && Cwicly\Helpers::check_if_exists($taxValuer['field'])) {
                                    if (is_array($taxValuer['field'])) {
                                        foreach ($taxValuer['field'] as $index => $post) {
                                            $this->final['meta_query'][$index][0][$indexer][$key] = $post['value'];
                                        }
                                    } else if (is_string($taxValuer['field'])) {
                                        $this->final['meta_query'][$index][0][$indexer][$key] = $taxValuer['field'];
                                    } else if (is_bool($taxValuer['field'])) {
                                        $this->final['meta_query'][$index][0][$indexer][$key] = $taxValuer['field'] ? true : false;
                                    }
                                } else if (is_array($taxValuer) && $taxValuer && $taxValuer['source'] === 'dynamic') {
                                    $this->final['meta_query'][$index][0][$indexer][$key] = $this->dynamicMaker($taxValuer, $postId);
                                    $this->dynamicURLChecker($taxValuer, $key);
                                } else if (is_string($taxValuer) && $key != 'multiple') {
                                    $this->final['meta_query'][$index][0][$indexer][$key] = $taxValuer;
                                } else if (is_bool($taxValuer)) {
                                    $this->final['meta_query'][$index][0][$indexer][$key] = $taxValuer ? 'true' : 'false';
                                }
                            }
                        }
                    }
                }
                if ($queryMetaRelation) {
                    $query_tax_count = count($queryMeta);
                    if ($query_tax_count >= 2) {
                        $this->final['meta_query']['relation'] = $queryMetaRelation;
                    }
                }
                foreach ($tax as $key => $taxValue) {
                    if (is_array($taxValue) && $taxValue && $taxValue['source'] === 'static' && isset($taxValue['field']) && Cwicly\Helpers::check_if_exists($taxValue['field'])) {
                        if (isset($taxValue['formatType']) && $taxValue['formatType']) {
                            $this->final['meta_query'][$index][$key] = $this->typeMaker($taxValue['formatType'], $taxValue['field']);
                        } else {
                            if (is_array($taxValue['field'])) {
                                foreach ($taxValue['field'] as $index => $post) {
                                    $this->final['meta_query'][$index][$key] = $post['value'];
                                }
                            } else if (is_string($taxValue['field'])) {
                                $this->final['meta_query'][$index][$key] = $taxValue['field'];
                            } else if (is_bool($taxValue['field'])) {
                                $this->final['meta_query'][$index][$key] = $taxValue['field'] ? true : false;
                            }
                        }
                    } else if (is_array($taxValue) && $taxValue && $taxValue['source'] === 'dynamic') {
                        $type = '';
                        if (isset($taxValue['formatType']) && $taxValue['formatType']) {
                            $type = $taxValue['formatType'];
                        }
                        $this->final['meta_query'][$index][$key] = $this->dynamicMaker($taxValue, $postId, false, $type);
                        $this->dynamicURLChecker($taxValue, 'meta_query|' . $index . '|' . $key . '');
                    } else if (is_string($taxValue) && $key != 'multiple' && $key != 'relation') {
                        $this->final['meta_query'][$index][$key] = $taxValue;
                    } else if (is_bool($taxValue) && $key != 'multiple') {
                        $this->final['meta_query'][$index][$key] = $taxValue ? true : false;
                    }
                }
            }
        }
        if ($queryDate) {
            foreach ($queryDate as $index => $tax) {
                if ($tax['multiple']) {
                    if ($tax['relation']) {
                        $query_tax_count = count($tax['date_query']);
                        if ($query_tax_count >= 2) {
                            $this->final['date_query'][$index]['relation'] = $tax['relation'];
                        }
                    }
                    if ($tax['date_query']) {
                        foreach ($tax['date_query'] as $indexer => $taxer) {
                            foreach ($taxer as $key => $taxValuer) {
                                if ($key != 'title') {
                                    if ($key === 'before' || $key === 'after') {
                                    } else if ($taxValuer && $taxValuer['source'] === 'static' && isset($taxValuer['field']) && Cwicly\Helpers::check_if_exists($taxValuer['field'])) {
                                        if (is_array($taxValuer['field'])) {
                                            foreach ($taxValuer['field'] as $index => $post) {
                                                $this->final['date_query'][$index][$indexer][$key] = $post['value'];
                                            }
                                        } else if (is_string($taxValuer['field'])) {
                                            $this->final['date_query'][$index][$indexer][$key] = $taxValuer['field'];
                                        } else if (is_bool($taxValuer['field'])) {
                                            $this->final['date_query'][$index][$indexer][$key] = $taxValuer['field'] ? true : false;
                                        }
                                    } else if (is_array($taxValuer) && $taxValuer && $taxValuer['source'] === 'dynamic') {
                                        $this->final['date_query'][$index][$key] = $this->dynamicMaker($taxValuer, $postId);
                                        $this->dynamicURLChecker($taxValue, 'date_query|' . $index . '|' . $key . '');
                                    } else if (is_string($taxValuer) && $key != 'multiple') {
                                        $this->final['date_query'][$index][$indexer][$key] = $taxValuer;
                                    } else if (is_bool($taxValuer)) {
                                        $this->final['date_query'][$index][$indexer][$key] = $taxValuer ? 'true' : 'false';
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if ($queryDateRelation) {
                        $query_tax_count = count($queryDate);
                        if ($query_tax_count >= 2) {
                            $this->final['date_query']['relation'] = $queryDateRelation;
                        }
                    }
                    foreach ($tax as $key => $taxValue) {
                        if ($key === 'before' || $key === 'after') {
                            foreach ($taxValue as $baKey => $baValue) {
                                if (is_array($baValue) && $baValue && $baValue['source'] === 'static' && isset($baValue['field']) && Cwicly\Helpers::check_if_exists($baValue['field'])) {
                                    if (is_array($baValue['field'])) {
                                        foreach ($baValue['field'] as $index => $post) {
                                            $this->final['date_query'][$index][$key][$baKey] = $post['value'];
                                        }
                                    } else if (is_string($baValue['field'])) {
                                        $this->final['date_query'][$index][$key][$baKey] = $baValue['field'];
                                    } else if (is_bool($baValue['field'])) {
                                        $this->final['date_query'][$index][$key][$baKey] = $baValue['field'] ? true : false;
                                    }
                                } else if (is_array($baValue) && $baValue && $baValue['source'] === 'dynamic') {
                                    $this->final['date_query'][$index][$key][$baKey] = $this->dynamicMaker($baValue, $postId);
                                    $this->dynamicURLChecker($baValue, 'date_query|' . $index . '|' . $baKey . '');
                                } else if (is_string($baValue) && $baKey != 'multiple' && $baKey != 'relation') {
                                    $this->final['date_query'][$index][$key][$baKey] = $baValue;
                                } else if (is_bool($baValue) && $baKey != 'multiple') {
                                    $this->final['date_query'][$index][$key][$baKey] = $baValue ? true : false;
                                }
                            }
                        } else if (is_array($taxValue) && $taxValue && $taxValue['source'] === 'static' && isset($taxValue['field']) && Cwicly\Helpers::check_if_exists($taxValue['field'])) {
                            if (is_array($taxValue['field'])) {
                                foreach ($taxValue['field'] as $index => $post) {
                                    $this->final['date_query'][$index][$key] = $post['value'];
                                }
                            } else if (is_string($taxValue['field'])) {
                                $this->final['date_query'][$index][$key] = $taxValue['field'];
                            } else if (is_bool($taxValue['field'])) {
                                $this->final['date_query'][$index][$key] = $taxValue['field'] ? true : false;
                            }
                        } else if (is_array($taxValue) && $taxValue && $taxValue['source'] === 'dynamic') {
                            $this->final['date_query'][$index][$key] = $this->dynamicMaker($taxValue, $postId);
                            $this->dynamicURLChecker($taxValue, 'date_query|' . $index . '|' . $key . '');
                        } else if (is_string($taxValue) && $key != 'multiple' && $key != 'relation') {
                            $this->final['date_query'][$index][$key] = $taxValue;
                        } else if (is_bool($taxValue) && $key != 'multiple') {
                            $this->final['date_query'][$index][$key] = $taxValue ? true : false;
                        }
                    }
                }
            }
        }

        $this->singleValueMaker($queryOrderBy, $postId, 'orderby', $this->final);
        $this->singleValueMaker($queryMetaKey, $postId, 'meta_key', $this->final);
        $this->singleValueMaker($queryOrder, $postId, 'order', $this->final);
        $this->singleValueMaker($queryOffset, $postId, 'offset', $this->final, true);
        $this->singleValueMaker($queryPage, $postId, 'paged', $this->final);
        $this->singleValueMaker($queryPage, $postId, 'page', $this->final);
        if ($returnparams) {
            return array(
                'args' => $this->final,
                'params' => $this->urlparams,
            );
        } else {
            return $this->final;
        }
    }
}
