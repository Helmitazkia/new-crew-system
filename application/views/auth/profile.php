<?php $this->load->view('layout/header'); ?>

<style>
    .profile-cover {
        height: 180px;
        background: linear-gradient(135deg, #067780 0%, #005c63 100%);
        border-radius: 12px 12px 0 0;
        position: relative;
    }
    
    .profile-avatar-container {
        position: absolute;
        bottom: -50px;
        left: 30px;
        z-index: 2;
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid #fff;
        object-fit: cover;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        background-color: #fff;
    }
    
    .avatar-initials {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: bold;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .btn-upload-photo {
        position: absolute;
        bottom: 0;
        right: 0;
        background-color: #fff;
        color: #067780;
        border: 1px solid #dee2e6;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: all 0.2s ease;
    }
    
    .btn-upload-photo:hover {
        background-color: #f8f9fa;
        transform: scale(1.1);
    }
    
    .profile-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        margin-top: 20px;
        margin-bottom: 40px;
    }
    
    .form-group-custom label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
    }
    
    .form-control-custom {
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding: 10px 15px;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    .form-control-custom:focus {
        border-color: #067780;
        box-shadow: 0 0 0 0.2rem rgba(6, 119, 128, 0.25);
    }
</style>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?php echo $this->session->flashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo $this->session->flashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card profile-card">
                <form action="<?php echo base_url('profile/update_profile'); ?>" method="POST" enctype="multipart/form-data">
                    <div class="profile-cover">
                        <div class="profile-avatar-container">
                            <?php 
                            $CI =& get_instance();
                            $user_db = $CI->db->get_where('login', array('userId' => $this->session->userdata('userId')))->row();
                            $image_profile = $user_db ? $user_db->image_profile : '';
                            if (!empty($image_profile) && file_exists(FCPATH . 'assets/img/profile/' . $image_profile)): ?>
                                <img src="<?php echo base_url('assets/img/profile/' . $image_profile); ?>" id="preview-image" class="profile-avatar">
                            <?php else: ?>
                                <div id="preview-avatar" class="avatar-initials">
                                    <?php echo substr($this->session->userdata('userFullNm'), 0, 1); ?>
                                </div>
                                <img src="" id="preview-image" class="profile-avatar d-none">
                            <?php endif; ?>
                            
                            <label for="image_profile" class="btn-upload-photo" title="Ganti Foto Profil">
                                <i class="fas fa-camera"></i>
                            </label>
                            <input type="file" id="image_profile" name="image_profile" class="d-none" accept="image/jpeg, image/png">
                        </div>
                    </div>
                    
                    <div class="card-body pt-5 px-4 pb-4">
                        <div class="row mt-4">
                            <div class="col-12 mb-4">
                                <h5 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="fas fa-user-edit me-2" style="color: #067780;"></i>Informasi Akun</h5>
                            </div>
                            
                            <div class="col-md-6 mb-3 form-group-custom">
                                <label>Username <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                                    <input type="text" class="form-control form-control-custom border-start-0" name="userName" value="<?php echo isset($user->userName) ? $user->userName : $this->session->userdata('userName'); ?>" readonly style="background-color: #f8f9fa;">
                                </div>
                                <small class="text-muted">Username digunakan untuk login dan tidak dapat diubah.</small>
                            </div>
                            
                            <div class="col-md-6 mb-3 form-group-custom">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-id-card" style="color: #067780;"></i></span>
                                    <input type="text" class="form-control form-control-custom border-start-0" name="userFullNm" value="<?php echo isset($user->userFullNm) ? $user->userFullNm : $this->session->userdata('userFullNm'); ?>" required placeholder="Masukkan Nama Lengkap">
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3 form-group-custom">
                                <label>Inisial</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-font" style="color: #067780;"></i></span>
                                    <input type="text" class="form-control form-control-custom border-start-0" name="userInit" value="<?php echo isset($user->userInit) ? $user->userInit : ''; ?>" maxlength="5" placeholder="Contoh: AB">
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4 form-group-custom">
                                <label>Role Pengguna (User Jenis)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-user-shield text-muted"></i></span>
                                    <input type="text" class="form-control form-control-custom border-start-0" value="<?php echo isset($user->userJenis) ? $user->userJenis : $this->session->userdata('userType'); ?>" disabled style="background-color: #e9ecef;">
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end border-top pt-4">
                            <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-light px-4 me-2 fw-semibold" style="border-radius: 8px;">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 fw-semibold" style="border-radius: 8px; background-color: #067780; border-color: #067780; box-shadow: 0 4px 6px rgba(6, 119, 128, 0.2);">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('image_profile').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validasi ukuran (2MB)
            if (file.size > 2097152) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Terlalu Besar',
                    text: 'Ukuran file maksimal adalah 2MB.'
                });
                this.value = '';
                return;
            }
            // Validasi tipe file
            if (!['image/jpeg', 'image/png'].includes(file.type)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Format Tidak Valid',
                    text: 'Hanya file JPG dan PNG yang diperbolehkan.'
                });
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById('preview-image');
                const previewAvatar = document.getElementById('preview-avatar');
                
                previewImg.src = e.target.result;
                previewImg.classList.remove('d-none');
                if (previewAvatar) {
                    previewAvatar.classList.add('d-none');
                }
            }
            reader.readAsDataURL(file);
        }
    });
</script>
