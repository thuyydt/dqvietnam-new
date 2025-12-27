<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap-grid.min.css"
  integrity="sha512-ZuRTqfQ3jNAKvJskDAU/hxbX1w25g41bANOVd1Co6GahIe2XjM6uVZ9dh0Nt3KFCOA061amfF2VeL60aJXdwwQ=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
  .content-pay {
    margin-top: 100px;
    background: #ec1c24;
    padding: 20px;
    border-radius: 20px;
  }

  .form-wrap {
    position: relative;
    height: 100%;
  }

  .input-group {
    position: absolute;
    bottom: 5%;
    display: flex;
    justify-content: center;
    left: 0;
    right: 0;
    height: 40px;
  }

  .input-group .form-input {
    height: 40px;
    border-radius: 10px;
    width: 80%;
    padding-left: 10px;
    border: 1px solid #ec1c24;
  }

  .input-group button {
    position: absolute;
    background: white;
    height: 40px;
    border: 1px solid #ec1c24;
    border-radius: 10px;
    right: 20px;
  }

  .content-right {
    position: relative;
    display: flex;
    height: 100%;
    justify-content: space-between;
    align-items: center;
    flex-direction: column;
  }

  .content-right .img {
    height: 100%;
    display: flex;
    align-items: center;
  }

  .content-right .content {
    background: white;
    padding: 10px 30px;
    border-radius: 15px;
    margin-top: 20px;
  }

  .text-right {
    font-weight: 500;
  }

  .radius {
    border-radius: 20px;
    overflow: hidden;
    height: 100%;
    display: flex;
  }
</style>
<main class="pay-main row pt-5 justify-content-center">
  <div class="col-md-7">
    <div class="content-pay">
      <div class="row">
        <div class="col-md-6">
          <div class="form-wrap">
            <div class="radius">
              <img src="<?php echo $this->info->get('img_payleft') ?>" width="100%" class="img-fluid" loading="lazy" />
            </div>
            <div class="input-group">
              <input id="pay-code" placeholder="DQ02494" class="form-input" />
              <button id="btnPayment">Thanh toán</button>
              <input id="accountKey" type="hidden" value="<?php echo $this->auth->user_id ?>" />
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="content-right">
            <div class="img">
              <img src="<?php echo $this->info->get('img_payright') ?>" width="200" class="img-fluid" loading="lazy" />
            </div>
            <div class="content">
              <?php $content =  $this->info->get('pay_content');
              $content = str_replace('{CODE}', $this->auth->user_id, $content);
              echo $content;
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<!-- end Main -->