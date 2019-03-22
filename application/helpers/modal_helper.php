<?php
if ( ! function_exists( 'ajax_modal' ) ) {
	function ajax_modal( $uri, $text = 'Edit', $css = array( 'warning', 'pencil' ) ) {
		return "<a target='ajax-modal' href='" . base_url() . $uri . "' class='btn btn-" . $css[0] . " btn-xs'><span class='fa fa-" . $css[1] . " '></span> " . $text . "</a>";
	}
}

if ( ! function_exists( 'modal_delete' ) ) {
	function modal_delete( $uri, $judul ) {
		$ci   =& get_instance();
		$data = array(
			'uri'   => $uri,
			'judul' => $judul
		);

		$ci->load->view( 'modals/delete', $data );
	}
}

if ( ! function_exists( 'ajax_text_modal' ) ) {
	function ajax_text_modal( $uri, $text = '', $css = array( ) ,$attr=null) {
        if($attr == null) {$attr = "target='ajax-modal'";}
		return "<a ". $attr ." href='" . base_url() . $uri . "' >" . $text . "</a>";
	}
}