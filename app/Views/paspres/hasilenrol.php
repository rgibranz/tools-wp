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
            <table class="table table-striped table-dark table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($hasil as $data) : ?>
                        <tr>
                            <td><?= $data['email'] ?></td>
                            <td>
                                <?php if ($data['status'] == 'tidak bisa') : ?>
                                    <span class="badge badge-warning">tidak bisa</span>
                                <?php elseif ($data['status'] == 'gagal') : ?>
                                    <span class="badge badge-danger">gagal</span>
                                <?php elseif ($data['status'] == 'berhasil') : ?>
                                    <span class="badge badge-success">berhasil</span>
                                <?php endif ?>
                            </td>
                            <td><?= $data['ket'] ?></td>
                        </tr>
                    <?php endforeach ?>

                </tbody>
            </table>
            <!-- /.row -->
        </div>

    </div>
    <!-- /.card -->
</div>
<!-- /.container-fluid -->

<?= $this->endSection() ?>