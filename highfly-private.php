<?php
/*
Plugin Name: Highfly Private
Description: Gets Highfly to notify of not only public but also private published content.
Author: edik
Author URI: http://edik.ch/
Version: 2.1
License: GPLv3

Copyright 2014  Edgard Schmidt  (email : edik(ATT)edik.ch)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/

namespace highfly_private;

class Main {

function __construct() {
	$pre = 'highfly_';
	add_filter( $pre . 'public_statuses', array( $this, 'add_private' ) );
	add_filter( $pre . 'transition_name', array( $this, 'get_label' ), 10, 2 );
}

function add_private( $statuses ) {
	return $this->add_status( $statuses, 'private' );
}

function add_status( $statuses, $new ) {
	if ( !in_array( $new, $statuses, TRUE ) ) {
		$statuses[] = $new;
	}
	return $statuses;
}

function get_label( $name, $data ) {
	global $highfly;
	$modules = $highfly->modules();
	$notifier = $modules['post'];
	extract( $data );
	if ( $notifier->was_published( $old_status, $new_status )
			&& 'private' === $new_status ) {
		return __( 'Privately Published' );
	}
	return $name;
}

}

$highfly_private = new Main();
