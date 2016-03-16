<?php
/**
Plugin Name: Mailto bookmarklet
Plugin URI: http://yourls.org/
Description: Add mailto: to the list of bookmarklets
Version: 1.0
Author: Peter Ryan Berbec
Author URI: peter@berb.ec
**/

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();

yourls_add_action( 'social_bookmarklet_buttons_after', 'prb_bookmarklet_function' );

function prb_bookmarklet_function( ) {

	$js_code = <<<EMAIL
	// Share via email
	var d   = document, 
	    w   = window,
	    enc = encodeURIComponent, 
	    sc  = d.createElement('script'), 
	    f   = '$base_bookmarklet', 
	    l   = d.location.href, 
	    ups = l.match( /^[a-zA-Z0-9\+\.-]+:(\/\/)?/ )[0], 
	    ur  = l.split(new RegExp(ups))[1], 
	    ups = ups.split(/\:/), 
	    p   = '?up=' + enc(ups[0]+':') + '&us=' + enc(ups[1]) + '&ur=' + enc(ur) + '&t=' + enc(d.title); 

	window.yourls_callback=function(r){ 
		if(r.short_url){ 
			u = 'mailto:?subject=' + enc(d.title) + '&body=' + enc(d.title) + '%0A' + enc(r.short_url); 
		} else { 
			alert('An error occured: '+r.message);
		}
	}; 
	sc.src = f + p + '&jsonp=yourls'; 
	d.body.appendChild(sc); 
	try { 
		throw('ozhismygod');
	} catch(z) { 
		a = function () { 
			if(w.open(u,'Share via email','width=1024,height=768,left=100','_blank')) l = u; 
		}; 
		if(/Firefox/.test(navigator.userAgent)) setTimeout(a, 0); 
		else a();
	} 
	void(0);
EMAIL;
	yourls_bookmarklet_link( yourls_make_bookmarklet( $js_code ), yourls__( 'YOURLS &amp; Email' ) )

}
