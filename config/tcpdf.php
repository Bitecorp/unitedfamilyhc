<?php
return [
    'page_format'           => 'A4',
    'page_orientation'      => 'P',
    'unicode'               => true,
    'encoding'              => 'UTF-8',
    'font_directory'        => '',
    'image_directory'       => 'https://app.unitedfamilyhc.com/',
    'image_background'      => '',
    'tcpdf_throw_exception' => true,
    'use_fpdi'              => false,
    'use_original_header'   => true,
    'use_original_footer'   => true,
    'pdfa'                  => true, 
    // Options: false, 1, 3

    // See more info at the tcpdf_config.php file in TCPDF (if you do not set this here, TCPDF will use it default)
    // https://raw.githubusercontent.com/tecnickcom/TCPDF/master/config/tcpdf_config.php

    'path_main'           => '', // K_PATH_MAIN
    'path_url'            => '', // K_PATH_URL
    'header_logo'         => '', // PDF_HEADER_LOGO
    'header_logo_width'   => '0', // PDF_HEADER_LOGO_WIDTH
    //    'path_cache'          => '', // K_PATH_CACHE
    //    'blank_image'         => '', // K_BLANK_IMAGE
    'creator'             => 'TCPDF', // PDF_CREATOR
    'author'              => 'UNITED FAMILY HEALTHCARE INC.', // PDF_AUTHOR
    'header_title'        => 'Document Create for UNITED FAMILY HEALTHCARE INC.', // PDF_HEADER_TITLE
    'header_string'       => 'by UNITED FAMILY HEALTHCARE INC. - unitedfamilyhc.com', // PDF_HEADER_STRING
    'page_units'          => 'mm', // PDF_UNIT
    'margin_header'       => '5', // PDF_MARGIN_HEADER
    'margin_footer'       => '15', // PDF_MARGIN_FOOTER
    'margin_top'          => '27', // PDF_MARGIN_TOP
    'margin_bottom'       => '22', // PDF_MARGIN_BOTTOM
    'margin_left'         => '17', // PDF_MARGIN_LEFT
    'margin_right'        => '15', // PDF_MARGIN_RIGHT
    //    'font_name_main'      => '', // PDF_FONT_NAME_MAIN
    //    'font_size_main'      => '', // PDF_FONT_SIZE_MAIN
    //    'font_name_data'      => '', // PDF_FONT_NAME_DATA
    //    'font_size_data'      => '', // PDF_FONT_SIZE_DATA
    //    'foto_monospaced'     => '', // PDF_FONT_MONOSPACED
    //    'image_scale_ratio'   => '', // PDF_IMAGE_SCALE_RATIO
    //    'head_magnification'  => '', // HEAD_MAGNIFICATION
    //    'cell_height_ratio'   => '', // K_CELL_HEIGHT_RATIO
    //    'title_magnification' => '', // K_TITLE_MAGNIFICATION
    //    'small_ratio'         => '', // K_SMALL_RATIO
    //    'thai_topchars'       => '', // K_THAI_TOPCHARS
    'tcpdf_calls_in_html' => true, // K_TCPDF_CALLS_IN_HTML
    'timezone'            => 'UTC', // K_TIMEZONE
];
