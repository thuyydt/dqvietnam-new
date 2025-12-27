<div class="input-group">
  <span class="input-group-addon" onclick="chooseVideo('<?= $name ?>')"><i class="fa fa-fw fa-file"></i>Video</span>
  <input id="<?= $name ?>" onclick="chooseVideo('<?= $name ?>')" name="<?= $name ?>"
    placeholder="Chọn Video " class="form-control" type="text"
    value="<?= $value ?>" />
</div>