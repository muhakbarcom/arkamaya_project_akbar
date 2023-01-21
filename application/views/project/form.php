<div class="row mt-3">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3><?= $title; ?></h3>
          </div>
          <div class="card-body">
            <?php if ($this->session->flashdata('error')) : ?>
              <div class="alert alert-danger" role="alert">
                <?= $this->session->flashdata('error'); ?>
              </div>
            <?php elseif ($this->session->flashdata('success')) : ?>
              <div class="alert alert-success" role="alert">
                <?= $this->session->flashdata('success'); ?>
              </div>
            <?php endif ?>

            <?php echo form_open($action); ?>

            <div class="form-group ">
              <label for="">Project Name</label> <br />
              <input type="text" name="project_name" id="project_name" class="form-control" required value="<?= $project_name; ?>">
              <div id="emailHelp" class="form-text text-danger"><?php echo form_error('project_name'); ?></div>
            </div>
            <div class="form-group ">
              <label for="">Client</label> <br />
              <select class="form-control" name="client" id="client">
                <option value="null">All Client</option>
                <?php foreach ($clients as $clientx) : ?>
                  <option value="<?= $clientx->client_id; ?>" <?= ($client == $clientx->client_id) ? 'selected' : ''; ?>><?= $clientx->client_name; ?></option>
                <?php endforeach ?>
              </select>
              <div id="emailHelp" class="form-text text-danger"><?php echo form_error('project_name'); ?></div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-2">
                  <label for="">Project Start</label>
                  <input type="date" class="form-control" name="project_start" value="<?= $project_start; ?>" required>
                </div>
                <div class="col-md-2">
                  <label for="">Project End</label>
                  <input type="date" class="form-control" name="project_end" value="<?= $project_end; ?>" required>
                </div>
              </div>
            </div>
            <div class="form-group ">
              <label for="">Status</label> <br />
              <select class="form-control" name="status" id="status">
                <option value="null">All Status</option>
                <option value="OPEN" <?= ($status == 'OPEN') ? 'selected' : ''; ?>>OPEN</option>
                <option value="DOING" <?= ($status == 'DOING') ? 'selected' : ''; ?>>DOING</option>
                <option value="DONE" <?= ($status == 'DONE') ? 'selected' : ''; ?>>DONE</option>
              </select>
              <div id="emailHelp" class="form-text text-danger"><?php echo form_error('project_name'); ?></div>
            </div>
            <input type="hidden" name="id" value="<?= $id; ?>">

            <p><a class="btn btn-secondary mr-2" href="<?= base_url('project'); ?>">Kembali</a><?php echo form_submit('submit', 'Simpan', 'class="btn btn-primary"'); ?></p>

            <?php echo form_close(); ?>

          </div>
        </div>
      </div>
    </div>
  </div>

</div>