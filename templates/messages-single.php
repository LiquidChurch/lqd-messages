<?php
    $message = $this->get('message');
    $series = $message->get_series();
    $atts = $this->get('atts');
    $plugin_option = $this->get('plugin_option');

    $this->output('inline_style');
?>
<article id="post-<?php echo $message->post->ID; ?>" <?php post_class('', $message->post->ID); ?>>

    <div class="entry-content" style="">
        <div class="row">
            <div id="top-row-single-message" class="row">
                <div id="single-message-player" class="col-sm-12">
                    <?php
                        if ($atts['show_media'] == 'video_player') :
                            ?>
                            <div class="message-video">
                                <?php echo lqdm_get_message_video_player($message); ?>
                            </div>
                            <script type="text/javascript">
                                jQuery(function ($) {
                                    jQuery('.message-video').fitVids();
                                });
                            </script>
                        <?php
                            elseif ($atts['show_media'] == 'audio_player'):
                        ?>
                            <div class="message-video">
                                <?php echo lqdm_get_message_audio_player($message); ?>
                            </div>
                            <script type="text/javascript">
                                jQuery(function ($) {
                                    jQuery('.message-video').fitVids();
                                });
                            </script>
                            <?php
                        elseif ($atts['show_media'] == 'featured_image'):
                            echo $message->featured_image();
                        elseif ($atts['show_media'] == 'series_image'):
                            echo $message->series_image();
                        endif; ?>
                </div>
                <div class="row" style="padding-left:55px;padding-right:55px;">

                    <div id="single-message-content" class="col-md-12">

                        <?php
                            if ($atts['show_title'] == 'true') {
                                ?>
                                <div class="row single-message-title">
                                    <header class="entry-header col-sm-7" style="margin-top: 20px;">
                                        <h1 class="lqdm-message-title">
                                            <?php
                                                echo $message->post->post_title;
                                            ?>
                                        </h1>
                                    </header><!-- .entry-header -->

                                    <?php
                                        if ($atts['show_image'] == 'series_image') {
                                            $image_id = $message->series_image('thumbnail', '',
                                                'id');
                                        } else {
                                            $image_id = $message->featured_image_id();
                                        }

                                        if (!empty($image_id)) {
                                            ?>
                                            <div class="col-sm-5 lqdm-right-col">
                                                <?php echo wp_get_attachment_image($image_id,
                                                    'full', false, array(
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
                            if ($atts['show_series'] == 'true' && !empty($series)) {
                                ?>
                                <div id="message-series" class="row">
                                    <div class="col-sm-3">
                                        <b>Series:</b>
                                    </div>
                                    <div class="col-sm-9">
                                        <?php
                                            echo '<a href="' . $series->term_link . '">' .
                                                 $series->name . '</a>';
                                        ?>
                                    </div>
                                </div>
                                <?php
                            }
                        ?>

                        <?php
                            if ($atts['show_speakers'] == 'true') {
                                $speakers = $message->get_speakers();
                                if (!empty($speakers)) {
                                    ?>
                                    <div id="message-speaker" class="row">
                                        <div class="col-sm-3">
                                            <b>Speaker:</b>
                                        </div>
                                        <div class="col-sm-9">
                                            <?php
                                                $speaker = array();
                                                foreach ($speakers as $key => $val) {
                                                    $speaker[] = $val->name;
                                                }
                                                echo implode(', ', $speaker);

                                                /* TODO: Link the name of the speaker.
                                                echo $speaker_url->slug; */
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        ?>

                        <?php
                            if ($atts['show_part_of_series'] == 'true') {
                                $display_order = $message->get_meta('lqdm_display_order');
                                if (!empty($display_order)) {
                                    ?>
                                    <div id="message-series-part" class="row">
                                        <div class="col-sm-3">
                                            <b>Part:</b>
                                        </div>
                                        <div class="col-sm-9">
                                            <?php
                                                echo $display_order;
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        ?>

                        <?php
                            if ($atts['show_scripture_references'] == 'true') {
                                $scriptures = $message->get_scriptures();
                                if (!empty($scriptures)) {
                                    ?>
                                    <div id="message-scripture" class="row">
                                        <div class="col-sm-3">
                                            <b>Scriptures:</b>
                                        </div>
                                        <div class="col-sm-9">
                                            <?php
                                                $scripture = array();
                                                foreach ($scriptures as $key => $val) {
                                                    $scripture[] = $val->name;
                                                }
                                                echo implode(', ', $scripture);
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        ?>

                        <?php
                            if ($atts['show_topics'] == 'true') {
                                $topics = $message->topics();
                                if (!empty($topics)) {
                                    ?>
                                    <div id="message-topics" class="row">
                                        <div class="col-sm-3">
                                            <b>Topic:</b>
                                        </div>
                                        <div class="col-sm-9">
                                            <?php
                                                $topic = array();
                                                foreach ($topics as $key => $val) {
                                                    $topic[] = $val->name;
                                                }
                                                echo implode(', ', $topic);
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        ?>

                        <?php
                            if ($atts['show_tags'] == 'true') {
                                $tags = $message->tags();
                                if (!empty($tags)) {
                                    ?>
                                    <div id="message-tags" class="row">
                                        <div class="col-sm-3">
                                            <b>Tag:</b>
                                        </div>
                                        <div class="col-sm-9">
                                            <?php
                                                $tag = array();
                                                foreach ($tags as $key => $val) {
                                                    $tag[] = $val->name;
                                                }
                                                echo implode(', ', $tag);
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        ?>

                        <?php
                            if ($atts['show_content'] == 'true') {
                                $content = strip_tags($message->post->post_content);
                                if (!empty($content)) {
                                    ?>
                                    <div id="message-summary" class="row">
                                        <div class="col-sm-3">
                                            <b>Summary:</b>
                                        </div>
                                        <div class="col-sm-9">
                                            <?php
                                                echo $content;
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        ?>

                        <?php
                            if ($atts['show_date_published'] == 'true') {
                                if (!empty($message->post->post_date)) {
                                    ?>
                                    <div id="message-date" class="row">
                                        <div class="col-sm-3">
                                            <b>Date:</b>
                                        </div>
                                        <div class="col-sm-9">
                                            <?php
                                                echo date('M d Y',
                                                    strtotime($message->post->post_date));
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        ?>

                        <?php
                            if ($atts['show_additional_resource'] == 'true') {
                                $addtl_resources
                                    = do_shortcode('[message_resources resource_post_id="' .
                                                   $message->post->ID .
                                                   '" resource_display_name="true"]');

                                if (!empty($addtl_resources) &&
                                    ($addtl_resources != '<!-- no resources found -->')
                                ) {
                                    ?>
                                    <div id="message-resource" class="row">
                                        <div class="col-sm-3">
                                            <b>Resources:</b>
                                        </div>
                                        <div class="col-sm-9">
                                            <?php
                                                echo $addtl_resources;
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        ?>

                    </div>
                </div>
            </div>
            <?php
                if ($atts['show_others_in_series'] == 'true' && !empty($series)) {
                    $other_msg
                        = do_shortcode('[lqdm_messages per_page="5" related_series="' .
                                       $series->term_id .
                                       '" thumbnail_size="medium" number_columns="4"]');
                    if (!empty($other_msg)) {
                        ?>
                        <div id="message-others" class="row lqdm-individual-message-list">
                            <h1 class="lqdm-message-title other-msg-title"
                                style="padding-left: 8px !important;">Other Messages in
                                This
                                Series</h1>
                            <?php
                                echo $other_msg;
                            ?>
                        </div>
                        <?php
                    }
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
