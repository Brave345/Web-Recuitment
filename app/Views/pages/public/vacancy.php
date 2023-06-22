<?= $this->extend('layouts/vacancy_base') ?>
<?= $this->section('content') ?>
<div class="card rounded-0 shadow">
    <div class="card-header">
        <div class="text-end">
            <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-sm rounded-0 btn-light border"><i class="fa fa-angle-left"></i> Back</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <h3 class="fw-bolder mt-3"><?= $vacancy['position'] ?></h3>
            <hr>
            <div class="d-flex justify-content-between">
                <div>
                    <small class="text-muted"><i class="fa fa-th-list"></i> Department: <?= $vacancy['department'] ?></small>
                </div>
                <div>
                    <small class="text-muted me-3"><i class="far fa-clock"></i> Added at: <?= date("M d, Y h:i A", strtotime($vacancy['created_at'])) ?></small>
                    <small class="text-muted"><i class="fa fa-circle"></i> Slots: <?= number_format($vacancy['available']) ?></small>
                </div>
            </div>
            <div class="py-3">
                <?= htmlspecialchars_decode($vacancy['description']) ?>
            </div>
            <p class="truncate-5"><?= strip_tags(htmlspecialchars_decode($vacancy['description'])) ?></p>
        </div>
    </div>
</div>
<div class="row justify-content-center my-3">
    <div class="col-lg-6 col-md-8 col-sm-10 col-xs-12">
        <div class="card rounded-0 shadow">
            <div class="card-header">
                <div class="card-title fw-bold h4 mb-0">Application Form</div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <form action="<?= base_url('Vacancy/view/'.$vacancy['id']) ?>" method="POST" id="application-form">
                        <input type="hidden" name="vacancy_id" value="<?= $vacancy['id'] ?>">
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
                        <div class="mb-3">
                            <label for="first_name" class="control-label">First Name</label>
                            <input type="text" class="form-control rounded-0" id="first_name" name="first_name" required="required">
                        </div>
                        <div class="mb-3">
                            <label for="middle_name" class="control-label">Middle Name</label>
                            <input type="text" class="form-control rounded-0" id="middle_name" name="middle_name" >
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="control-label">Last Name</label>
                            <input type="text" class="form-control rounded-0" id="last_name" name="last_name" required="required">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="control-label">Email</label>
                            <input type="email" class="form-control rounded-0" id="email" name="email" required="required">
                        </div>
                        <div class="mb-3">
                            <label for="contact" class="control-label">Contact</label>
                            <input type="text" class="form-control rounded-0" id="contact" name="contact" required="required">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="control-label">Address</label>
                            <textarea rows="3" class="form-control rounded-0" id="address" name="address" required="required"></textarea>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-footer text-center">
                <button class="btn btn-primary bg-gradient rounded-0" form="application-form"><i class="fa fa-save"></i>Submit Appliction</button>
                <button class="btn btn-light border bg-gradient rounded-0" form="application-form" type="reset"><i class="fa fa-times"></i>Cancel</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>