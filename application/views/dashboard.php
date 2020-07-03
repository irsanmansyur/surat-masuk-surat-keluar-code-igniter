   <!-- Main content -->
   <section class="content">
   	<div class="row">

   		<!-- ./col -->
   		<div class="col-lg-3 col-6">
   			<!-- small box -->
   			<div class="small-box bg-warning">
   				<div class="inner">
   					<h3><?php echo $data_dashboard['surat_keluar']; ?></h3>

   					<p>Surat Keluar</p>
   				</div>
   				<div class="icon">
   					<i class="fa fa-inbox"></i>
   				</div>
   				<a href="<?= base_url("surat/keluar"); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
   			</div>
   		</div>
   		<!-- ./col -->
   		<div class="col-lg-3 col-6">
   			<!-- small box -->
   			<div class="small-box bg-danger">
   				<div class="inner">
   					<h3><?= $data_dashboard['surat_masuk'];; ?></h3>

   					<p>Surat Masuk</p>
   				</div>
   				<div class="icon">
   					<i class="fa fa-envelope"></i>
   				</div>
   				<a href="<?= base_url("surat/masuk"); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
   			</div>
   		</div>
   		<!-- ./col -->
   	</div>

   </section>
   <!-- /.content -->