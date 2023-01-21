<div class="row mt-3">
  <div class="col-md-12">

    <div class="card mt-3">
      <div class="card-body">
        <div class="row">
          <form action="" style="width:100%" class="d-flex" method="POST">
            <div class="col-md-2">
              <div class="row">Filter:</div>
            </div>
            <div class="col-md-2 ml-1">
              <div class="row">
                Project Name
              </div>
              <div class="row">

                <input class="form-control" type="text" name="project_name" id="project_name" value="<?= ($q_project) ? $q_project : ''; ?>">

              </div>
            </div>
            <div class="col-md-2 ml-1">
              <div class="row">Client</div>
              <div class="row">
                <select class="form-control" name="client" id="client">
                  <option value="null">All Client</option>
                  <?php foreach ($clients as $client) : ?>
                    <option value="<?= $client->client_name; ?>" <?= ($q_client == $client->client_name) ? 'selected' : ''; ?>><?= $client->client_name; ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
            <div class="col-md-2 ml-1">
              <div class="row">Status</div>
              <div class="row">
                <select class="form-control" name="status" id="status">
                  <option value="null">All Status</option>
                  <option value="OPEN" <?= ($q_status == 'OPEN') ? 'selected' : ''; ?>>OPEN</option>
                  <option value="DOING" <?= ($q_status == 'DOING') ? 'selected' : ''; ?>>DOING</option>
                  <option value="DONE" <?= ($q_status == 'DONE') ? 'selected' : ''; ?>>DONE</option>

                </select>
              </div>
            </div>
            <div class="col-md-2 ml-1">
              <div class="row" style="color:white">.</div>
              <div class="row">
                <button type="submit" class="btn btn-primary">Search</button>
                <button type="button" onclick="Reset();" class="btn btn-secondary ml-1">Clear</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php if ($this->session->flashdata('success')) : ?>
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
        <?= $this->session->flashdata('success'); ?>
      </div>
    <?php endif ?>
    <?php if ($this->session->flashdata('error')) : ?>
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-ban"></i> Gagal!</h5>
        <?= $this->session->flashdata('error'); ?>
      </div>
    <?php endif ?>
    <form action="<?= base_url('project/delete_checkbox'); ?>" method="POST">
      <a href="<?= base_url('project/create'); ?>" class="btn btn-primary">New</a>
      <button type="submit" name="delete_checkbox" class="btn btn-danger" onclick="return(confirm('yakin?'))">Delete</button>
      <div class="card mt-3">
        <div class="card-body">
          <table id="example2" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th style="width: 10px;"><input type="checkbox" name="select_all" onchange="checkAll(this)"></th>
                <th>Action</th>
                <th>Project Name</th>
                <th>Client</th>
                <th>Start</th>
                <th>End</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; ?>
              <?php foreach ($projects as $project) : ?>
                <?php
                $project_start = date("d M Y", strtotime($project->project_start));
                $project_end = date("d M Y", strtotime($project->project_end));
                ?>
                <tr>
                  <td>
                    <input type="checkbox" name="checkbox_value[]" value="<?= $project->project_id; ?>">
                  </td>
                  <td>
                    <a href="<?= base_url('project/edit/' . $project->project_id); ?>">Edit</a>
                  </td>
                  <td><?= $project->project_name; ?></td>
                  <td><?= $project->client_name; ?></td>
                  <td><?= $project_start; ?></td>
                  <td><?= $project_end; ?></td>
                  <td><?= $project->Project_status; ?></td>
                </tr>
              <?php endforeach ?>

            </tbody>
          </table>
    </form>
  </div>
</div>
</div>
</div>