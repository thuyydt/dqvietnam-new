<div class="tab-pane " id="<?= $target ?>">
  <fieldset class="form-group album-contain">
    <legend for="">Blacklist</legend>
    <div class="col-md-12">
      <div class="form-group">
        <label for="blacklist">Dãy số (Mỗi số 1 dòng)</label>
        <textarea name="blacklist" id="blacklist" class="form-control"
          rows="10"><?= !empty($blacklist) ? $blacklist : '' ?></textarea>
      </div>
    </div>
  </fieldset>
</div>