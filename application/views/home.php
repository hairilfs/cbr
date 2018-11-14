<?php include_once 'partials/header.php'; ?>

<div class="container">
	<h1>Case-Based Reasoning: kerusakan TV SHARP</h1>
	<br>

	<div class="accordion" id="accordionCBR">
	  <div class="card">
	    <div class="card-header" id="headingOne">
	      <h5 class="mb-0">
	        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
	          Kasus-kasus sebelumnya
	        </button>
	      </h5>
	    </div>

	    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionCBR">
	      <div class="card-body" style="max-height: 800px; overflow: auto;">
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
	      				<td><?php echo $value['solusi']; ?></td>
	      			</tr>

	      			<?php $counter++; ?>
	      			<?php endforeach ?>
	      		</tbody>
	      	</table>
	      </div>
	    </div>
	  </div>
	  <div class="card">
	    <div class="card-header" id="headingTwo">
	      <h5 class="mb-0">
	        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
	          Kasus baru
	        </button>
	      </h5>
	    </div>
	    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionCBR">
	      <div class="card-body">
			<form action="<?php echo base_url('/cbr/process'); ?>" method="GET">
		        <table class="table table-bordered" id="tbl_symptom">
		          <tr>
		            <th>Fitur</th>
		            <th>Nilai</th>
		            <th>Bobot</th>
		          </tr>
		          <tr>
		            <td>Tipe</td>
		            <td><input type="text" name="tipe" value="<?php echo $_GET['tipe'] ?? ''; ?>"></td>
		            <td><input type="text" name="weight[]" value="1" required></td>
		          </tr>
		          <tr>
		            <td>Tahun</td>
		            <td><input type="text" name="tahun" value="<?php echo $_GET['tahun'] ?? ''; ?>"></td>
		            <td><input type="text" name="weight[]" value="1" required></td>
		          </tr>
		          <tr>
		            <td>Lampu Indikator</td>
		            <td><input type="text" name="lampu_indikator" value="<?php echo $_GET['lampu_indikator'] ?? ''; ?>"></td>
		            <td><input type="text" name="weight[]" value="10" required></td>
		          </tr>
		          <tr>
		            <td>Speaker</td>
		            <td><input type="text" name="speaker" value="<?php echo $_GET['speaker'] ?? ''; ?>"></td>
		            <td><input type="text" name="weight[]" value="10" required></td>
		          </tr>
		          <tr>
		            <td>Layar</td>
		            <td><input type="text" name="layar" value="<?php echo $_GET['layar'] ?? ''; ?>"></td>
		            <td><input type="text" name="weight[]" value="10" required></td>
		          </tr>
		        </table>
		        <button type="button" class="btn btn-secondary" onclick="return add_feature();">Tambah fitur</button>
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

			      <p><strong>Euclidean Distance (Alpha)</strong></p>
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

			    <?php endif ?>
	      </div>
	    </div>
	  </div>
	</div>
	
</div>

<?php include_once 'partials/footer.php'; ?>