paymentnepal.tpl{* rus_build_pack dbazhenov *}

{assign var="r_url" value="payment_notification.result?payment=paymentnepal"|fn_url:'C':'http'}
{assign var="p_url" value="payment_notification.return?payment=paymentnepal"|fn_url:'C':'http'}
{assign var="f_url" value="payment_notification.cancel?payment=paymentnepal"|fn_url:'C':'http'}

<div>
    {__("text_paymentnepal_notice", ["[r_url]" => $r_url, "[p_url]" => $p_url, "[f_url]" => $f_url])}
</div> 
<hr>

<div class="control-group">
    <label class="control-label" for="paymentnepalkey">{__("paymentnepal_key")}:</label>
    <div class="controls">
        <input type="text" name="payment_data[processor_params][paymentnepalkey]" id="paymentnepalkey" value="{$processor_params.paymentnepalkey}"  size="60">
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="secretkey">{__("paymentnepal_secret_key")}:</label>
    <div class="controls">
        <input type="text" name="payment_data[processor_params][secretkey]" id="secretkey" value="{$processor_params.secretkey}"  size="60">
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="descr">{__("description")}:</label>
    <div class="controls">
        <input type="text" name="payment_data[processor_params][details]" id="descr" value="{$processor_params.details}"  size="60">
    </div>
</div>
