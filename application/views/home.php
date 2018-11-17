<?php include_once 'partials/header.php'; ?>

<div class="container">
	<h1>Case-Based Reasoning: kerusakan TV SHARP</h1>
	<br>

	<!-- <p><a href="<?php echo base_url('/cbr/destroySession'); ?>">Reset all datas</a></p> -->

	<div class="accordion" id="accordionCBR">
	  <div class="card">
	    <div class="card-header" id="headingOne">
	      <h5 class="mb-0">
	        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
	          Kasus-kasus sebelumnya <span class="badge badge-secondary">Data</span>
	        </button>
	      </h5>
	    </div>

	    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionCBR">
	      <div class="card-body" style="max-height: 600px; overflow: auto;">
	      	<table class="table table-bordered table-condensed">
	      		<thead>
	      			<tr>
	      				<th>No</th>
	      				<th>Kasus</th>
	      				<th>Fitur</th>
	      				<th>Solusi</th>
	      			</tr>
	      		</thead>
	      		<tbody>
	      			<?php $counter = 1; ?>
	      			<?php foreach ($this->session->userdata('kasus') as $key => $value): ?>
	      			
	      			<tr>
	      				<td><?php echo $counter; ?></td>
	      				<td><?php echo $key; ?></td>
	      				<td>
	      					<?php 
	      					$max = count($value); $s = 1;
	      					foreach ($value as $z => $fitur) {
	      						if ($max == $s) {
	      							break;
	      						}

	      						echo "$z: $fitur <br/>"; 
	      						$s++;
	      					}
	      					?>	
	      				</td>
	      				<td><?php echo $value['SOLUSI']; ?></td>
	      			</tr>

	      			<?php $counter++; ?>
	      			<?php endforeach ?>
	      		</tbody>
	      	</table>
	      </div>
	    </div>
	  </div>
	  <div class="card" style="margin-bottom: 100px;">
	    <div class="card-header" id="headingTwo">
	      <h5 class="mb-0">
	        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
	          Kasus baru <span class="badge badge-primary">Here!</span>
	        </button>
	      </h5>
	    </div>
	    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionCBR">
	      <div class="card-body">
				<form action="<?php echo base_url('/cbr/process'); ?>" method="GET">
					<div class="table-responsive">
						<table class="table table-bordered" id="tbl_symptom">
		          <tr>
		            <th>Fitur</th>
		            <th>Nilai</th>
	            <th>Bobot</th>
		          </tr>
		          <tr>
		            <td>LCD</td>
		            <td><input type="text" name="LCD" value="<?php echo $_GET['LCD'] ?? ''; ?>"></td>
		            <td><input type="text" name="weight[]" value="1" required></td>
		          </tr>
		          <tr>
		            <td>LAMPU_INDIKATOR</td>
		            <td><input type="text" name="LAMPU_INDIKATOR" value="<?php echo $_GET['LAMPU_INDIKATOR'] ?? ''; ?>"></td>
		            <td><input type="text" name="weight[]" value="1" required></td>
		          </tr>
		          <tr>
		            <td>TEGANGAN_POWER_SUPPLY</td>
		            <td><input type="text" name="TEGANGAN_POWER_SUPPLY" value="<?php echo $_GET['TEGANGAN_POWER_SUPPLY'] ?? ''; ?>"></td>
		            <td><input type="text" name="weight[]" value="10" required></td>
		          </tr>
		          <tr>
		            <td>BACKLIGHT</td>
		            <td><input type="text" name="BACKLIGHT" value="<?php echo $_GET['BACKLIGHT'] ?? ''; ?>"></td>
		            <td><input type="text" name="weight[]" value="10" required></td>
		          </tr>
		          <tr>
		            <td>SUARA</td>
		            <td><input type="text" name="SUARA" value="<?php echo $_GET['SUARA'] ?? ''; ?>"></td>
		            <td><input type="text" name="weight[]" value="10" required></td>
		          </tr>
		          <tr>
		            <td>GAMBAR</td>
		            <td><input type="text" name="GAMBAR" value="<?php echo $_GET['GAMBAR'] ?? ''; ?>"></td>
		            <td><input type="text" name="weight[]" value="10" required></td>
		          </tr>
		        </table>
					</div>
	        <!-- <button type="button" class="btn btn-secondary" onclick="return add_feature();">Tambah fitur</button> -->
	        <button type="submit" class="btn btn-primary">Submit</button>
		    </form>

		    <?php if (isset($selected)): ?>
      
			      <p>
			        <strong>Most similiar case </strong>
			      </p>
			      <table class="table table-bordered" id="">
			        <?php foreach ($selected as $key => $value): ?>
			        <tr class="table-success">
			          <td><?php echo $key; ?></td>
			          <td><?php echo $value; ?></td>
			        </tr>
			        <?php endforeach ?>

			        <tr class="table-success">
			          <td>Similarity</td>
			          <td><?php echo $similarity; ?></td>
			        </tr>
			      </table>

			      <p><strong>Euclidean Distance</strong></p>
			      <div class="table-responsive">
				      <table class="table table-bordered table-condensed">
				        <thead>
				          <tr>
				            <th>#</th>
				            <?php foreach ($header as $value): ?>
				              <th title="<?php echo $value['label'] ?>" data-toggle="tooltip"><?php echo $value['value']; ?></th>
				            <?php endforeach ?>
				          </tr>
				        </thead>
				        <tbody>
				        <?php foreach ($compare as $key => $value): ?>
				          <tr>
				            <th title="<?php echo $header[$key]['label']; ?>" data-toggle="tooltip" data-placement="left"><?php echo $header[$key]['value']; ?></th>
				            <?php foreach ($value as $el): ?>
				              <td><?php echo $el; ?></td>
				            <?php endforeach ?>
				          </tr>         
				        <?php endforeach ?>
				        </tbody>
				      </table>
			      </div>

			      <p><strong>Cosine Distance</strong></p>
			      <div class="table-responsive">
				      <table class="table table-bordered table-condensed">
				        <thead>
				          <tr>
				            <th>#</th>
				            <?php foreach ($header_cosine as $value): ?>
				            	<?php //var_dump($value['value']); exit; ?>
				              <th title="<?php echo $value['label'] ?>" data-toggle="tooltip"><?php echo round($value['value'], 4); ?></th>
				            <?php endforeach ?>
				          </tr>
				        </thead>
				        <tbody>
				        <?php foreach ($compare_cosine as $key => $value): ?>
				          <tr>
				            <th title="<?php echo $header_cosine[$key]['label']; ?>" data-toggle="tooltip" data-placement="left"><?php echo round($header_cosine[$key]['value'], 4); ?></th>
				            <?php foreach ($value as $el): ?>
				              <td><?php echo round($el, 4); ?></td>
				            <?php endforeach ?>
				          </tr>         
				        <?php endforeach ?>
				        </tbody>
				      </table>
			      </div>
						
			    <?php endif ?>
	      </div>
	    </div>
	  </div>
	</div>
	
</div>

<?php include_once 'partials/footer.php'; ?>