<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Surat extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('surat_model');
		//Do your magic here
	}

	public function index()
	{
		if ($this->session->userdata('logged_in') ==  TRUE) {
			$data['title'] = "Dashboard";
			$data['page_title'] = "Selamat Datang di Sistem Surat";
			if ($this->session->userdata('jabatan') == 'Sekretaris') {
				$data['main_view'] = 'dashboard';
				$data['data_dashboard'] = $this->surat_model->get_data_dashboard();

				$this->load->view('template', $data);
			} else {
				$data['main_view'] = 'pegawai/disposisi_masuk';
				$data['data_disposisi'] = $this->surat_model->get_all_disposisi_masuk($this->session->userdata('id_pegawai'));

				$this->load->view('template', $data);
			}
		} else {
			redirect('login', 'refresh');
		}
	}

	public function masuk()
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			$data['page_title'] = "Daftar Surat Masuk";
			$data['title'] = "Surat masuk";
			if ($this->session->userdata('jabatan') == 'Sekretaris') {
				$data['main_view'] = 'admin/surat_masuk_view';
				$data['main_js'] = 'datatable';
				$data['main_css'] = 'datatable';
				$data['data_surat_masuk'] = $this->surat_model->get_surat_masuk();

				$this->load->view('template', $data);
			} else {
			}
		} else {
			redirect('login', 'refresh');
		}
	}


	public function tambah_surat_masuk()
	{
		if ($this->session->userdata('logged_in') == TRUE) {

			if ($this->session->userdata('jabatan') == 'Sekretaris') {

				$this->form_validation->set_rules('no_surat', 'No.Surat', 'trim|required');
				$this->form_validation->set_rules('tgl_kirim', 'Tgl.Kirim', 'trim|required|date');
				$this->form_validation->set_rules('tgl_terima', 'Tgl.Kirim', 'trim|required|date');
				$this->form_validation->set_rules('pengirim', 'Pengirim', 'trim|required');
				$this->form_validation->set_rules('penerima', 'Penerima', 'trim|required');
				$this->form_validation->set_rules('perihal', 'Perihal', 'trim|required');

				if ($this->form_validation->run() == TRUE) {
					//konfigurasi upload file
					$config['upload_path'] 		= './uploads/';
					$config['allowed_types']	= 'pdf';
					$config['max_size']			= 2000;
					$this->load->library('upload', $config);

					if ($this->upload->do_upload('file_surat')) {

						if ($this->surat_model->tambah_surat_masuk($this->upload->data()) == TRUE) {
							$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fas fa-check"></i> Alert!</h5>Success.</div>');
							redirect('surat/masuk');
						} else {
							$this->session->set_flashdata('notif', '<div class="alert alert-danger alert-dismissible">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<h5><i class="icon fas fa-ban"></i> Alert!</h5>Gagal Upload file surat</div>');
							redirect('surat/masuk');
						}
					} else {
						$this->session->set_flashdata('notif', '<div class="alert alert-warning alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>' . $this->upload->display_errors() . '</div>');
						redirect('surat/masuk');
					}
				} else {
					$this->session->set_flashdata('notif', '<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h5><i class="icon fas fa-ban"></i> Alert!</h5>Harap Lengkapi Data sebelum <button class="btn btn-primary">Submit</button></div>');
					redirect('surat/masuk');
				}
			}
		} else {
			redirect('login');
		}
	}

	public function get_surat_masuk_by_id($id_surat)
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			if ($this->session->userdata('jabatan') == 'Sekretaris') {
				$data_surat_masuk_by_id = $this->surat_model->get_surat_masuk_by_id($id_surat);

				echo json_encode($data_surat_masuk_by_id);
			}
		} else {
			redirect('login', 'refresh');
		}
	}

	public function ubah_surat_masuk()
	{
		if ($this->session->userdata('logged_in') == TRUE) {

			if ($this->session->userdata('jabatan') == 'Sekretaris') {

				$this->form_validation->set_rules('edit_no_surat', 'No.Surat', 'trim|required');
				$this->form_validation->set_rules('edit_no_surat', 'Tgl.Kirim', 'trim|required|date');
				$this->form_validation->set_rules('edit_no_surat', 'Tgl.Kirim', 'trim|required|date');
				$this->form_validation->set_rules('edit_no_surat', 'Pengirim', 'trim|required');
				$this->form_validation->set_rules('edit_no_surat', 'Penerima', 'trim|required');
				$this->form_validation->set_rules('edit_no_surat', 'Perihal', 'trim|required');

				if ($this->form_validation->run() == TRUE) {
					if ($this->surat_model->ubah_surat_masuk() == TRUE) {
						$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fas fa-check"></i> Alert!</h5>Success.</div>');
						redirect('surat/masuk');
					} else {
						$this->session->set_flashdata('notif', '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>Gagal Ubah Data.</div>');
						redirect('surat/masuk', 'refresh');
					}
				} else {
					$this->session->set_flashdata('notif_validation', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fas fa-ban"></i> Alert!</h5>Harap Lengkapi Data sebelum <button class="btn btn-primary">Submit</button></div>');
					redirect('surat/masuk', 'refresh');
				}
			}
		} else {
			redirect('login', 'refresh');
		}
	}

	public function ubah_file_surat_masuk()
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			if ($this->session->userdata('jabatan') == 'Sekretaris') {
				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'pdf';
				$config['max_size']  = 2000;


				$this->load->library('upload', $config);
				if ($this->upload->do_upload('edit_file_surat')) {
					if ($this->surat_model->ubah_file_surat_masuk($this->upload->data()) == TRUE) {
						$this->session->set_flashdata('notif', '<div class="alert alert-dangger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fas fa-ban"></i> Alert!</h5>Gagal.</br>ubah file gagal</div>');
						redirect('surat/masuk');
					} else {
						$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fas fa-check"></i> Alert!</h5>Success.</div>');
						redirect('surat/masuk');
					}
				} else {
					$this->session->set_flashdata('notif', '<div class="alert alert-dangger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fas fa-ban"></i> Alert!</h5>Gagal.</br>' . $this->upload->display_errors() . '</div>');
					redirect('surat/masuk', 'refresh');
				}
			}
		} else {
			redirect('login', 'refresh');
		}
	}

	public function hapus_surat_masuk($id_surat)
	{
		if ($this->session->userdata('logged_in') ==  TRUE) {
			if ($this->session->userdata('jabatan') == 'Sekretaris') {
				if ($this->surat_model->hapus_surat_masuk($id_surat) == TRUE) {
					$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fas fa-check"></i> Success!</h5>Surat Dihapus.</div>');
					redirect('surat/masuk');
				} else {
					$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fas fa-ban"></i> Alert!</h5>Gagal Menghapus.</div>');
					redirect('surat/masuk');
				}
			} else {
			}
		} else {
			redirect('login', 'refresh');
		}
	}


	// surat surat_keluar
	public function keluar()
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			$data['page_title'] = "Daftar Surat Keluar";
			$data['title'] = "Surat Keluar";
			if ($this->session->userdata('jabatan') == 'Sekretaris') {
				$data['main_view'] = 'admin/surat_keluar_view';
				$data['main_js'] = 'datatable';
				$data['main_css'] = 'datatable';
				$data['data_surat_keluar'] = $this->surat_model->get_surat_keluar();
				$this->load->view('template', $data);
			} else {
			}
		} else {
			redirect('login', 'refresh');
		}
	}


	public function tambah_surat_keluar()
	{
		if ($this->session->userdata('logged_in') == TRUE) {

			if ($this->session->userdata('jabatan') == 'Sekretaris') {

				$this->form_validation->set_rules('no_surat', 'No.Surat', 'trim|required');
				$this->form_validation->set_rules('tgl_kirim', 'Tgl.Kirim', 'trim|required|date');
				$this->form_validation->set_rules('pengirim', 'Pengirim', 'trim|required');
				$this->form_validation->set_rules('penerima', 'Penerima', 'trim|required');
				$this->form_validation->set_rules('perihal', 'Perihal', 'trim|required');

				if ($this->form_validation->run() == TRUE) {
					//konfigurasi upload file
					$config['upload_path'] 		= './uploads/';
					$config['allowed_types']	= 'pdf';
					$config['max_size']			= 2000;
					$this->load->library('upload', $config);

					if ($this->upload->do_upload('file_surat')) {

						if ($this->surat_model->tambah_surat_keluar($this->upload->data()) == TRUE) {
							$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fas fa-check"></i> Success</h5>Berhasil menambah surat keluar.</div>');
							redirect('surat/keluar');
						} else {
							$this->session->set_flashdata('notif', '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fas fa-check"></i> Warning!</h5>File tidak terupload.</div>');
							redirect('surat/keluar');
						}
					} else {
						$this->session->set_flashdata('notif', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fas fa-check"></i> Danger!</h5>' . $this->upload->display_errors() . '</div>');
						redirect('surat/keluar');
					}
				} else {
					$this->session->set_flashdata('notif', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fas fa-check"></i> Danger!</h5>' . validation_errors() . '</div>');
					redirect('surat/keluar');
				}
			}
		} else {
			redirect('login');
		}
	}

	public function get_surat_keluar_by_id($id_surat)
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			if ($this->session->userdata('jabatan') == 'Sekretaris') {
				$data_surat_keluar_by_id = $this->surat_model->get_surat_keluar_by_id($id_surat);

				echo json_encode($data_surat_keluar_by_id);
			}
		} else {
			redirect('login', 'refresh');
		}
	}


	public function hapus_surat_keluar($id_surat)
	{
		if ($this->session->userdata('logged_in') ==  TRUE) {
			if ($this->session->userdata('jabatan') == 'Sekretaris') {
				if ($this->surat_model->hapus_surat_keluar($id_surat) == TRUE) {
					$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fas fa-check"></i> Success!</h5>Berhasil Menghapus</div>');

					redirect('surat/keluar', 'refresh');
				} else {
					$this->session->set_flashdata('notif', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fas fa-check"></i> Danger!</h5>Gagal Menghapus</div>');
					redirect('surat/keluar', 'refresh');
				}
			} else {
			}
		} else {
			redirect('login', 'refresh');
		}
	}

	// disposisi
	public function disposisi($id_surat)
	{
		if ($this->session->userdata('logged_in') ==  TRUE) {
			if ($this->session->userdata('jabatan') ==  'Sekretaris') {

				$data['main_view'] = 'admin/disposisi_admin';
				$data['data_surat'] = $this->surat_model->get_surat_masuk_by_id($this->uri->segment(3));
				$data['drop_down_jabatan'] = $this->surat_model->get_jabatan();
				$data['data_disposisi'] = $this->surat_model->get_all_disposisi($id_surat);

				$this->load->view('template', $data);
			} else {
				$data['main_view'] = 'pegawai/disposisi_masuk';
				$this->load->view('template', $data);
			}
		} else {
			redirect('login', 'refresh');
		}
	}

	public function get_pegawai_by_jabatan($id_jabatan)
	{
		if ($this->session->userdata('logged_in') ==  TRUE) {
			$data_pegawai = $this->surat_model->get_pegawai_by_jabatan($id_jabatan);

			echo json_encode($data_pegawai);
		} else {
			redirect('login', 'refresh');
		}
	}

	public function tambah_disposisi()
	{
		if ($this->session->userdata('logged_in') ==  TRUE) {
			$this->form_validation->set_rules('tujuan_pegawai', 'Tujuan Pegawai', 'trim|required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');

			if ($this->form_validation->run() ==  TRUE) {
				if ($this->surat_model->tambah_disposisi($this->uri->segment(3)) ==  TRUE) {
					$this->session->set_flashdata('notif', 'tambah disposisi berhasil');
					if ($this->session->userdata('jabatan') == 'Sekretaris') {
						redirect('surat/disposisi/' . $this->uri->segment(3), 'refresh');
					} else {
						redirect('surat/disposisi_keluar/' . $this->uri->segment(3), 'refresh');
					}
				} else {
					$this->session->set_flashdata('notif', 'tambah disposisi gagal');
					if ($this->session->userdata('jabatan') == 'Sekretaris') {
						redirect('surat/disposisi/' . $this->uri->segment(3), 'refresh');
					} else {
						redirect('surat/disposisi_keluar/' . $this->uri->segment(3), 'refresh');
					}
				}
			} else {
				$this->session->set_flashdata('notif', validation_errors());
				if ($this->session->userdata('jabatan') == 'Sekretaris') {
					redirect('surat/disposisi/' . $this->uri->segment(3), 'refresh');
				} else {
					redirect('surat/disposisi_keluar/' . $this->uri->segment(3), 'refresh');
				}
			}
		} else {
			redirect('login', 'refresh');
		}
	}

	public function disposisi_keluar($id_surat)
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			$data['data_disposisi'] = $this->surat_model->get_all_disposisi_keluar($this->session->userdata('id_pegawai'));
			$data['data_surat'] = $this->surat_model->get_surat_masuk_by_id($id_surat);
			$data['drop_down_jabatan'] = $this->surat_model->get_jabatan();
			$data['main_view'] = 'pegawai/disposisi_keluar';
			$this->load->view('template', $data);
		} else {
			redirect('login', 'refresh');
		}
	}

	public function hapus_disposisi($id_surat, $id_disposisi)
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			if ($this->surat_model->hapus_disposisi($id_disposisi) == TRUE) {
				$this->session->set_flashdata('notif', 'hapus berhasil');
				redirect('surat/disposisi/' . $id_surat);
			} else {
				$this->session->set_flashdata('notif', 'hapus gagal');
				redirect('surat/disposisi/' . $id_surat);
			}
		} else {
			redirect('login', 'refresh');
		}
	}

	public function hapus_disposisi_keluar($id_surat, $id_disposisi)
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			if ($this->surat_model->hapus_disposisi($id_disposisi) == TRUE) {
				$this->session->set_flashdata('notif', 'hapus berhasil');
				redirect('surat/disposisi_keluar/' . $id_surat);
			} else {
				$this->session->set_flashdata('notif', 'hapus gagal');
				redirect('surat/disposisi_keluar/' . $id_surat);
			}
		} else {
			redirect('login', 'refresh');
		}
	}
}

/* End of file surat.php */
/* Location: ./application/controllers/surat.php */