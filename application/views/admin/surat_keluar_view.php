<section class="content">
	<div class="row">
		<div class="col-12">
			<?php
			$notif = $this->session->flashdata('notif');
			echo $notif
			?>
			<div>
				<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal_add">
					Tambah Surat Keluar
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
								<th>Penerima</th>
								<th>Perihal</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 0;
							foreach ($data_surat_keluar as $surat_keluar) : ?>
								<tr>
									<td><?= ++$no; ?></td>
									<td><?= $surat_keluar->nomor_surat; ?></td>
									<td><?= $surat_keluar->pengirim; ?></td>
									<td><?= $surat_keluar->tgl_kirim; ?></td>
									<td><?= $surat_keluar->penerima; ?></td>
									<td><?= $surat_keluar->perihal; ?></td>
									<td>
										<a href="<?= base_url('uploads/' . $surat_keluar->file_surat); ?> " class="btn btn-info btn-sm" target="_blank">Lihat</a>
										<a href="<?= base_url('surat/hapus_surat_keluar/' . $surat_keluar->id_surat); ?>" class="btn btn-danger btn-sm">Hapus</a></td>
								</tr>
							<?php endforeach; ?>

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
	<div class="modal-dialog">
		<div class="modal-content">

			<form action="<?php echo base_url(); ?>surat/tambah_surat_keluar" method="post" enctype="multipart/form-data">
				<div class="modal-header">
					<h4 class="modal-title" id="modal_addLabel">
						Tambah Surat Keluar
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