<?php

/*�밴������ʵ������������¸�����*/


//˽Կ�ļ�����CHINAPAY�����̻���ʱ��ȡ������Ӧ�޸Ĵ˴����������·������ͬ

define("PRI_KEY", "E:\web\darkgreen\web\key\MerPrK_808080231803147_20130110145059.key");

//��Կ�ļ���ʾ�����Ѿ�����

define("PUB_KEY", "E:\web\darkgreen\web\key\PgPubk.key");

/*��������������Կ�����޸��������ã�Ĭ��Ϊ���Ի���*/

//֧�������ַ(����)

//define("REQ_URL_PAY","http://payment-test.chinapay.com/pay/transget");

//֧�������ַ(����)

define("REQ_URL_PAY", "https://payment.ChinaPay.com/pay/TransGet");

//��ѯ�����ַ(����)

define("REQ_URL_QRY", "http://payment-test.chinapay.com/QueryWeb/processQuery.jsp");

//��ѯ�����ַ(����)

//define("REQ_URL_QRY","http://c**ole.chinapay.com/QueryWeb/processQuery.jsp");

//�˿������ַ(����)

define("REQ_URL_REF", "http://payment-test.chinapay.com/refund/SingleRefund.jsp");

//�˿������ַ(����)

//define("REQ_URL_REF","https://bak.chinapay.com/refund/SingleRefund.jsp");

function getcwdOL()
{

    $total = $_SERVER['PHP_SELF'];

    $file = explode("/", $total);

    $file = $file[sizeof($file) - 1];

    return substr($total, 0, strlen($total) - strlen($file) - 1);

}

function getSiteUrl()
{

    $host = $_SERVER['SERVER_NAME'];

    $port = ($_SERVER['SERVER_PORT'] == "80") ? "" : ":$_SERVER[SERVER_PORT]";

    return "http://" . $host . $port . getcwdOL();

}

function traceLog($file, $log)
{

    $f = fopen($file, 'a');

    if ($f) {

        fwrite($f, date('Y-m-d H:i:s') . " => $log\n");

        fclose($f);

    }

}

//ȡ�ñ�ʾ����װλ��

$site_url = getSiteUrl();

?>