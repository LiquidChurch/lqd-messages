<?php
/**
 * The template part for displaying single message
 *
 * @package WordPress
 * @subpackage Liquid_Church
 * @since Liquid Church 1.0
 */

// Get Message object
global $message;
$message = lqdm_get_message_post();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="entry-content" style="">
        <div class="row">
            <div id="top-row-single-message" class="row">
                <div id="single-message-player" class="col-sm-12">
                    <?php if ($video_player = lqdm_get_message_video_player($message)) : ?>
                        <div class="message-video">
                            <?php echo $video_player; ?>
                        </div>
                    <?php
                    // Enqueue fitvids for responsive video.
                    wp_enqueue_script(
                        'fitvids',
                        Lqd_Messages_Plugin::$url . 'assets/js/vendor/jquery.fitvids.js',
                        array('jquery'),
                        '1.1',
                        true
                    );
                    ?>
                        <script type="text/javascript">
                            jQuery(function ($) {
                                jQuery('.message-video').fitVids();
                            });
                        </script>
                    <?php else : ?>
                        <?php liquidchurch_post_thumbnail(); ?>
                    <?php endif; ?>
                </div>
                <div class="row" style="padding-left:55px;padding-right:55px;">

                    <?php
                    $message_field_to_display = array();
                    $plugin_option = Lqd_Messages_Plugin::get_plugin_settings_options('single_message_view');
                    if (!empty($plugin_option))
                        $message_field_to_display = !empty($plugin_option['message_field_to_display']) ? $plugin_option['message_field_to_display'] : array();
                    //                    p($message_field_to_display, 0);
                    ?>

                    <div id="single-message-content" class="col-md-12">

                        <?php
                        if (in_array('title', $message_field_to_display)) {
                            ?>
                            <div class="row single-message-title">
                                <header class="entry-header col-sm-7" style="margin-top: 20px;">

                                    <?php
                                    the_title( '<h1 class="lqdm-message-title">', '</h1>');
                                    ?>

                                </header><!-- .entry-header -->

                                <?php
                                if (in_array('message_image', $message_field_to_display)) {
                                    ?>
                                    <div class="col-sm-5 lqdm-right-col">
                                        <?php echo wp_get_attachment_image($message->featured_image_id(), 'full', false, array(
                                            'class' => 'lqdm-series-list-messages-img',
                                            'style' => 'width:100%;',
                                        )); ?>
                                    </div>
                                    <?php
                                }
                                ?>

                            </div>
                            <?php
                        }
                        ?>

                        <?php
                        if (in_array('series', $message_field_to_display)) {
                            //series list template part
                            get_template_part('template-parts/part/messages/list', 'series');
                        }
                        ?>

                        <?php
                        if (in_array('speakers', $message_field_to_display)) {
                            //speaker list template part
                            get_template_part('template-parts/part/messages/list', 'speaker');
                        }
                        ?>

                        <?php
                        $exclude_msg = $message->get_meta('lqdm_exclude_msg');
                        if (in_array('part_of_series', $message_field_to_display)
                            && ($exclude_msg != 'on')
                        ) {
                            //series part list template part
                            get_template_part('template-parts/part/messages/list', 'series-part');
                        }
                        ?>

                        <?php
                        if (in_array('scripture_reference', $message_field_to_display)) {
                            //scripture list template part
                            get_template_part('template-parts/part/messages/list', 'scripture');
                        }
                        ?>

                        <?php
                        if (in_array('topics', $message_field_to_display)) {
                            //topics list template part
                            get_template_part('template-parts/part/messages/list', 'topics');
                        }
                        ?>

                        <?php
                        if (in_array('tags', $message_field_to_display)) {
                            //tags list template part
                            get_template_part('template-parts/part/messages/list', 'tags');
                        }
                        ?>

                        <?php
                        if (in_array('description', $message_field_to_display)) {
                            //summary list template part
                            get_template_part('template-parts/part/messages/list', 'summary');
                        }
                        ?>

                        <?php
                        if (in_array('date', $message_field_to_display)) {
                            //summary list template part
                            get_template_part('template-parts/part/messages/list', 'date');
                        }
                        ?>

                        <?php
                        if (in_array('additional_resource', $message_field_to_display)) {
                            //addtnl-resource list template part
                            get_template_part('template-parts/part/messages/list', 'addtnl-resource');
                        }
                        ?>

                    </div>
                </div>
            </div>
            <?php
            $other_msg = do_shortcode('[lqdm_messages per_page="5" related_series="this" thumbnail_size="medium" number_columns="4"]');
            if (!empty($other_msg)) {
                ?>
                <div id="message-others" class="row lqdm-individual-message-list">
                    <h1 class="lqdm-message-title other-msg-title" style="padding-left: 8px !important;">Other Messages in
                        This
                        Series</h1>
                    <?php
                    echo $other_msg;
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php liquidchurch_entry_meta(); ?>
        <?php
        edit_post_link(
            sprintf(
            /* translators: %s: Name of current post */
                __('Edit<span class="screen-reader-text"> "%s"</span>', 'liquidchurch'),
                get_the_title()
            ),
            '<span class="edit-link">',
            '</span>'
        );
        ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-## -->
