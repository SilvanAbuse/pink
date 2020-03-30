<?php
/**
* Documentation and stuff
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit; 

function pgssl_component_help_reference() {
	// HOOKABLE: 
	do_action( "pgssl_component_help_reference_start" );
?>
<div class="stuffbox" style="padding:20px">
	<h3 style="padding-left:0px"><?php _pgssl_e("Documentation", 'pgssl-text-domain') ?></h3>
	<p>
		<?php _pgssl_e('The complete <b>User Guide</b> can be found at
		<a href="http://miled.github.io/wordpress-social-login/index.html" target="_blank">miled.github.io/wordpress-social-login/index.html</a>', 'pgssl-text-domain') ?>
	</p>

	<hr />
	
	<h3 style="padding-left:0px"><?php _pgssl_e("FAQs", 'pgssl-text-domain') ?></h3>
	<p>
		<?php _pgssl_e('A list of <b>Frequently asked questions</b> can be found at
		<a href="http://miled.github.io/wordpress-social-login/faq.html" target="_blank">miled.github.io/wordpress-social-login/faq.html</a>', 'pgssl-text-domain') ?>
	</p>

	<hr />
	
	<h3 style="padding-left:0px"><?php _pgssl_e("Support", 'pgssl-text-domain') ?></h3>
	<p>
		<?php _pgssl_e('To get help and support, here is how you can reach me <a href="http://miled.github.io/wordpress-social-login/support.html" target="_blank">miled.github.io/wordpress-social-login/support.html</a>', 'pgssl-text-domain') ?>
	</p>
 
	<hr />
	
	<h3 style="padding-left:0px"><?php _pgssl_e("Authors", 'pgssl-text-domain') ?></h3>
	<p>
		<?php _pgssl_e('PGS Social Login was created by <a href="http://profiles.wordpress.org/miled/" target="_blank">Mohamed Mrassi</a> (a.k.a Miled) and <a href="https://miled.github.io/wordpress-social-login/graphs/contributors" target="_blank">contributors</a>', 'pgssl-text-domain') ?>.
	</p>
 
	<hr />
	
	<h3 style="padding-left:0px"><?php _pgssl_e("License", 'pgssl-text-domain') ?></h3>
	<p>
		<?php _pgssl_e("Except where otherwise noted, <b>PGS Social Login</b> is distributed under the terms of the MIT license reproduced here", 'pgssl-text-domain') ?>.
	</p>

	<p>
		<?php _pgssl_e("In case you're not familiar with The MIT License, it can be summed in three basic things", 'pgssl-text-domain') ?>:
	</p>

	<ul style="margin-left:45px;line-height: 20px;">
		<li><?php _pgssl_e("The MIT License (MIT) is compatible with The GNU Public License (GPL) but it is more liberal", 'pgssl-text-domain') ?>.</li>
		<li><?php _pgssl_e("Do no hold the plugin authors liable. This software is provided AS IS, WITHOUT WARRANTY OF ANY KIND", 'pgssl-text-domain') ?>.</li>
		<li><?php _pgssl_e("You are allowed to use this plugin for whatever purpose, including in commercial projects, as long as the copyright header inside the code is left intact", 'pgssl-text-domain') ?>.</li>
	</ul>

<div class="fade updated" style="line-height: 22px;padding: 22px;font-family: monospace;">
    The MIT License (MIT)
    <br />
    <br />Copyright (C) 2011-2014 Mohamed Mrassi and contributors.
    <br />
    <br />Permission is hereby granted, free of charge, to any person obtaining
    <br />a copy of this software and associated documentation files (the
    <br />"Software"), to deal in the Software without restriction, including
    <br />without limitation the rights to use, copy, modify, merge, publish,
    <br />distribute, sublicense, and/or sell copies of the Software, and to
    <br />permit persons to whom the Software is furnished to do so, subject to
    <br />the following conditions:
    <br />
    <br />The above copyright notice and this permission notice shall be
    <br />included in all copies or substantial portions of the Software.
    <br />
    <br />THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
    <br />EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
    <br />MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
    <br />NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
    <br />LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
    <br />OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
    <br />WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
</div>
</div>
<?php
	// HOOKABLE: 
	do_action( "pgssl_component_help_reference_end" );
}