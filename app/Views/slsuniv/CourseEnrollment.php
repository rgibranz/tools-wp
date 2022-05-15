<?= $this->extend('layouts') ?>

<?= $this->section('content') ?>

<div class="container mt-5">

    <!-- SELECT2 EXAMPLE -->
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Export Course Enrollement</h3>

        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form action="<?= site_url('slsuniv/ExportCourseEnrollment') ?>" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <select class="form-control select2" style="width: 100%;" name="post_id">
                                <?php foreach ($course as $data) : ?>
                                    <option value="<?= $data['ID'] ?>"><?= $data['post_title'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="submit" value="Export" class="form-control btn btn-primary">
                        </div>
                    </div>
                </div>
            </form>
            <!-- /.row -->
        </div>

    </div>
    <!-- /.card -->
</div>
<!-- /.container-fluid -->

<?= $this->endSection() ?>