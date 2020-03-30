<?php
/**
* Documentation and stuff
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit; 

function pgssl_component_help() {
	// HOOKABLE: 
	do_action( "pgssl_component_help_start" ); 

	include "components.help.reference.php";
	include "components.help.sidebar.php";
?>
<div class="metabox-holder columns-2" id="post-body">
	<table width="100%"> 
		<tr valign="top">
			<td>
				<?php
					pgssl_component_help_reference();
				?> 
			</td>
			<td width="10"></td>
			<td width="400">
				<?php 
					pgssl_component_help_sidebar();
				?>
			</td>
		</tr>
	</table>
</div>
<?php
	// HOOKABLE: 
	do_action( "pgssl_component_help_end" );
}

pgssl_component_help();