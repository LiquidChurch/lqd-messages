<?php
global $wp_embed, $content_width;
echo $wp_embed->shortcode( $this->get( 'embed_args', [] ), esc_url( $this->get( 'file' ) ) );
