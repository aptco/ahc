<?php
/*
 * Login rebuilder properties page content
 *
 * @since 2.0.0
 *
 * @package WordPress
 *
 * require login_rebuilder::properties()
 */

if ( !( isset( $this ) && is_a( $this, 'login_rebuilder' ) ) ) die( 0 );
?>
<div id="<?php echo self::LOGIN_REBUILDER_PROPERTIES_NAME; ?>" class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>
<h2><?php _e( 'Login rebuilder', LOGIN_REBUILDER_DOMAIN ); ?> <?php _e( 'Settings' ) ;?></h2>
<?php $this->_properties_message( $message ); ?>

<div id="login-rebuilder-widget" class="metabox-holder">
<p><?php _e( 'Notice: This page is valid for 30 minutes.', LOGIN_REBUILDER_DOMAIN ); ?></p>
<?php if ( $show_reload ) { ?>
<p><a href="<?php echo esc_url( str_replace( '%07E', '~', $this->request_uri ) ); ?>" class="button"><?php _e( 'Reload now.', LOGIN_REBUILDER_DOMAIN ); ?></a></p>
<?php } else { ?>
<form method="post" action="<?php echo esc_url( str_replace( '%07E', '~', $this->request_uri ) ); ?>">
<table summary="login rebuilder properties" class="form-table">
<tr valign="top">
<th><?php _e( 'Response to an invalid request', LOGIN_REBUILDER_DOMAIN ); ?></th>
<td>
<input type="radio" name="properties[response]" id="properties_response_1" value="<?php _e( self::LOGIN_REBUILDER_RESPONSE_403 ); ?>" <?php checked( $this->properties['response'] == self::LOGIN_REBUILDER_RESPONSE_403 ); ?> /><label for="properties_response_1">&nbsp;<span><?php _e( '403 status', LOGIN_REBUILDER_DOMAIN ); ?></span></label><br />
<input type="radio" name="properties[response]" id="properties_response_2" value="<?php _e( self::LOGIN_REBUILDER_RESPONSE_404 ); ?>" <?php checked( $this->properties['response'] == self::LOGIN_REBUILDER_RESPONSE_404 ); ?> /><label for="properties_response_2">&nbsp;<span><?php _e( '404 status', LOGIN_REBUILDER_DOMAIN ); ?></span></label><br />
<input type="radio" name="properties[response]" id="properties_response_3" value="<?php _e( self::LOGIN_REBUILDER_RESPONSE_GO_HOME ); ?>" <?php checked( $this->properties['response'] == self::LOGIN_REBUILDER_RESPONSE_GO_HOME ); ?> /><label for="properties_response_3">&nbsp;<span><?php _e( 'redirect to a site url', LOGIN_REBUILDER_DOMAIN ); echo ' ( '.home_url().' )'; ?></span></label><br />
</td>
</tr>

<tr valign="top">
<th><label for="properties_keyword"><?php _e( 'Login file keyword', LOGIN_REBUILDER_DOMAIN ); ?></label></th>
<td><input type="text" name="properties[keyword]" id="properties_keyword" value="<?php _e( $this->properties['keyword'] ); ?>" class="regular-text code" <?php if ( !$this->use_site_option ) echo 'readonly="readonly"'; ?> /></td>
</tr>

<tr valign="top">
<th><label for="properties_page"><?php _e( 'New login file', LOGIN_REBUILDER_DOMAIN ); ?></label></th>
<td><input type="text" name="properties[page]" id="properties_page" value="<?php _e( $this->properties['page'] ); ?>" class="regular-text code" />
<p style="padding: 0 0 0 1em; font-size: 92%; color: #666666;">Path: <span id="path_login" class="path">&nbsp;</span> <span id="writable" class="writable">&nbsp;</span><br />
URL: <span id="url_login" class="url">&nbsp;</span><br />
<textarea name="properties[content]" id="login_page_content" rows="4" style="font-family:monospace; width: 96%;" readonly="readonly" class="content"></textarea><input type="hidden" id="content_template" value="<?php echo $this->content; ?>" /></p>
</td>
</tr>
<tr valign="top">
<th><label for="properties_page"><?php _e( 'Secondary login file', LOGIN_REBUILDER_DOMAIN ); ?></label></th>
<td><input type="text" name="properties[page_subscriber]" id="properties_page_subscriber" value="<?php _e( $this->properties['page_subscriber'] ); ?>" class="regular-text code" />
<p style="padding: 0 0 0 1em; font-size: 92%; color: #666666;">Path: <span id="path_subscriber" class="path">&nbsp;</span> <span id="writable_subscriber" class="writable">&nbsp;</span><br />
URL: <span id="url_subscriber" class="url">&nbsp;</span><br />
<textarea name="properties[content_subscriber]" id="subscriber_page_content" rows="4" style="font-family:monospace; width: 96%;" readonly="readonly" class="content"></textarea><br />
<?php _e( 'Role' ); ?>: <?php
$roles = get_editable_roles();
unset( $roles['administrator'] );
foreach ( array_reverse( $roles ) as $role => $details ) {
	$name = translate_user_role($details['name'] );
	$checked = in_array( $role, (array)$this->properties['secondary_roles'] )? ' checked="checked"': '';
	$role = esc_attr($role);
	echo '<input type="checkbox" name="properties[secondary_roles][]" id="secondary_'.$role.'" value="'.$role.'" '.$checked.'/><label for="secondary_'.$role.'">'.$name.'</label>&nbsp;&nbsp;&nbsp;';
}
?>
</p>
</td>
</tr>

<tr valign="top">
<th><?php _e( 'Status' ); ?></th>
<td>
<input type="radio" name="properties[status]" id="properties_status_0" value="<?php _e( self::LOGIN_REBUILDER_STATUS_IN_PREPARATION ); ?>" <?php checked( $this->properties['status'] == self::LOGIN_REBUILDER_STATUS_IN_PREPARATION ); ?> /><label for="properties_status_0">&nbsp;<span><?php _e( 'in preparation', LOGIN_REBUILDER_DOMAIN ); ?></span></label><br />
<input type="radio" name="properties[status]" id="properties_status_1" value="<?php _e( self::LOGIN_REBUILDER_STATUS_WORKING ); ?>" <?php checked( $this->properties['status'] == self::LOGIN_REBUILDER_STATUS_WORKING ); ?> /><label for="properties_status_1">&nbsp;<span><?php _e( 'working', LOGIN_REBUILDER_DOMAIN ); ?></span></label><br />
</td>
</tr>

<tr valign="top">
<th><?php _e( 'Logging', LOGIN_REBUILDER_DOMAIN ); ?></th>
<td>
<input type="radio" name="properties[logging]" id="properties_logging_0" value="<?php _e( self::LOGIN_REBUILDER_LOGGING_OFF ); ?>" <?php checked( $this->properties['logging'] == self::LOGIN_REBUILDER_LOGGING_OFF ); ?> /><label for="properties_logging_0">&nbsp;<span><?php _e( 'off', LOGIN_REBUILDER_DOMAIN ); ?></span></label><br />
<input type="radio" name="properties[logging]" id="properties_logging_1" value="<?php _e( self::LOGIN_REBUILDER_LOGGING_INVALID_REQUEST ); ?>" <?php checked( $this->properties['logging'] == self::LOGIN_REBUILDER_LOGGING_INVALID_REQUEST ); ?> /><label for="properties_logging_1">&nbsp;<span><?php _e( 'invalid request only', LOGIN_REBUILDER_DOMAIN ); ?></span></label><br />
<input type="radio" name="properties[logging]" id="properties_logging_2" value="<?php _e( self::LOGIN_REBUILDER_LOGGING_LOGIN ); ?>" <?php checked( $this->properties['logging'] == self::LOGIN_REBUILDER_LOGGING_LOGIN ); ?> /><label for="properties_logging_2">&nbsp;<span><?php _e( 'login only', LOGIN_REBUILDER_DOMAIN ); ?></span></label><br />
<input type="radio" name="properties[logging]" id="properties_logging_3" value="<?php _e( self::LOGIN_REBUILDER_LOGGING_ALL ); ?>" <?php checked( $this->properties['logging'] == self::LOGIN_REBUILDER_LOGGING_ALL ); ?> /><label for="properties_logging_3">&nbsp;<span><?php _e( 'all', LOGIN_REBUILDER_DOMAIN ); ?></span></label><br />
</td>
</tr>

<tr valign="top">
<th><?php _e( 'Other', LOGIN_REBUILDER_DOMAIN ); ?></th>
<td>
<input type="checkbox" name="properties[ambiguous_error_message]" id="properties_ambiguous_error_message" value="1" <?php checked( $this->properties['ambiguous_error_message'] ); ?> /><label for="properties_ambiguous_error_message">&nbsp;<span><?php _e( 'The error message when login, is changed to the ambiguous content.', LOGIN_REBUILDER_DOMAIN ); ?></span></label><br />
<input type="checkbox" name="properties[disable_authenticate_email_password]" id="properties_disable_authenticate_email_password" value="1" <?php checked( $this->properties['disable_authenticate_email_password'] ); ?> /><label for="properties_disable_authenticate_email_password">&nbsp;<span><?php _e( 'Authentication using a email address and a password is prohibited.', LOGIN_REBUILDER_DOMAIN ); ?></span></label><br />
</td>
</tr>

<tr valign="top">
<td colspan="2">
<input type="submit" name="submit" value="<?php esc_attr_e( 'Save Changes' ); ?>" class="button-primary" />
<?php if ( ( isset( $logging['invalid'] ) && is_array( $logging['invalid'] ) && count( $logging['invalid'] ) > 0 ) ||
		( isset( $logging['login'] ) && is_array( $logging['login'] ) && count( $logging['login'] ) > 0 ) ) { ?>
<input type="button" name="view-log" id="view-log" value="<?php esc_attr_e( 'View log', LOGIN_REBUILDER_DOMAIN ); ?>" class="button" />
<?php } wp_nonce_field( self::LOGIN_REBUILDER_PROPERTIES_NAME.$this->_nonce_suffix() ); $this->_private_nonce_field(); ?>
</td>
</tr>
</table>
</form>

<?php if ( ( isset( $logging['invalid'] ) && is_array( $logging['invalid'] ) && count( $logging['invalid'] ) > 0 ) ||
		( isset( $logging['login'] ) && is_array( $logging['login'] ) && count( $logging['login'] ) > 0 ) ) { ?>
<div id="log-content" style="display: none;">
<table summary="login rebuilder logs" class="form-table">
<tbody>
<tr>
<td style="vertical-align: top;">
<h3><?php _e( 'Log of invalid request', LOGIN_REBUILDER_DOMAIN ); ?></h3>
<?php
if ( isset( $logging['invalid'] ) && is_array( $logging['invalid'] ) ) {
	krsort( $logging['invalid'] );
	$this->_view_log_of_invalid_request( $logging['invalid'] );
}
?>
</td>
<td style="vertical-align: top;">
<h3><?php _e( 'Log of login', LOGIN_REBUILDER_DOMAIN ); ?></h3>
<?php
if ( isset( $logging['login'] ) && is_array( $logging['login'] ) ) {
	krsort( $logging['login'] );
	$this->_view_log_of_login( $logging['login'] );
}
?>
</td>
</tr>
</tbody>
</table>
</div>
<?php } /* logging */ } /* show reload */ ?>
</div>
</div>
<script type="text/javascript">
( function($) {
<?php if ( isset( $logout_to ) && $logout_from != $logout_to ) { ?>
	$( 'a' ).each( function () {
		$( this ).attr( 'href', $( this ).attr( 'href' ).replace( '<?php echo $logout_from; ?>', '<?php echo $logout_to; ?>' ) );
	} );
<?php } ?>
	$( '#properties_keyword' ).blur( function () {
		if ( $( '#properties_page' ).val() != '' && $.trim( $( '#login_page_content' ).val() ) != '' ) {
			$( '#login_page_content' ).val( $( '#login_page_content' ).val().replace( /'LOGIN_REBUILDER_SIGNATURE', '[0-9a-zA-Z]+'/, "'LOGIN_REBUILDER_SIGNATURE', '"+$( this ).val()+"'" ) );
		}
		if ( $( '#properties_page_subscriber' ).val() != '' && $.trim( $( '#subscriber_page_content' ).val() ) != '' ) {
			$( '#subscriber_page_content' ).val( $( '#subscriber_page_content' ).val().replace( /'LOGIN_REBUILDER_SIGNATURE', '[0-9a-zA-Z]+'/, "'LOGIN_REBUILDER_SIGNATURE', '"+$( this ).val()+"'" ) );
		}
	} );
	$( '#properties_page, #properties_page_subscriber' ).blur( function () {
		var page_elm = $( this );
		var uri = $.trim( $( this ).val() );
		var valid_uri = ( uri != '' );
<?php if ( !$this->use_site_option ) { ?>
		if ( uri != '' && uri.indexOf( '/' ) != -1 ) {
			alert( "<?php _e( "The case of the sub-site, you can not contain '/' in the path name. Please change a path name.", LOGIN_REBUILDER_DOMAIN ); ?>" );
			$( this ).next().find( 'span.path,span.writable,span.url' ).text( '' );
			$( this ).focus();
			valid_uri = false;
		}
<?php } ?>
		if ( valid_uri ) {
			$( 'input[name=submit]' ).attr( 'disabled', 'disabled' );
			$.post( '<?php echo admin_url( 'admin-ajax.php' ); ?>',
				{ action: 'login_rebuilder_try_save', mode: 0, page: uri, _ajax_nonce: '<?php echo wp_create_nonce( self::LOGIN_REBUILDER_AJAX_NONCE_NAME.$this->_nonce_suffix() ); ?>' },
				function( response ) {
					page_elm.next().each( function () {
						$( this ).find( 'span.path' ).text( response.data.path );
						if ( response.data.exists )
							$( this ).find( 'span.url' ).html( '<a href="'+response.data.url+'" target="_blank">'+response.data.url+'</a>' );
						else
							$( this ).find( 'span.url' ).text( response.data.url );
						if ( response.data.exists )
							out_exists = '<?php _e( 'File exists, ', LOGIN_REBUILDER_DOMAIN ); ?>';
						else
							out_exists = '<?php _e( 'File not found, ', LOGIN_REBUILDER_DOMAIN ); ?>';
						if ( response.data.writable ) {
							out_writing = '<?php _e( 'Writing is possible', LOGIN_REBUILDER_DOMAIN ); ?>';
							out_color = 'blue';
						} else {
							out_writing = '<?php _e( 'Writing is impossible', LOGIN_REBUILDER_DOMAIN ); ?>';
							out_color = 'orange';
						}
						$( this ).find( 'span.writable' ).text( '['+out_exists+out_writing+']' ).css( 'color', out_color );
						$( this ).find( 'textarea.content' ).text( response.data.content.replace( '%sig%', $( '#properties_keyword' ).val() ) );
					} );
				}, 'json' ).always( function() {
					$( 'input[name=submit]' ).removeAttr( 'disabled' );
				} );
		}
	} );
	$( '#properties_page' ).blur();
	$( '#properties_page_subscriber' ).blur();
	$( '#view-log' ).click( function () { $( '#log-content' ).fadeToggle(); } );
} )( jQuery );
</script>
