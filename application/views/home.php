<?php include_once 'partials/header.php'; ?>

<div class="container">
	<h1>Case-Based Reasoning: kerusakan TV SHARP</h1>
	<br>
	<div class="row">
		<div class="col-6">
			<p>
				<strong>Insert new problem (symptom)</strong>
				<a href="<?php echo base_url('/') ?>" class="pull-right">Reset</a>
			</p>
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
		</div>

		<?php if (isset($selected)): ?>
			
		<div class="col-6">
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
		</div>

		<?php endif ?>

	</div>
	
</div>

<?php include_once 'partials/footer.php'; ?>