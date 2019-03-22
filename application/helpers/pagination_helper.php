<?php
if ( ! function_exists('paginate'))
{
	function paginate($url,$total, $segment,$per_page,$q=array())
	{
		$thi =& get_instance();

		$thi->load->library('pagination');
		//EDIT THIS:
		$config["base_url"] = site_url( $url);
		//EDIT THIS (to get a count of number of rows. Might have to add in a criteria (category etc)
		$config["total_rows"] = $total;
		//EDIT THIS
		$config["uri_segment"] = $segment;
		//EDIT THIS:
		$config["per_page"] = $per_page;
		$config["num_links"] = 2;
		$config['use_page_numbers'] = true; // use page numbers, or use the current row number (limit offset)
		$page = ($thi->uri->segment($config["uri_segment"] )) ? $thi->uri->segment($config["uri_segment"] ) : 0;
		//EDIT THIS:
		$config['reuse_query_string'] = TRUE;

		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul><!--pagination-->';
		$config['first_link'] = 'Pertama';
		$config['first_tag_open'] = '<li class="prev page">';
		$config['first_tag_close'] = '</li>' . "\n";
		$config['last_link'] = 'Terakhir';
		$config['last_tag_open'] = '<li class="next page">';
		$config['last_tag_close'] = '</li>' . "\n";
		$config['next_link'] = ' &raquo';
		$config['next_tag_open'] = '<li class="next page">';
		$config['next_tag_close'] = '</li>' . "\n";
		$config['prev_link'] = '&laquo;';
		$config['prev_tag_open'] = '<li class="prev page">';
		$config['prev_tag_close'] = '</li>' . "\n";
		$config['cur_tag_open'] = '<li class="active"><a href="">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page">';
		$config['num_tag_close'] = '</li>' . "\n";
		$thi->pagination->initialize($config);
		return $thi->pagination->create_links();

	}
}
?>