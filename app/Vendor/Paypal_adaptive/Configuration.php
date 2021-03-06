<?php 
class Configuration
{
	// For a full list of configuration parameters refer in wiki page (https://github.com/paypal/sdk-core-php/wiki/Configuring-the-SDK)
	public static function getConfig()
	{
		$config = array(
				// values: 'sandbox' for testing
				//		   'live' for production
                //         'tls' for testing if your server supports TLSv1.2
				"mode" => "sandbox"
                                //"mode" => "live"

                // TLSv1.2 Check: Comment the above line, and switch the mode to tls as shown below
                // "mode" => "tls"
	
				// These values are defaulted in SDK. If you want to override default values, uncomment it and add your value.
				// "http.ConnectionTimeOut" => "5000",
				// "http.Retry" => "2",
			);
		return $config;
	}
	
	// Creates a configuration array containing credentials and other required configuration parameters.
	public static function getAcctAndConfig()
	{
		$config = array(
				// Signature Credential
				/*"acct1.UserName" => "nits.ashis_api1.gmail.com",
				"acct1.Password" => "VLZ9R93DP9TGLA7B",
				"acct1.Signature" => "AyW83mbFb3sy2TNzaMvijLhnQYFtANgDhZZi8PawPbRFvGxDZcVtvzEZ",*/
                                "acct1.UserName" => "nits.suman_twop_api1.gmail.com",
				"acct1.Password" => "7ZC3C7BFBHALXLB2",
				"acct1.Signature" => "AFcWxV21C7fd0v3bYYYRCpSSRl31APx.tgzm4B0c2FcRXq19u.BvkZnI",
				"acct1.AppId" => "APP-80W284485P519543T"
                   
				/*"acct1.UserName" => "payments_api1.errandchampion.com",
				"acct1.Password" => "YNMSEMNDWVC2HSDD",
				"acct1.Signature" => "AiPC9BjkCyDFQXbSkoZcgqH3hpacAXt.TxUdTG0SA9.kVvPwuUExm5fG",
				"acct1.AppId" => "APP-0VC55786UV787374J"*/
				// Sample Certificate Credential
				// "acct1.UserName" => "certuser_biz_api1.paypal.com",
				// "acct1.Password" => "D6JNKKULHN3G5B8A",
				// Certificate path relative to config folder or absolute path in file system
				// "acct1.CertPath" => "cert_key.pem",
				// "acct1.AppId" => "APP-80W284485P519543T"
				);
		
		return array_merge($config, self::getConfig());
	}

}
