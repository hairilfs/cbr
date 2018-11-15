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
				'MATI_TOTAL' =>	
				[
					'LCD' => 'LC32M400',
					'LAMPU_INDIKATOR' => 'OFF',
					'TEGANGAN_POWER_SUPPLY'	=> 0,
					'BACKLIGHT'	=> 'OFF',
					'SUARA'	=> 'OFF',
					'GAMBAR' => 'OFF',
					'SOLUSI' => 'GANTI POWER SUPPLY',
				],

				'LAYAR_BLANK' => 
				[
					'LCD' => 'LC32M400',
					'LAMPU_INDIKATOR' => 'ON',
					'TEGANGAN_POWER_SUPPLY' => 12,
					'BACKLIGHT' => 'OFF',
					'SUARA' => 'ON',
					'GAMBAR' => 'ON',
					'SOLUSI' => 'GANTI LAMPU BACKLIGHT',
				],

				'LAYAR_BERGARIS' => 
				[
					'LCD' => 'LC32M400',
					'LAMPU_INDIKATOR' => 'ON',
					'TEGANGAN_POWER_SUPPLY' => 12,
					'BACKLIGHT' => 'ON',
					'SUARA' => 'ON',
					'GAMBAR' => 'GARIS',
					'SOLUSI' => 'GANTI PANEL TFT',
				],

				'LOADING_LAMA' => 
				[
					'LCD' =>  'LC32M400',
					'LAMPU_INDIKATOR' => 'ON',
					'TEGANGAN_POWER_SUPPLY' => 3,
					'BACKLIGHT' => 'ON',
					'SUARA' => 'OFF',
					'GAMBAR' => 'OFF',
					'SOLUSI' => 'GANTI PROCESSING UNIT',
				],

				'SUARA' => 
				[
					'LCD' => 'LC32M400',
					'LAMPU_INDIKATOR' => 'ON', 
					'TEGANGAN_POWER_SUPPLY' => 12,
					'BACKLIGHT' => 'ON', 
					'SUARA' => 'OFF',
					'GAMBAR' => 'ON', 
					'SOLUSI' => 'GANTI SPEAKER',
				],

				'GAMBAR_BERBAYANG' => 
				[
					'LCD' => 'LC32M400',
					'LAMPU_INDIKATOR' => 'ON',
					'TEGANGAN_POWER_SUPPLY' => 12,
					'BACKLIGHT' => 'ON',
					'SUARA' => 'ON',
					'GAMBAR' => 'BERBAYANG',
					'SOLUSI' => 'GANTI PANEL TFT',
				],
				
				'TIDAK_BISA_PINDAH_CHANEL' => 
				[
					'LCD' => 'LC32M400',
					'LAMPU_INDIKATOR' => 'BERKEDIP',
					'TEGANGAN_POWER_SUPPLY' => 12,
					'BACKLIGHT' => 'ON',
					'SUARA' => 'BESAR KECIL SENDIRI',
					'SOLUSI' => 'FLASH FIRMWARE',
				],

				'GAMBAR_BURAM' => 
				[
					'LCD' => 'LC32M400',
					'LAMPU_INDIKATOR' => 'ON', 
					'TEGANGAN_POWER_SUPPLY' => 12,
					'BACKLIGHT' => 'ON', 
					'SUARA' => 'ON', 
					'GAMBAR' => 'BURAM',
					'SOLUSI' => 'ANTENA TV',
				],
				
				'MATI_HIDUP' => 
				[
					'LCD' => 'LC32M400',
					'LAMPU_INDIKATOR' => 'BERKEDIP',
					'TEGANGAN_POWER_SUPPLY' => 12,
					'BACKLIGHT' => 	'ON OFF',
					'SUARA' => 'ON',
					'GAMBAR' => 'MATI HIDUP',
					'SOLUSI' => 'GANTI INVERTER ',
				],

				'GAMBAR_PELANGI' => 
				[
					'LCD' => 'LC32M400',
					'LAMPU_INDIKATOR' => 'ON',
					'TEGANGAN_POWER_SUPPLY' => 12,
					'BACKLIGHT' => 'ON',
					'SUARA' => 'ON',
					'GAMBAR' => 'WARNA WARNI',
					'SOLUSI' => 'BERSIHKAN KABEL LVDS',
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

		$bobot1 = array_map(function($x){
			return (int) $x;
		}, $this->input->get('weight') );

		if ($this->input->get('feature_new')) 
		{
			$value_new = $this->input->get('value_new');
			$weight_new = $this->input->get('weight_new');

			foreach ($this->input->get('feature_new') as $key => $value) 
			{
				$new_key = str_replace(' ', '_', strtolower($value));
				$case1[$new_key] = $value_new[$key];
				$bobot1[] = $weight_new[$key];

				if ( ! isset($this->data->userdata('kasus')[$value]) ) 
				{
					
				}
			}

			// var_dump($this->input->get('feature_new'));
			// exit('hey');
		}

		/*$bobot1 = array(
			'tipe' => 1,
			'tahun' => 1,
			'lampu_indikator' => 5,
			'speaker' => 5,
		);*/

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
