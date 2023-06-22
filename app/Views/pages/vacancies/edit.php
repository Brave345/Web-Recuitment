<?= $this->extend('layouts/main') ?>

<?= $this->section('custom_css') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" integrity="sha512-ngQ4IGzHQ3s/Hh8kMyG4FC74wzitukRMIcTOoKT3EyzFZCILOPF0twiXOQn75eDINUfKBYmzYn2AA8DkAk8veQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js" integrity="sha512-6F1RVfnxCprKJmfulcxxym1Dar5FsT/V2jiEUvABiaEiFWoQ8yHvqRM/Slf0qJKiwin6IDQucjXuolCfCKnaJQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<style>
    #img-viewer{
        width:100%;
        max-height:20em;
        object-fit:scale-down;
        object-position:center center;
    }
    .form-group.note-form-group.note-group-select-from-files {
        display: none;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
        <div class="d-flex w-100 justify-content-between">
            <div class="col-auto">
                <div class="card-title h4 mb-0 fw-bolder">Edit Vacancy</div>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('Main/vacancies') ?>" class="btn btn btn-light bg-gradient border rounded-0"><i class="fa fa-angle-left"></i> Back to List</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <form action="<?= base_url('Main/vacancy_edit/'.$vacancy['id']) ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="user_id" value="<?= $session->login_id ?>">
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
                <div class="mb-3 col-lg-6 col-md-6 col-sm-10 col-xs-12">
                    <label for="department_id" class="control-label">Department</label>
                    <select class="form-select rounded-0" id="department_id" name="department_id" autofocus required="required">
                        <option value="" disabled <?= isset($vacancy['department_id']) ?"selected" : '' ?>></option>
                        <?php foreach($departments as $row): ?>
                            <option value="<?= $row['id'] ?>" <?= isset($vacancy['department_id']) && $vacancy['department_id'] == $row['id'] ? "selected" : "" ?>><?= $row['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="position" class="control-label">Position</label>
                    <input type="text" class="form-control rounded-0" id="position" name="position" value="<?= !empty($vacancy['position']) ? $vacancy['position'] : '' ?>" required="required">
                </div>
                <div class="mb-3">
                    <label for="description" class="control-label">Description</label>
                    <textarea rows="4" class="form-control rounded-0" id="description" name="description" value="" required="required"><?= !empty($vacancy['description']) ? htmlspecialchars_decode($vacancy['description']) : '' ?></textarea>
                </div>
                <div class="mb-3 col-lg-6 col-md-6 col-sm-10 col-xs-12">
                    <label for="slot" class="control-label">Slot</label>
                    <input type="number" class="form-control rounded-0" id="slot" name="slot" value="<?= !empty($vacancy['slot']) ? $vacancy['slot'] : '' ?>" required="required">
                </div>
                <div class="mb-3 col-lg-6 col-md-6 col-sm-10 col-xs-12">
                    <label for="" class="control-label">Salary Range</label>
                    <div class="input-group rounded-0">
                        <input type="number" step="any" class="form-control rounded-0" id="salary_from" name="salary_from" placholder="From" value="<?= !empty($vacancy['salary_from']) ? $vacancy['salary_from'] : '' ?>" required="required">
                        <span class="input-group-text"> - </span>
                        <input type="number" step="any" class="form-control rounded-0" id="salary_to" name="salary_to" placholder="To" value="<?= !empty($vacancy['salary_to']) ? $vacancy['salary_to'] : '' ?>" required="required">
                    </div>
                </div>
                <div class="mb-3 col-lg-6 col-md-6 col-sm-10 col-xs-12">
                    <label for="status" class="control-label">Status</label>
                    <select name="status" id="status" class="form-select rounded-0" required="required">
                        <option value="1" <?= isset($vacancy['department_id']) && $vacancy['department_id'] == 1 ? "selected" : "" ?>>Open</option>
                        <option value="0" <?= isset($vacancy['department_id']) && $vacancy['department_id'] == 0 ? "selected" : "" ?>>Closed</option>
                    </select>
                </div>
                <div class="d-grid gap-1">
                    <button class="btn rounded-0 btn-primary bg-gradient">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('custom_js') ?>
<script>
    function display_img(input){
        if(input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#img-viewer').attr('src', e.target.result)
            }
            reader.readAsDataURL(input.files[0])
        }else{
            $('#img-viewer').attr('src', '')
        }
    }
    $(function(){
        $('#department_id').select2({
            placeholder:'Please select department here',
            width:'100%',
            containerCssClass:'form-control rounded-0 py-0 h-auto'
        })
        $('#description').summernote({
            placeholder:'Write the job description here.',
            height:'20em',
            toolbar: [
		            [ 'style', [ 'style' ] ],
		            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
		            [ 'fontname', [ 'fontname' ] ],
		            [ 'fontsize', [ 'fontsize' ] ],
		            [ 'color', [ 'color' ] ],
		            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
		            [ 'table', [ 'table', 'picture', 'video'] ],
		            [ 'view', [ 'undo', 'redo', 'help' ] ]
		        ]
        })
    })
</script>
<?= $this->endSection() ?>