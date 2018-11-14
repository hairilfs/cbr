<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cbr extends CI_Controller {

	public $data;

	public function __construct($value='')
	{
		parent::__construct();

		if ( ! isset($_SESSION['kasus']) ) 
		{
			$kasus = array(
				'mati_total' =>	[
					'tipe' => 'xyz1',
					'tahun' => 2011,
					'lampu_indikator' => 'off',
					'speaker' => 'off',
					'layar' => 'off',
					'solusi' => 'Ganti mesin',
				],

				'suara_hilang' => [
					'tipe' => 'xyz2',
					'tahun' => 2012,
					'lampu_indikator' => 'on',
					'speaker' => 'off',
					'layar' => 'on',
					'solusi' => 'Ganti speaker',
				],

				'layar_blank' => [
					'tipe' => 'abc1',
					'tahun' => 2012,
					'lampu_indikator' => 'on',
					'speaker' => 'on',
					'layar' => 'off',
					'solusi' => 'Ganti power supply',
				],

				'layar_bergaris' => [
					'tipe' => 'abc1',
					'tahun' => 2012,
					'lampu_indikator' => 'off',
					'speaker' => 'on',
					'layar' => 'on',
					'solusi' => 'Ganti layar',
				],

				'gambar_buruk' => [
					'tipe' => 'abc2',
					'tahun' => 2010,
					'lampu_indikator' => 'on',
					'speaker' => 'on',
					'layar' => 'on',
					'solusi' => 'Ganti antena',
				],
			);

			$this->session->set_userdata('kasus', $kasus);
		}
	}

	public function index()
	{
		$this->load->view('home', $this->data);
	}

	public function process()
	{
		$case1 = array(
			'tipe' => $this->input->get('tipe'),
			'tahun' => $this->input->get('tahun'),
			'lampu_indikator' => $this->input->get('lampu_indikator'),
			'speaker' => $this->input->get('speaker'),
			'layar' => $this->input->get('layar'),
		);

		/*$bobot1 = array(
			'tipe' => 1,
			'tahun' => 1,
			'lampu_indikator' => 5,
			'speaker' => 5,
		);*/

		$bobot1 = array_map(function($x){
			return (int) $x;
		}, $this->input->get('weight') );

		$similarity = array();

		foreach ($this->session->userdata('kasus') as $name => $problem) 
		{
			$temp = array(); // untuk menampung perhitungan sementara
			$counter = 0;

			foreach ($problem as $key => $value) 
			{
				if ( isset($case1[$key]) ) // jika punya fitur yg sama, misalkan sama2 punya fitur 'tipe' 
				{
					similar_text(strtolower( (string) $case1[$key] ), strtolower( (string) $value ), $percent);

					$temp[] = $percent * $bobot1[$counter];
					$counter++;
				}
			}

			$similarity[$name] = array_sum($temp) / array_sum($bobot1);
		}

		$table_compare = array();
		$table_header = array();
		$c = 0;
		foreach ($similarity as $name => $eu) 
		{
			$table_header[] = ['label' => $name, 'value' => $eu]; 
			foreach ($similarity as $cek) 
			{
				$nilai = abs($eu - $cek);
				$table_compare[$c][] = $nilai; 
			}	

			$c++;
		}	
 	
		$max_reasoning = array_search(max($similarity), $similarity);
		$this->data['selected'] = $this->session->userdata('kasus')[$max_reasoning];
		$this->data['similarity'] = max($similarity);
		$this->data['compare'] = $table_compare;
		$this->data['header'] = $table_header;
		$this->load->view('home', $this->data);
	}
}
