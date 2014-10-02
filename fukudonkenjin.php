<?php
/*
Plugin Name: Fukudonkenjin
Version: 0.1
Description: サイト内にある「福井県」の文字列を「福丼県」に置換して表示します。置換対象は、記事タイトル・本文・抜粋・カテゴリー名・タグ名・テキストウィジェット・著者ページのプロフィール情報です。勢いで作りました。後悔はしてません。
Author: Tecking
Author URI: https://github.com/tecking
Text Domain: fukudonkenjin
Domain Path: /languages
*/
/*  Copyright 2014 Tecking (email : tecking@tecking.org)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


add_filter( 'the_title',              'fdk_str_replace' );
add_filter( 'the_content',            'fdk_str_replace' );
add_filter( 'the_excerpt',            'fdk_str_replace' );
add_filter( 'the_author_description', 'fdk_str_replace' );
add_filter( 'widget_text',            'fdk_str_replace' );
add_filter( 'the_category',           'fdk_str_replace' );
add_filter( 'wp_list_categories',     'fdk_str_replace' );
add_filter( 'the_tags',               'fdk_str_replace' );
add_filter( 'wp_tag_cloud',           'fdk_str_replace' );

function fdk_str_replace( $content ) {
	return str_replace( '福井県', '福丼県', $content );
}
