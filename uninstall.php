<?php

if ( !defined( 'WP_UNINSTALL_PLUGIN') ) exit();

function fdk_delete_plugin() {
	delete_option( 'fkd_settings' );
}

fdk_delete_plugin();
