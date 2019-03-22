<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Class Welcome
 * @property Pdf $pdf
 */
class Welcome extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		redirect( 'dashboard' );
	}

	public function create_and_load_pdf() {
		$this->load->library( 'pdf' );
		$this->pdf->folder( APPPATH . '/../storage/pdf/' );
		$this->pdf->filename( 'test.pdf' );
		$this->pdf->paper( 'a4', 'portrait' );

		$data['message'] = 'Hello mas jati';
		$this->pdf->html( $this->load->view( 'welcome_message', $data, true ) );

		$this->pdf->create( 'save' );
		$this->pdf->create();
		echo "sukses";
	}

	public function load_pdf() {
		$this->load->library( 'pdf' );
		$this->pdf->folder( APPPATH . '/../storage/pdf/' );
		$this->pdf->filename( 'test.pdf' );
		$this->pdf->paper( 'a4', 'portrait' );

		$data['message'] = 'Hello mas jati';
		$this->pdf->html( $this->load->view( 'welcome_message', $data, true ) );

		$this->pdf->create();
	}

	public function test() {

		$path        = APPPATH . '../storage/excel/';
		$filename    = date( 'Y_m_d' ) . '.xlsx';

		$spreadsheet = new Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();
		$sheet->setCellValue( 'A1', 'Hello World !' );

		$writer = new Xlsx( $spreadsheet );
		$writer->save( $path . $filename );

	}

	function test3(){
	    $this->load->library('encryption');

        $key = $this->encryption->create_key(16);

        echo $key;
    }

}
