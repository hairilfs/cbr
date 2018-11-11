<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cbr extends CI_Controller {

	public $data;

	public function index()
	{
		$this->data = array(
			'mati_total' =>	[
				'tipe' => 'xyz1',
				'tahun' => 2011,
				'lampu_indikator' => 'off',
				'speaker' => 'off',
				'solusi' => 'Ganti mesin',
			],

			'suara_hilang' => [
				'tipe' => 'xyz2',
				'tahun' => 2012,
				'lampu_indikator' => 'on',
				'speaker' => 'off',
				'solusi' => 'Ganti speaker',
			],

			'layar_blank' => [
				'tipe' => 'abc1',
				'tahun' => 2012,
				'lampu_indikator' => 'on',
				'speaker' => 'on',
				'solusi' => 'Ganti power supply',
			],

			'layar_bergaris' => [
				'tipe' => 'abc1',
				'tahun' => 2012,
				'lampu_indikator' => 'off',
				'speaker' => 'on',
				'solusi' => 'Ganti layar',
			],

			'gambar_buruk' => [
				'tipe' => 'abc2',
				'tahun' => 2010,
				'lampu_indikator' => 'on',
				'speaker' => 'on',
				'solusi' => 'Ganti antena',
			],

		);

		$case1 = array(
			'tipe' => 'abc4',
			'tahun' => 2013,
			'lampu_indikator' => 'off',
			'speaker' => 'off',
		);

		$bobot1 = array(
			'tipe' => 1,
			'tahun' => 1,
			'lampu_indikator' => 5,
			'speaker' => 5,
		);

		$similarity = array();

		foreach ($this->data as $name => $problem) 
		{
			$temp = array(); // untuk menampung perhitungan sementara

			foreach ($problem as $key => $value) 
			{
				if ( isset($case1[$key]) ) // jika punya fitur yg sama, misalkan sama2 punya fitur 'tipe' 
				{
					similar_text(strtolower( (string) $case1[$key] ), strtolower( (string) $value ), $percent);

					$temp[] = $percent * $bobot1[$key];
				}
			}

			$similarity[$name] = array_sum($temp) / array_sum($bobot1);
		}



		echo '<pre>';
		var_dump($similarity);

		$max_reasoning = array_search(max($similarity), $similarity);
		$selected = $this->data[$max_reasoning];

		var_dump($selected);
		echo '</pre>';
		exit() ;
		$this->load->view('home');
	}
}
