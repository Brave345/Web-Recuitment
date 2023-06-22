<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
        <div class="d-flex w-100 justify-content-between">
            <div class="col-auto">
                <div class="card-title h4 mb-0 fw-bolder">List of Applicants</div>
            </div>
            
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-striped table-bordered">
                <colgroup>
                    <col width="10%">
                    <col width="25%">
                    <col width="25%">
                    <col width="20%">
                    <col width="20%">
                </colgroup>
                <thead>
                    <th class="p-1 text-center">#</th>
                    <th class="p-1 text-center">Lowongan</th>
                    <th class="p-1 text-center">Applicant</th>
                    <th class="p-1 text-center">Contact</th>
                    <th class="p-1 text-center">Action</th>
                </thead>
                <tbody>
                    <?php foreach($applicants as $row): ?>
                        <tr>
                            <th class="p-1 text-center align-middle"><?= $row['id'] ?></th>
                            <td class="px-2 py-1 align-middle"><?= $row['position'] ?></td>
                            <td class="px-2 py-1 align-middle"><?= $row['name'] ?></td>
                            <td class="px-2 py-1 align-middle">
                                <div class="lh-1">
                                    <small><?= $row['contact'] ?></small>
                                    <small><?= $row['email'] ?></small>
                                </div>
                            </td>
                            <td class="px-2 py-1 align-middle text-center">
                                <a href="<?= base_url('Main/applicant_view/'.$row['id']) ?>" class="mx-2 text-decoration-none text-dark"><i class="fa fa-eye"></i></a>
                                <a href="<?= base_url('Main/applicant_delete/'.$row['id']) ?>" class="mx-2 text-decoration-none text-danger" onclick="if(confirm('Are you sure to delete <?= $row['name'] ?> from list?') !== true) event.preventDefault()"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if(count($applicants) <= 0): ?>
                        <tr>
                            <td class="p-1 text-center" colspan="4">No result found</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
            <div>
                <?= $pager->makeLinks($page, $perPage, $total, 'custom_view') ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>