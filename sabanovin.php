<?
/*
  Virtual Freer
  http://freer.ir/virtual

  Copyright (c) 2011 Mohammad Hossein Beyram, freer.ir

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License v3 (http://www.gnu.org/licenses/gpl-3.0.html)
  as published by the Free Software Foundation.
*/
	//-- اطلاعات کلی پلاگین
	$pluginData[sabanovin][type] = 'notify';
	$pluginData[sabanovin][name] = 'پیامک محصول توسط sabanovin';
	$pluginData[sabanovin][uniq] = 'sabanovin';
	$pluginData[sabanovin][description] = 'ارسال اطلاعات خرید به موبایل کاربر';
	$pluginData[sabanovin][note] = 'برای تهیه پنل پیامک به سایت <a href="http://sabanovin.com" style="color:#FF7200">صبا نوین</a> مراجعه کنید.';
	$pluginData[sabanovin][author][name] = 'Ahmad';
	$pluginData[sabanovin][author][url] = 'www.sabanovin.com';
	$pluginData[sabanovin][author][email] = 'Ahmad@rajabi.us';

	//-- فیلدهای تنظیمات پلاگین
	$pluginData[sabanovin][field][config][1][title] = 'شماره درگاه';
	$pluginData[sabanovin][field][config][1][name] = 'username';
	$pluginData[sabanovin][field][config][3][title] = 'کلید API';
	$pluginData[sabanovin][field][config][3][name] = 'apiid';

	//-- تابع پردازش و ارسال اطلاعات
	function notify__sabanovin($data,$output,$payment,$product,$cards)
	{
		global $db,$smarty;
		$username = $data[username];
		$api      = $data[apiid];
		if ($output[status] == 1 AND $payment[payment_mobile] AND $cards)
		{
			$sms_text='';
			foreach($cards as $card)
			{
				$sms_text = 'نوع:' . $product[product_title] . "\r\n";
				if($product[product_first_field_title]!="")
					$sms_text .= $product[product_first_field_title] . ': ' . $card[card_first_field];
				if($card[card_second_field]!="")
					$sms_text .= "\r\n" . $product[product_second_field_title] . ': ' . $card[card_second_field];
				if($card[card_third_field]!="")
					$sms_text .=  "\r\n" . $product[product_third_field_title] . ': ' . $card[card_third_field];
                $cnum = $payment[payment_mobile];
				$url      = "http://api.sabanovin.com/v1/";
				$result = @file_get_contents($url . $api . 
				'/sms/send.json?gateway=' . $username .
				'&to=' . $cnum . '&text=' . $sms_text);
				$sms_text='';
			}
		}
	}
