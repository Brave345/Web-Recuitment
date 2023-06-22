<?= $this->extend('layouts/vacancy_base') ?>
<?= $this->section('custom_css') ?>
<style>
    .post-img-holder{
        width:100%;
        max-height:10em;
    }
    .post-img{
        width:100%;
        height:100%;
        object-fit:cover;
        object-position:center center;
        transition:all .2s ease-in-out;
    }
    .post-item:hover .post-img{
        transform:scale(1.2);
    }
    .truncate-5 {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 5;
        -webkit-box-orient: vertical;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="card rounded-0 shadow mb-3">
    <div class="card-body">
        <div class="container-fluid">
            <h4 class="fw-bolder">Welcome to <?= env('system_name') ?></h4>
        </div>
    </div>
</div>
<div class="list-group" id="post-list">
    <?php 
        foreach($vacancies as $row):
    ?>
    <a href="<?= base_url("Vacancy/view/".$row['id']) ?>" class="list-group-item list-group-item-action text-decoration-none text-reset post-item">
        <div class="container-fluid">
            <div class="h4 fw-bolder"><?= $row['position'] ?></div>
            <hr>
            <div class="d-flex justify-content-between">
                <div>
                    <small class="text-muted"><i class="fa fa-th-list"></i> Department: <?= $row['department'] ?></small>
                </div>
                <div>
                    <small class="text-muted me-3"><i class="far fa-clock"></i> Added at: <?= date("M d, Y h:i A", strtotime($row['created_at'])) ?></small>
                    <small class="text-muted"><i class="fa fa-circle"></i> Slots: <?= number_format($row['available']) ?></small>
                </div>
            </div>
            <p class="truncate-5"><?= strip_tags(htmlspecialchars_decode($row['description'])) ?></p>
            <div><b>Salary Range:</b> Php <?= number_format($row['salary_from'],2) ?>-<?= number_format($row['salary_to'],2) ?></div>
        </div>
    </a>
    <?php endforeach; ?>
</div>
<?php if(isset($vacancies) && count($vacancies) <= 0): ?>
    <center><small class="text-muted"><i>No job openings yet.</i></small></center>
<?php endif; ?>
<div class="bg-light pt-4 px-3 my-3">
    <?= $pager->makeLinks($page, $perPage, $total, 'custom_view') ?>
</div>
<?= $this->endSection() ?>