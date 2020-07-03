<section class="content">
	<div class="row">
		<div class="col-12">
			<?php
			$notif = $this->session->flashdata('notif');
			echo $notif
			?>
			<div>
				<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal_add">
					Tambah Surat Masuk
				</button>
			</div>
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">DataTable Surat</h3>
				</div>
				<!-- /.card-header -->
				<div class="card-body">
					<table id="example1" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Nomor Surat</th>
								<th>Pengirim</th>
								<th>Tanggal Kirim</th>
								<th>Tanggal Terima</th>
								<th>Perihal</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 0;
							foreach ($data_surat_masuk as $surat_masuk) {
								echo '
						  		<tr>
						  				<td>' . ++$no . '</td>
						  				<td>' . $surat_masuk->nomor_surat . '</td>
						  				<td>' . $surat_masuk->pengirim . '</td>
						  				<td>' . $surat_masuk->tgl_kirim . '</td>
						  				<td>' . $surat_masuk->tgl_terima . '</td>
						  				<td>' . $surat_masuk->perihal . '</td>
						  				<td>
						  					<a href="' . base_url('uploads/' . $surat_masuk->file_surat) . '" class="btn btn-info btn-sm" target="_blank">Lihat</a>
						  					
						  					<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_ubah" onclick="prepare_update_surat(' . $surat_masuk->id_surat . ')">Ubah</a>
						  					<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_ubah_surat" onclick="prepare_update_surat(' . $surat_masuk->id_surat . ')">Ganti File</a>
						  					
						  					<a href="' . base_url('index.php/surat/hapus_surat_masuk/' . $surat_masuk->id_surat) . '" class="btn btn-danger btn-sm" >Hapus</a>

						  				</td>
						  			</tr>
						  		';
							}
							?>
						</tbody>
					</table>
				</div>
				<!-- /.card-body -->
			</div>
		</div>
	</div>
</section>


<!-- tambah surat -->
<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="modal_addLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<form action="<?php echo base_url(); ?>surat/tambah_surat_masuk" method="post" enctype="multipart/form-data">
				<div class="modal-header">
					<h4 class="modal-title" id="modal_addLabel">
						Tambah Surat Masuk
					</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Nomor Surat</label>
						<input type="text" name="no_surat" class="form-control">
					</div>
					<div class="form-group">
						<label>Tanggal Kirim</label>
						<input type="date" name="tgl_kirim" class="form-control">
					</div>
					<div class="form-group">
						<label>Tanggal Terima</label>
						<input type="date" name="tgl_terima" class="form-control">
					</div>
					<div class="form-group">
						<label>Pengirim</label>
						<input type="text" name="pengirim" class="form-control">
					</div>
					<div class="form-group">
						<label>Penerima</label>
						<input type="text" name="penerima" class="form-control">
					</div>
					<div class="form-group">
						<label>Perihal</label>
						<input type="text" name="perihal" class="form-control">
					</div>
					<div class="form-group">
						<label>Unggah Surat (*pdf)</label>
						<input type="file" name="file_surat" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
					<input type="submit" name="submit" class="btn btn-primary" value="Submit">
				</div>
			</form>
		</div>
	</div>
</div>

<!-- edit surat -->
<div class="modal fade" id="modal_ubah" tabindex="-1" role="dialog" aria-labelledby="modal_ubahLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">

			<form action="<?php echo base_url(); ?>surat/ubah_surat_masuk" method="post">
				<div class="modal-header">
					<h4 class="modal-title" id="modal_ubahLabel">
						Ubah Surat Masuk
					</h4>
				</div>
				<div class="modal-body">

					<input type="hidden" name="edit_id_surat" id="edit_id_surat">

					<div class="form-group">
						<label>Nomor Surat</label>
						<input type="text" name="edit_no_surat" id="edit_no_surat" class="form-control">
					</div>
					<div class="form-group">
						<label>Tanggal Kirim</label>
						<input type="date" name="edit_tgl_kirim" id="edit_tgl_kirim" class="form-control">
					</div>
					<div class="form-group">
						<label>Tanggal Terima</label>
						<input type="date" name="edit_tgl_terima" id="edit_tgl_terima" class="form-control">
					</div>
					<div class="form-group">
						<label>Pengirim</label>
						<input type="text" name="edit_pengirim" id="edit_pengirim" class="form-control">
					</div>
					<div class="form-group">
						<label>Penerima</label>
						<input type="text" name="edit_penerima" id="edit_penerima" class="form-control">
					</div>
					<div class="form-group">
						<label>Perihal</label>
						<input type="text" name="edit_perihal" id="edit_perihal" class="form-control">
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
					<input type="submit" name="submit" class="btn btn-primary" value="Submit">
				</div>
			</form>
		</div>
	</div>
</div>

<!-- edit file -->
<div class="modal fade" id="modal_ubah_surat" tabindex="-1" role="dialog" aria-labelledby="modal_ubah_suratLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">

			<form action="<?php echo base_url(); ?>index.php/surat/ubah_file_surat_masuk" method="post" enctype="multipart/form-data">
				<div class="modal-header">
					<h4 class="modal-title" id="modal_ubah_suratLabel">
						Ubah File Surat Masuk
					</h4>
				</div>
				<div class="modal-body">

					<input type="hidden" name="edit_file_surat" id="edit_file_surat">


					<div class="form-group">
						<label>Unggah Surat (*pdf)</label>
						<input type="file" name="edit_file_surat" id="edit_file_surat" class="form-control">
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
					<input type="submit" name="submit" class="btn btn-primary" value="Submit">
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	function prepare_update_surat(id_surat) {
		$('#edit_file_surat').empty();
		$('#edit_id_surat').empty();
		$('#edit_no_surat').empty();
		$('#edit_tgl_terima').empty();
		$('#edit_tgl_kirim').empty();
		$('#edit_penerima').empty();
		$('#edit_pengirim').empty();
		$('#edit_perihal').empty();

		$.getJSON('<?php echo base_url(); ?>index.php/surat/get_surat_masuk_by_id/' + id_surat, function(data) {
			$('#edit_file_surat').val(data.id_surat);
			$('#edit_id_surat').val(data.id_surat);
			$('#edit_no_surat').val(data.nomor_surat);
			$('#edit_tgl_terima').val(data.tgl_terima);
			$('#edit_tgl_kirim').val(data.tgl_kirim);
			$('#edit_penerima').val(data.penerima);
			$('#edit_pengirim').val(data.pengirim);
			$('#edit_perihal').val(data.perihal);
		});
	}
</script>