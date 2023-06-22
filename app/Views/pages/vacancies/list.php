<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
    <div class="d-flex w-100 justify-content-between">
            <div class="col-auto">
                <div class="card-title h4 mb-0 fw-bolder">List of Vacancies</div>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('Main/vacancy_add') ?>" class="btn btn btn-primary bg-gradient rounded-0"><i class="fa fa-plus-square"></i> Add Vacancy</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="row justify-content-center mb-3">
                <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                    <form action="<?= base_url("Main/vacancies") ?>" method="GET">
                    <div class="input-group">
                        <input type="search" id="search" name="search" placeholder="Search vacancy here." value="<?= $request->getVar('search') ?>" class="form-control">
                        <button class="btn btn-outline-default border"><i class="fa fa-search"></i></button>
                    </div>
                    </form>
                </div>
            </div>
            <table class="table table-striped table-bordered">
                <colgroup>
                    <col width="10%">
                    <col width="15%">
                    <col width="20%">
                    <col width="25%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <th class="p-1 text-center">#</th>
                    <th class="p-1 text-center">Created/Updated</th>
                    <th class="p-1 text-center">Department</th>
                    <th class="p-1 text-center">Position</th>
                    <th class="p-1 text-center">Slot</th>
                    <th class="p-1 text-center">Available</th>
                    <th class="p-1 text-center">Action</th>
                </thead>
                <tbody>
                    <?php foreach($vacancies as $row): ?>
                        <tr>
                            <th class="p-1 text-center align-middle"><?= $row['id'] ?></th>
                            <td class="px-2 py-1 align-middle"><?= date("M d, Y h:i A", strtotime($row['updated_at'])) ?></td>
                            <td class="px-2 py-1 align-middle"><?= ($row['department']) ?></td>
                            <td class="px-2 py-1 align-middle"><?= ($row['position']) ?></td>
                            <td class="px-2 py-1 align-middle text-end"><?= number_format($row['slot']) ?></td>
                            <td class="px-2 py-1 align-middle text-end"><?= number_format($row['available']) ?></td>
                            <td class="px-2 py-1 align-middle text-center">
                                <a href="<?= base_url('Main/vacancy_edit/'.$row['id']) ?>" class="mx-2 text-decoration-none text-primary"><i class="fa fa-edit"></i></a>
                                <a href="<?= base_url('Main/vacancy_delete/'.$row['id']) ?>" class="mx-2 text-decoration-none text-danger" onclick="if(confirm('Are you sure to delete  <?= $row['position'] ?> from list?') !== true) event.preventDefault()"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if(count($vacancies) <= 0): ?>
                        <tr>
                            <td class="p-1 text-center" colspan="7">No result found</td>
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