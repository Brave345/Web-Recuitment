<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
        <div class="d-flex w-100 justify-content-between">
            <div class="col-auto">
                <div class="card-title h4 mb-0 fw-bolder">Application Details</div>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('Main/applicants') ?>" class="btn btn btn-light bg-gradient border rounded-0"><i class="fa fa-angle-left"></i> Back to List</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <?php if($session->getFlashdata('error')): ?>
                <div class="alert alert-danger rounded-0">
                    <?= $session->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            <?php if($session->getFlashdata('success')): ?>
                <div class="alert alert-success rounded-0">
                    <?= $session->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            <dl class="d-flex w-100 m-0">
                <dt class="col-3 m-0 px-2 border bg-primary bg-gradient text-light py-1">Applying for</dt>
                <dd class="col-9 m-0 border px-2 py-1"><?= $applicant['department'] ?>-<?= $applicant['position'] ?></dd>
            </dl>
            <dl class="d-flex w-100 m-0">
                <dt class="col-3 m-0 px-2 border bg-primary bg-gradient text-light py-1">Applicant Name</dt>
                <dd class="col-9 m-0 border px-2 py-1"><?= $applicant['name'] ?></dd>
            </dl>
            <dl class="d-flex w-100 m-0">
                <dt class="col-3 m-0 px-2 border bg-primary bg-gradient text-light py-1">Email</dt>
                <dd class="col-9 m-0 border px-2 py-1"><?= $applicant['email'] ?></dd>
            </dl>
            <dl class="d-flex w-100 m-0">
                <dt class="col-3 m-0 px-2 border bg-primary bg-gradient text-light py-1">Contact</dt>
                <dd class="col-9 m-0 border px-2 py-1"><?= $applicant['contact'] ?></dd>
            </dl>
            <dl class="d-flex w-100 m-0">
                <dt class="col-3 m-0 px-2 border bg-primary bg-gradient text-light py-1">Contact</dt>
                <dd class="col-9 m-0 border px-2 py-1"><?= $applicant['address'] ?></dd>
            </dl>
            <dl class="d-flex w-100 m-0">
                <dt class="col-3 m-0 px-2 border bg-primary bg-gradient text-light py-1">Status</dt>
                <dd class="col-9 m-0 border px-2 py-1">
                    <?php 
                        switch($applicant['status']){
                            case 0:
                                echo "<span class='badge bg-gradient bg-light border px-3 text-dark'>Pending</span>";
                                break;
                            case 1:
                                echo "<span class='badge bg-gradient bg-primary px-3'>Hired</span>";
                                break;
                            case 2:
                                echo "<span class='badge bg-gradient bg-danger px-3'>Not Hired</span>";
                                break;
                            default:
                                echo "<span class='badge bg-gradient bg-light border px-3 text-dark'>N/A</span>";
                                break;
                        } 
                    ?>
                </dd>
            </dl>
        </div>
    </div>
    <div class="card-footer text-center">
        <a href="<?= base_url("Main/applicant_hired/".$applicant['id']) ?>" class="btn btn-primary bg-gradient rounded-0 btn-sm" onclick="if(confirm('Apakah Anda yakin untuk menandai pelamar ini sebagai dipekerjakan?') === false) event.preventDefault()"><i class="fa fa-check"></i> Tandai sebagai Dipekerjakan</a>
        <a href="<?= base_url("Main/applicant_nothired/".$applicant['id']) ?>" class="btn btn-light border bg-gradient rounded-0 btn-sm" onclick="if(confirm('Apakah Anda yakin untuk menandai pelamar ini sebagai tidak dipekerjakan?') === false) event.preventDefault()"><i class="fa fa-times"></i> Tandai sebagai Tidak Dipekerjakan</a>
        <a href="<?= base_url("Main/applicant_delete/".$applicant['id']) ?>" class="btn btn-danger bg-gradient rounded-0 btn-sm" onclick="if(confirm('Apakah Anda yakin akan menghapus pelamar ini?') === false) event.preventDefault()"><i class="fa fa-trash"></i> Delete</a>
    </div>
</div>
<?= $this->endSection() ?>