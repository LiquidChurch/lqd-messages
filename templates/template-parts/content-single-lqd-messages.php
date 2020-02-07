<?php
/**
 * The template part for displaying single sermon
 *
 * @package WordPress
 * @subpackage Liquid_Church
 * @since Liquid Church 1.0
 */

// Get Sermon object
global $sermon;
$sermon = lqdm_get_sermon_post();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="entry-content" style="">
        <div class="row">
            <div id="top-row-single-sermon" class="row">
                <div id="lqdm-single-sermon-player" class="col-sm-12">
                    <?php if ($video_player = lqdm_get_sermon_video_player($sermon)) : ?>
                        <div class="lqdm-video">
                            <?php echo $video_player; ?>
                        </div>
                    <?php
                    // Enqueue fitvids for responsive video.
                    wp_enqueue_script(
                        'fitvids',
                        Lqd_Messages_Plugin::$url . 'assets/js/vendor/jquery.fitvids.js',
                        [ 'jquery' ],
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
                        <?php lqdm_post_thumbnail(); ?>
                    <?php endif; ?>
                </div>
                <div class="row" style="padding-left:55px;padding-right:55px;">

                    <?php
                    $message_field_to_display = [];
                    $plugin_option = Lqd_Messages_Plugin::get_plugin_settings_options('single_message_view');
                    if (!empty($plugin_option))
                        $message_field_to_display = !empty($plugin_option['message_field_to_display']) ? $plugin_option['message_field_to_display'] : [];
                    ?>

                    <div id="lqdm-single-sermon-content" class="col-md-12">

                        <?php
                        if (in_array('title', $message_field_to_display)) {
                            ?>
                            <div class="row lqdm-single-sermon-title">
                                <header class="entry-header col-sm-7" style="margin-top: 20px;">

                                    <?php
                                    the_title('<h1 class="lqdm-sermon-title">', '</h1>');
                                    ?>

                                </header><!-- .entry-header -->

                                <?php
                                if (in_array('sermon_image', $message_field_to_display)) {
                                    ?>
                                    <div class="col-sm-5 lqdm-right-col">
                                        <?php echo wp_get_attachment_image($sermon->featured_image_id(), 'full', false, [
                                            'class' => 'lqdm-series-list-sermons-img',
                                            'style' => 'width:100%;',
                                        ] ); ?>
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
                            get_template_part('template-parts/part/sermons/list', 'series');
                        }
                        ?>

                        <?php
                        if (in_array('speakers', $message_field_to_display)) {
                            //speaker list template part
                            get_template_part('template-parts/part/sermons/list', 'speaker');
                        }
                        ?>

                        <?php
                        $exclude_msg = $sermon->get_meta('lqdm_exclude_msg');
                        if (in_array('part_of_series', $message_field_to_display)
                            && ($exclude_msg != 'on')
                        ) {
                            //series part list template part
                            get_template_part('template-parts/part/sermons/list', 'series-part');
                        }
                        ?>

                        <?php
                        if (in_array('scripture_reference', $message_field_to_display)) {
                            //scripture list template part
                            get_template_part('template-parts/part/sermons/list', 'scripture');
                        }
                        ?>

                        <?php
                        if (in_array('topics', $message_field_to_display)) {
                            //topics list template part
                            get_template_part('template-parts/part/sermons/list', 'topics');
                        }
                        ?>

                        <?php
                        if (in_array('tags', $message_field_to_display)) {
                            //tags list template part
                            get_template_part('template-parts/part/sermons/list', 'tags');
                        }
                        ?>

                        <?php
                        if (in_array('description', $message_field_to_display)) {
                            //summary list template part
                            get_template_part('template-parts/part/sermons/list', 'summary');
                        }
                        ?>

                        <?php
                        if (in_array('date', $message_field_to_display)) {
                            //summary list template part
                            get_template_part('template-parts/part/sermons/list', 'date');
                        }
                        ?>

                        <?php
                        if (in_array('additional_resource', $message_field_to_display)) {
                            //addtnl-resource list template part
                            get_template_part('template-parts/part/sermons/list', 'addtnl-resource');
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
            $other_msg = do_shortcode('[lqdm_messages per_page="5" related_series="this" thumbnail_size="medium" number_columns="4"]');
            if (!empty($other_msg)) {
                ?>
                <div id="lqdm-message-others" class="row lqdm-individual-sermon-list">
                    <h1 class="lqdm-sermon-title other-msg-title" style="padding-left: 8px !important;">Other Messages in
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
