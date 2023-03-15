<?php
namespace Cwicly;

if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

class Capabilities
{
    public static function permission($type, $condition)
    {
        if (is_admin()) {
            return;
        }
        $user_roles = Helpers::get_current_user_roles();
        $role_editor = get_option("cwicly_role_editor");
        $current_user = get_current_user_id();

        $final = false;

        if ($user_roles && is_array($user_roles) && count($user_roles) > 0 && $role_editor && is_array($role_editor) && count($role_editor) > 0) {
            if (isset($current_user) && isset($role_editor["user_" . $current_user])) {
                if (get_post_type() && isset($role_editor["user_" . $current_user]['postTypes']['hideList']) && in_array(get_post_type(), $role_editor["user_" . $current_user]['postTypes']['hideList'])) {
                    return false;
                } else {
                    if (isset($role_editor["user_" . $current_user][$type][$condition])) {
                        $final = $role_editor["user_" . $current_user][$type][$condition];
                    }
                    return $final;
                }
            } else if (isset($role_editor)) {
                if (get_post_type() && isset($role_editor[$user_roles[0]]['postTypes']['hideList']) && in_array(get_post_type(), $role_editor[$user_roles[0]]['postTypes']['hideList'])) {
                    return false;
                } else {
                    $user_roles = wp_get_current_user()->roles;
                    foreach ($role_editor as $role => $value) {
                        if (array_intersect($user_roles, [$role])) {
                            if (isset($value[$type][$condition])) {
                                $final = $value[$type][$condition];
                            }
                        }
                    }
                    return $final;
                }
            }
        }
    }
}
