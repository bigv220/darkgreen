<?php
/**
 * 类
 */
class chinapay
{

    /**
     * 构造函数
     * @access public
     * @param
     * @return void
     */

    function chinapay()
    {

    }

    function __construct()

    {

        $this->chinapay();

    }

    /**
     * 生成支付代码
     * @param array $order 订单信息
     * @param array $payment 支付方式信息

     */

    function get_code($order, $payment)
    {

        $MerId = trim($payment['chinapay_account']);

        //$MerId = '808080231803147';

        $OrdId = $order['order_sn'];

        $TransAmt = formatamount($order['order_amount']);

        $TransTime = date('His', time());

        $CuryId = '156';

        $CountryId = "0081";

        $TransDate = date('Ymd', time());

        $TransType = '0001';

        $Version = '20070129';

        //$GateId = '0001';

        $TimeZone = "+07";

        $DSTFlag = "1";

        $ExtFlag = "00";

        $data_vreturnurl = $payment['return_url'];

        $Priv1 = $payment['priv1'];

        $Priv2 = $payment['priv2'];

        $merkey_file = trim($payment['chinapay_merkey_file']);

//导入私钥文件, 返回值即为您的商户号，长度15位

        $merid = buildKey(ROOT_PATH . $merkey_file);

        if (!$merid) {

            echo "导入私钥文件失败！";

            exit;

        }

        $plain = $merid . $OrdId . $TransAmt . $CuryId . $TransDate . $TransType . $Priv1;
        //对订单的签名
        $chkvalue = sign($merid, $OrdId, $TransAmt, $CuryId, $TransDate, $TransType);
        //对一段字符串的签名
        $chkvalue = sign($plain);
        if (!$chkvalue) {
            echo "签名失败！";
            exit;
        }


//        //按次序组合订单信息为待签名串
//
//      $plain = $MerId . $OrdId . $TransAmt . $CuryId . $TransDate . $TransTime . $TransType. $CountryId . $TimeZone . $DSTFlag . $ExtFlag . $Priv1;
//
//      //生成签名值，必填
//
//      $chkvalue = sign($plain);
//
//        if (!$chkvalue) {
//
//            echo "签名失败！";
//
//            exit;
//
//        }

        $def_url = "<body onLoad='javascript:document.E_FORM.submit()'><form name='E_FORM' style='text-align:center;' method=post action='" . REQ_URL_PAY . "'>";

        $def_url .= "<input type=HIDDEN name='MerId' value='" . $MerId . "'/>";

        $def_url .= "<input type=HIDDEN name='OrdId' value='" . $OrdId . "'>";

        $def_url .= "<input type=HIDDEN name='TransAmt' value='" . $TransAmt . "'>";

        $def_url .= "<input type=HIDDEN name='CuryId' value='" . $CuryId . "'>";

        $def_url .= "<input type=HIDDEN name='CountryId' value='" . $CountryId . "'>";

        $def_url .= "<input type=HIDDEN name='TransDate' value='" . $TransDate . "'>";

        $def_url .= "<input type=HIDDEN name='TransType' value='" . $TransType . "'>";

        $def_url .= "<input type=HIDDEN name='Version' value='" . $Version . "'>";

        $def_url .= "<input type=HIDDEN name='BgRetUrl' value='" . $data_vreturnurl . "'>";

        $def_url .= "<input type=HIDDEN name='PageRetUrl' value='" . $data_vreturnurl . "'>";

        $def_url .= "<input type=HIDDEN name='GateId' value='" . $GateId . "'>";

        $def_url .= "<input type=hidden name='Priv1' value='" . $Priv1 . "'>";

        $def_url .= "<input type=hidden name='TimeZone' value='" . $TimeZone . "'>";

        $def_url .= "<input type=hidden name='TransTime' value='" . $TransTime . "'>";



        $def_url .= "<input type=hidden name='Priv2' value='" . $Priv2 . "'>";

        $def_url .= "<input type=HIDDEN name='ChkValue' value='" . $chkvalue . "'>";

        $def_url .= "<input type=submit value='中国银联在线'>";

        $def_url .= "</form></body>";

        return $def_url;

    }

    /**
     * 响应操作

     */

    function respond($payment)

    {

//order_paid($v_oid);

//return true;


        $merid = trim($_POST['merid']);

        $orderno = trim($_POST['orderno']);

        $transdate = trim($_POST['transdate']);

        $amount = trim($_POST['amount']);

        $currencycode = trim($_POST['currencycode']);

        $transtype = trim($_POST['transtype']);

        $status = trim($_POST['status']);

        $checkvalue = trim($_POST['checkvalue']);

        $v_gateid = trim($_POST['GateId']);

        $v_Priv1 = trim($_POST['Priv1']);

        /**
         * 重新计算密钥的值

         */

        $pubkey = $payment['chinapay_pubkey_file'];

        $PGID = buildKey(ROOT_PATH . $pubkey);

        if (!$PGID) {

            echo "导入私钥文件失败！";

            exit;

        }

        $verify = verifyTransResponse($merid, $orderno, $amount, $currencycode, $transdate, $transtype, $status, $checkvalue);

        if (!$verify) {

            echo "验证签名失败！";
            exit;

        }

        /* 检查秘钥是否正确 */

        if ($status == '1001') {
	    if (isset($payment['id']) && $payment['id'] > 0)
                return true;

            $v_ordesn = chinapaysn2ecshopsn($orderno);

            $order_id = get_order_id_by_sn($v_ordesn);

            return $order_id;

        } else {

            return false;

        }

    }

}

/*

*本地订单号转为银联订单号

*/

function ecshopsn2chinapaysn($order_sn, $vid)
{

    if ($order_sn && $vid) {

        $sub_vid = substr($vid, 10, 5);

        $sub_start = substr($order_sn, 2, 4);

        $sub_end = substr($order_sn, 6);

        $temp = $pay_id;

        return $sub_start . $sub_vid . $sub_end;

    }

}

/*

*银联订单号转为本地订单号

*/

function chinapaysn2ecshopsn($chinapaysn)
{

    if ($chinapaysn) {

        $year = date('Y', time());

        return substr($year, 0, 2) . substr($chinapaysn, 0, 4) . substr($chinapaysn, 9);

    }

}

/*

*格式化交易金额，以分位单位的12位数字。

*/

function formatamount($amount)
{

    if ($amount) {

        if (!strstr($amount, ".")) {

            $amount = $amount . ".00";

        }

        $amount = str_replace(".", "", $amount);

        $temp = $amount;

        for ($i = 0; $i < 12 - strlen($amount); $i++) {

            $temp = "0" . $temp;

        }

        return $temp;

    }

}