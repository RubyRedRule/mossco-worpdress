<div class="cc-comments<?php echo (have_comments() && comments_open() )?' have-comments':' no-comment'; ?>">
    <?php 
    if ( post_password_required() ) { ?>
        <p class="no-comments">
        <?php esc_html_e('This post is password protected. Enter the password to view comments.', 'cwicly'); ?>
        </p>
        <?php 
        return; 
    }
    if ( have_comments() ) : ?>
        <?php if ( is_singular() ) wp_enqueue_script( "comment-reply" ); ?>
        <h3 id="comments" class="second-font">
            <span>
                <?php
                $comments_number = get_comments_number();
                if ( '1' === $comments_number ) {
                    echo esc_html__( '1 comment', 'cwicly' );
                } else {
                    printf(
                        _nx(
                            '%1$s comment',
                            '%1$s comments',
                            $comments_number,
                            'comments title',
                            'cwicly'
                        ),
                        number_format_i18n( $comments_number ),
                        get_the_title()
                    );
                }
                ?>
            </span>
        </h3>
        <ul class="commentlist">
            <?php wp_list_comments('callback=cwicly_comment'); ?>
        </ul>
        <div class="navigation"><div class="pagination">
            <?php paginate_comments_links(); ?> 
        </div></div>
    <?php
    endif;
    if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
        <p class="no-comments"><?php echo esc_html__( 'Comments are closed.', 'cwicly' ); ?></p>
    <?php
    endif;

    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $commenter = wp_get_current_commenter();
    $consent  = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';
    //Custom Fields
    $fields =  array(
        'author'=> '<div class="text-field"><div><input name="author" type="text" placeholder="' . esc_attr__('Name *', 'cwicly') . '" size="30"' . esc_attr($aria_req) . ' /></div>',
        'email' => '<div><input name="email" type="text" placeholder="' . esc_attr__('E-Mail *', 'cwicly') . '" size="30"' . esc_attr($aria_req) . ' /></div>',
        'url'   => '<div><input name="url" type="text" placeholder="' . esc_attr__('Your website', 'cwicly') . '" size="30" /></div></div>',
        'cookies' => '<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . esc_attr($consent) . ' />' .
                     '<label for="wp-comment-cookies-consent">' . esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'cwicly' ) . '</label></p>',
    );
    //Comment Form Args
    $comments_args = array(
        'fields' => $fields,
        'title_reply'=>'<span class="second-font">'. esc_html__('Leave a comment', 'cwicly') .'</span>',
        'comment_field' => '<div class="your-comment"><textarea id="comment" name="comment" placeholder="' . esc_attr__('Your comment *', 'cwicly') . '" aria-required="true" cols="58" rows="8" tabindex="4"></textarea></div>',
        'label_submit' => esc_html__('Submit comment','cwicly') ,
        'comment_notes_before' => '<p class="comment-notes"><span id="email-notes">' . esc_html__( 'Your email address will not be published.', 'cwicly' ) . '</span>' . esc_html__( ' Required fields are marked ', 'cwicly' ) . '<span class="required">*</span></p>',
        'comment_notes_after' => '',
        'class_submit' => 'cc-button'
    );
    comment_form($comments_args);
    ?>
</div>