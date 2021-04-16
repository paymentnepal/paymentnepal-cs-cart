<?php

use Tygh\Registry;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

if (defined('PAYMENT_NOTIFICATION')) {

    if (empty($_REQUEST['order_id']) || empty($_REQUEST['system_income']) || (empty($_REQUEST['check']) && $mode != 'cancel')) {
        die('Access denied');
    }

    $order_id = (int) $_REQUEST['order_id'];
    
    if ($mode == 'result') {
        $order_info = fn_get_order_info($order_id);
        $processor_data = $order_info['payment_method'];  
        if($_REQUEST['test']){
              $in_data = array(  'tid'            =>  $_REQUEST['tid'],
                   'name'           =>  $_REQUEST['name'], 
                   'comment'        =>  $_REQUEST['comment'],
                   'partner_id'     =>  $_REQUEST['partner_id'],
                   'service_id'     =>  $_REQUEST['service_id'],
                   'order_id'       =>  $_REQUEST['order_id'],
                   'type'           =>  $_REQUEST['type'],
                   'partner_income' =>  $_REQUEST['partner_income'],
                   'system_income'  =>  $_REQUEST['system_income'],
                   'test'           =>  $_REQUEST['test']
                ); }
            else {  $in_data = array(  'tid'            =>  $_REQUEST['tid'],
                   'name'           =>  $_REQUEST['name'], 
                   'comment'        =>  $_REQUEST['comment'],
                   'partner_id'     =>  $_REQUEST['partner_id'],
                   'service_id'     =>  $_REQUEST['service_id'],
                   'order_id'       =>  $_REQUEST['order_id'],
                   'type'           =>  $_REQUEST['type'],
                   'partner_income' =>  $_REQUEST['partner_income'],
                   'system_income'  =>  $_REQUEST['system_income']
                );
            
            }
        $crc =  md5(implode('', array_values($in_data)) . $processor_data['processor_params']['secretkey']);

        if ($_REQUEST['check'] == $crc) {
            $pp_response['order_status'] = 'P';
            $pp_response['reason_text'] = __('approved');
        } else {
            $pp_response['order_status'] = 'F';                                    ;
            $pp_response['reason_text'] = __('control_summ_wrong');
        }
        fn_finish_payment($order_id, $pp_response);
        die('OK' . $order_id);

    } elseif ($mode == 'return') {
        $order_info = fn_get_order_info($order_id);
        if ($order_info['status'] == 'O') {
            $pp_response = array();
            $pp_response['order_status'] = 'F';
            $pp_response['reason_text'] = __('merchant_response_was_not_received');
            $pp_response['transaction_id'] = '';
            fn_finish_payment($order_id, $pp_response);
        }
        fn_order_placement_routines('route', $order_id, false);

    } elseif ($mode == 'cancel') {
        $pp_response['order_status'] = 'N';
        $pp_response['reason_text'] = __('text_transaction_cancelled');
        fn_finish_payment($order_id, $pp_response, false);
        fn_order_placement_routines('route', $order_id);
    }

} else {
    $total = fn_rus_pay_format_price($order_info['total'], 'RUB');

    $url = 'https://pay.paymentnepal.com/alba/input/';

    $post_data = array(
        'key' => $processor_data['processor_params']['paymentnepalkey'],
        'cost' => $total,
        'order_id' => $order_id,
        'name' => 'заказ '.$order_id
    );

    fn_create_payment_form($url, $post_data, 'Paymentnepal server');
}

exit;
