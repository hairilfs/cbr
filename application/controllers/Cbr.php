<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Phpml\Math\Distance\Euclidean;
use Algenza\Cosinesimilarity\Cosine;

class Cbr extends CI_Controller {

	public $data;

	public function __construct($value='')
	{
		parent::__construct();
	}

	public function kasus()
	{
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
				
				'TIDAK_BISA_PINDAH_CHANNEL' => 
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
		$this->kasus();
		$this->load->view('home', $this->data);
	}

	public function process()
	{
		$this->kasus();
		$case1 = array(
			'LCD' => $this->input->get('LCD'),
			'LAMPU_INDIKATOR' => $this->input->get('LAMPU_INDIKATOR'),
			'TEGANGAN_POWER_SUPPLY' => $this->input->get('TEGANGAN_POWER_SUPPLY'),
			'BACKLIGHT' => $this->input->get('BACKLIGHT'),
			'SUARA' => $this->input->get('SUARA'),
			'GAMBAR' => $this->input->get('GAMBAR'),
		);

		$bobot1 = array_map(function($x){
			return (int) $x;
		}, $this->input->get('weight') );

		if ($this->input->get('feature_new')) 
		{
			exit('sds');
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
					$x = array();
					$x[] = alphabetValue($case1[$key]);
					$x[] = alphabetValue($value);

					// $euclidean = new Euclidean();
					// $x = $euclidean->distance([$case_text], [$case_kasus]);

					$z = min($x) / max($x);
					// var_dump(min($x));
					// exit();
					$temp[] = round($z , 2) * $bobot1[$counter];
					$counter++;
				}
			}

			$similarity[$name] = array_sum($temp) / array_sum($bobot1);
			$similarity[$name] = round($similarity[$name],2);
		}

		$table_compare = array();
		$table_header = array();
		$c = 0;
		foreach ($similarity as $name => $eu) 
		{
			$table_header[] = ['label' => $name, 'value' => $eu]; 
			foreach ($similarity as $cek) 
			{
				$euclidean = new Euclidean();
				$table_compare[$c][] = $euclidean->distance([$eu], [$cek]);
				// $nilai = abs($eu - $cek);
				// $table_compare[$c][] = $nilai;
			}	

			$c++;
		}	
 	
		$max_reasoning = array_search(max($similarity), $similarity);
		$this->data['selected'] = $this->session->userdata('kasus')[$max_reasoning];
		$this->data['similarity'] = max($similarity);
		$this->data['compare'] = $table_compare;
		$this->data['header'] = $table_header;

		// var_dump($table_header); exit();
		
		// Cosine Similarity
		$dx = $this->session->userdata('kasus');
		$dx = array_map(function($x){
			array_pop($x);
			return $x;
		}, $dx);

		$dx['KASUS_BARU'] = $case1; 

		$table_compare_cosine = array();
		$table_header_cosine = array();
		$c = 0;
		foreach ($dx as $name => $cos) 
		{
			foreach ($dx as $cek) 
			{	
				// var_dump($cos, $cek);
				// exit();
				$x = array();
				$x[0] = array_map(function($x){
					return alphabetValue($x);
				}, $cos);

				$x[1] = array_map(function($x){
					return alphabetValue($x);
				}, $cek);

				// $cosine = Cosine::similarity($vectorA, $vectorB);
				$table_compare_cosine[$c][] = Cosine::similarity($x[0], $x[1]);
			}

			$table_header_cosine[] = ['label' => $name, 'value' => array_sum($table_compare_cosine[$c]) / count($table_compare_cosine[$c])]; 

			$c++;
		}

		$this->data['compare_cosine'] = $table_compare_cosine;
		$this->data['header_cosine'] = $table_header_cosine;

		// var_dump($table_header_cosine[8]); exit();


		// array_push($case1, $dx);
		// echo '<pre>';
		// print_r($dx);
		// print_r($case1);
		// echo '</pre>';
		// exit();

		$this->load->view('home', $this->data);


	}

	public function destroySession()
	{
		$this->session->sess_destroy();
		redirect('/');
	}
}
