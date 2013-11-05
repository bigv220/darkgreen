<?php
/**
 * ��
 */
class chinapay
{

    /**
     * ���캯��
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
     * ����֧������
     * @param array $order ������Ϣ
     * @param array $payment ֧����ʽ��Ϣ

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

//����˽Կ�ļ�, ����ֵ��Ϊ�����̻��ţ�����15λ

        $merid = buildKey(ROOT_PATH . $merkey_file);

        if (!$merid) {

            echo "����˽Կ�ļ�ʧ�ܣ�";

            exit;

        }

        $plain = $merid . $OrdId . $TransAmt . $CuryId . $TransDate . $TransType . $Priv1;
        //�Զ�����ǩ��
        $chkvalue = sign($merid, $OrdId, $TransAmt, $CuryId, $TransDate, $TransType);
        //��һ���ַ�����ǩ��
        $chkvalue = sign($plain);
        if (!$chkvalue) {
            echo "ǩ��ʧ�ܣ�";
            exit;
        }


//        //��������϶�����ϢΪ��ǩ����
//
//      $plain = $MerId . $OrdId . $TransAmt . $CuryId . $TransDate . $TransTime . $TransType. $CountryId . $TimeZone . $DSTFlag . $ExtFlag . $Priv1;
//
//      //����ǩ��ֵ������
//
//      $chkvalue = sign($plain);
//
//        if (!$chkvalue) {
//
//            echo "ǩ��ʧ�ܣ�";
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

        $def_url .= "<input type=submit value='�й���������'>";

        $def_url .= "</form></body>";

        return $def_url;

    }

    /**
     * ��Ӧ����

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
         * ���¼�����Կ��ֵ

         */

        $pubkey = $payment['chinapay_pubkey_file'];

        $PGID = buildKey(ROOT_PATH . $pubkey);

        if (!$PGID) {

            echo "����˽Կ�ļ�ʧ�ܣ�";

            exit;

        }

        $verify = verifyTransResponse($merid, $orderno, $amount, $currencycode, $transdate, $transtype, $status, $checkvalue);

        if (!$verify) {

            echo "��֤ǩ��ʧ�ܣ�";
            exit;

        }

        /* �����Կ�Ƿ���ȷ */

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

*���ض�����תΪ����������

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

*����������תΪ���ض�����

*/

function chinapaysn2ecshopsn($chinapaysn)
{

    if ($chinapaysn) {

        $year = date('Y', time());

        return substr($year, 0, 2) . substr($chinapaysn, 0, 4) . substr($chinapaysn, 9);

    }

}

/*

*��ʽ�����׽��Է�λ��λ��12λ���֡�

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