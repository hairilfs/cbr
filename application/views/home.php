<?php include_once 'partials/header.php'; ?>

<div class="container">
	<h1>Case-Based Reasoning: kerusakan TV SHARP</h1>
	<br>
	<p>Insert new problem (symptom)</p>
	<a href="cbr" class="pull-right">Reset</a>
	<div class="row">
		<div class="col-6">
			<form action="cbr/process" method="GET">
				<table class="table table-bordered" id="tbl_symptom">
					<tr>
						<th>Fitur</th>
						<th>Nilai</th>
						<th>Bobot</th>
					</tr>
					<tr>
						<td>Tipe</td>
						<td><input type="text" name="tipe"></td>
						<td><input type="text" name="weight[]" class=""></td>
					</tr>
					<tr>
						<td>Tahun</td>
						<td><input type="text" name="tahun"></td>
						<td><input type="text" name="weight[]" class=""></td>
					</tr>
					<tr>
						<td>Lampu Indikator</td>
						<td><input type="text" name="lampu_indikator"></td>
						<td><input type="text" name="weight[]" class=""></td>
					</tr>
					<tr>
						<td>Speaker</td>
						<td><input type="text" name="speaker"></td>
						<td><input type="text" name="weight[]" class=""></td>
					</tr>
					<tr>
						<td>Layar</td>
						<td><input type="text" name="layar"></td>
						<td><input type="text" name="weight[]" class=""></td>
					</tr>
				</table>
				<button type="button" class="btn btn-secondary" onclick="return add_feature();">Tambah fitur</button>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
		<?php if ($selected): ?>
			
		<div class="col-6">
			<table class="table table-bordered" id="">
				<?php foreach ($selected as $key => $value): ?>
					
				<tr>
					<td><?php echo $key; ?></td>
					<td><?php echo $value; ?></td>
				</tr>
				<?php endforeach ?>
			</table>
		</div>

		<?php endif ?>

	</div>
	
</div>

<?php include_once 'partials/footer.php'; ?>