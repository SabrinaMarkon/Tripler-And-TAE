<?php
### Copyright 2012 SABRINA MARKON PearlsOfWealth.com Sunshinehosting.net PERFECT MONEY CALLBACK SYSTEM. Copying without license from Sabrina Markon (50.00 one time per cpanel account fully installed)
### is prohibited.
### Theft of my work will result in your host and their data center warehouse receiving a DHMC takedown notice for any content and/or a careless remote removal of stolen material (I do not need cpanel
### access to messily delete and hack my own work someone has stolen, obviously)
#######################
include "db.php";
/* Constant below contains md5-hashed alternate passhrase in upper case.
   You can generate it like this:
   strtoupper(md5('your_passphrase'));
   Where `your_passphrase' is Alternate Passphrase you entered
   in your PerfectMoney account.

   !!! WARNING !!!
   We strongly recommend NOT to include plain Alternate Passphrase in
   this script and use its pre-generated hashed version instead (just
   like we did in this scipt below).
   This is the best way to keep it secure. */
$alternate_phrase_hash = strtoupper(md5($adminperfectmoneyalternatepassphrase));
define('ALTERNATE_PHRASE_HASH', $alternate_phrase_hash);

// Path to directory to save logs. Make sure it has write permissions.
#define('PATH_TO_LOG',  '/somewhere/out/of/document_root/');

/*
$string=
      $_POST['PAYMENT_ID'].':'.$_POST['PAYEE_ACCOUNT'].':'.
      $_POST['PAYMENT_AMOUNT'].':'.$_POST['PAYMENT_UNITS'].':'.
      $_POST['PAYMENT_BATCH_NUM'].':'.
      $_POST['PAYER_ACCOUNT'].':'.ALTERNATE_PHRASE_HASH.':'.
      $_POST['TIMESTAMPGMT'];

$hash=strtoupper(md5($string));

if($hash==$_POST['V2_HASH'])
	{
	// proccessing payment if only hash is valid
*/
   /* In section below you must implement comparing of data you recieved
   with data you sent. This means to check if $_POST['PAYMENT_AMOUNT'] is
   particular amount you billed to client and so on. */

   if($_POST['PAYEE_ACCOUNT']==$adminperfectmoney && $_POST['PAYMENT_UNITS']=='USD' && ($_POST['PAYMENT_AMOUNT'] == $_POST['fundamountplusfee'])){

      /* ...insert some code to proccess valid payments here... */

$amount = $_POST['PAYMENT_AMOUNT'];
$txn_id = $_POST['PAYMENT_BATCH_NUM'];
$receiver_email = $_POST['PAYEE_ACCOUNT'];
$payer_email = $_POST['PAYER_ACCOUNT'];
$userid = $_POST['userid'];
$amountwithoutfee = $_POST['amountwithoutfee'];
$fundamountplusfee = $_POST['fundamountplusfee'];
$specialofferid = $_POST["id"];
$item = $_POST['item'];

$query = "select * from members where userid='".$userid."'";
$result = mysql_query ($query) or die (mysql_error());
$numrows = @ mysql_num_rows($result);
if ($numrows == 1) 
{	
$user = mysql_fetch_array($result);
$referid = $user["referid"];
$paypal = $user["paypal_email"];
$payza = $user["payza_email"];
$egopay = $user["egopay_account"];
$perfectmoney = $user["perfectmoney_account"];
$okpay = $user["okpay_account"];
$solidtrustpay = $user["solidtrustpay_account"];
$moneybookers = $user["moneybookers_email"];
$paychoice = "Perfect Money";
$transaction = $txn_id;
$today = date('Y-m-d',strtotime("now"));

if(($item != $sitename." Membership ".$userid) and ($item != $sitename." " . $toplevel . " Membership ".$userid) and ($item != $sitename." One-Time Offer") and ($item != $sitename." Special Offer") and ($item != $sitename." Special Offer Ad Package") and ($item != $sitename." - ".$userid))
	{
	buycommission($user['referid'], $amount);
	$projvcom=0;
	$jvjvcom=0;
	$superjvjvcom=0;
	$prosupercom=0;
	$jvsupercom=0;
	$superjv2supercom=0;
	}

####################################################################################
if($item == $sitename." One-Time Offer") {

$sql = mysql_query("SELECT * FROM oto LIMIT 1");
$oto = mysql_fetch_array($sql);

mysql_query("INSERT INTO transactions VALUES ('id', '".$userid."','Perfect Money payment - OTO','".time()."','$amount')");


				if($oto['points']) mysql_query("UPDATE members SET points=points+".$oto['points']." WHERE userid='".$userid."'");

				if($oto['surfcredits']) mysql_query("UPDATE members SET surfcredits=surfcredits+".$oto['surfcredits']." WHERE userid='".$userid."'");

				if($oto['banner_num'] AND $oto['banner_views']) {

				

					$count = $oto['banner_num'];

					while($count > 0) {

						mysql_query("INSERT INTO `banners` ( `id` , `name` , `bannerurl` , `targeturl` , `userid` , `status` , `shown` , `clicks` , `max` , `added` )VALUES (NULL , '', '', '', '".$userid."', '0', '0', '0', '".$oto['banner_views']."', '0')");

						$count--;

					}

				}
					if($oto['featuredad_num'] AND $oto['featuredad_views']) {
						$count = $oto['featuredad_num'];
						while($count > 0) {
							mysql_query("insert into featuredads (userid,max,purchase) values('$userid','".$oto['featuredad_views']."',NOW())");
							$count--;
							}
						}
				if($oto['button_num'] AND $oto['button_views']) {

			

				$count = $oto['button_num'];

				while($count > 0) {

					mysql_query("INSERT INTO `buttons` ( `id` , `name` , `bannerurl` , `targeturl` , `userid` , `status` , `shown` , `clicks` , `max` , `added` )VALUES (NULL , '', '', '', '".$userid."', '0', '0', '0', '".$oto['button_views']."', '0')");

					$count--;

				}

			}

				if($oto['traffic_num'] AND $oto['traffic_views']) {

				

					$count = $oto['traffic_num'];

					while($count > 0) {

						mysql_query("insert into tlinks (userid,paid) values('$userid','".$oto['traffic_views']."')");

						$count--;

					}

				}

                                                               if($oto['ptc_num'] AND $oto['ptc_views']) {

				

					$count = $oto['ptc_num'];

					while($count > 0) {

						mysql_query("insert into ptcads (userid,paid) values('$userid','".$oto['ptc_views']."')");

						$count--;

					}

				}

                                                               if($oto['hotlink_num'] AND $oto['hotlink_views']) {

					

						$count = $oto['hotlink_num'];

						while($count > 0) {

							mysql_query("insert into hotlinks (userid,max) values('$userid','".$oto['hotlink_views']."')");

							$count--;

						}

					}


				if($oto['login_num'] AND $oto['login_views']) {
					
						$count = $oto['login_num'];
						while($count > 0) {
							mysql_query("insert into loginads (userid,max) values('$userid','".$oto['login_views']."')");
							$count--;
						}
					}
                                                                  if($oto['topnav_num']) {
					
				$count = $oto['topnav_num'];
						while($count > 0) {		
							mysql_query("INSERT INTO `topnav` (`userid` , `date`) VALUES ('".$userid."', '".time()."')");
	
					$count--;
						}
					}

                                                                  if($oto['botnav_num']) {
					
				$count = $oto['botnav_num'];
						while($count > 0) {		
							mysql_query("INSERT INTO `botnav` (`userid` , `date`) VALUES ('".$userid."', '".time()."')");
	
					$count--;
						}
					}
	
				if($oto['solo_num']) {

				

					$count = $oto['solo_num'];

					while($count > 0) {

						mysql_query("INSERT INTO `solos` (`id` ,`userid` ,`approved` ,`subject` ,`adbody` ,`sent` ,`added`) VALUES (NULL , '".$userid."', '0', '', '', '0', '0')");

						$count--;

					}

				}
					if($oto['hheadlinead_num'] AND $oto['hheadlinead_views']) {
						$count = $oto['hheadlinead_num'];
						while($count > 0) {
							mysql_query("insert into hheadlineads (userid,max,purchase) values('$userid','".$oto['hheadlinead_views']."',NOW())");
							$count--;
							}
						}
					if($oto['hheaderad_num'] AND $oto['hheaderad_views']) {
						$count = $oto['hheaderad_num'];
						while($count > 0) {
							mysql_query("insert into hheaderads (userid,max,purchase) values('$userid','".$oto['hheaderad_views']."',NOW())");
							$count--;
							}
						}
				

include "tripler_oto.php";

				if($oto['upgrade_pro']=="1") {
					upgrade_jv($userid);
					include "tripler_jv.php";
					}
					
				if($oto['upgrade_pro']=="2") {
					upgrade_superjv($userid);
					include "tripler_superjv.php";

					}
			
			} elseif($item == $sitename." - ".$userid) {
			$positioncount = $_POST['apc_2'];
			$matrixnumber = $_POST['apc_3'];
			$regularcommissionname = "regularcommission" . $matrixnumber;
			if ($$regularcommissionname > 0)
			{
			$regcommq = "update members set commisson=commission+" . $$regularcommissionname . " where userid=\"$referid\"";
			$regcommr = mysql_query($regcommq);
			}
			include "tripler_add.php";
			$adpackid = $_POST['apc_4'];
			$addquantity = $positioncount;
			include "adpack_add.php";
			} elseif($item == $sitename." Points ".$userid) {

				mysql_query("INSERT INTO transactions VALUES ('id', '".$userid."','Perfect Money payment - 1000 points','".time()."','$amount')");
				

				mysql_query("UPDATE members SET points=points+1000 WHERE userid = '".$userid."'");

			} elseif($item == $sitename." Solo Ad ".$userid) {
				mysql_query("INSERT INTO transactions VALUES ('id', '".$userid."','Perfect Money payment - Solo Ad','".time()."','$amount')");
				
		
					mysql_query("INSERT INTO `solos` (`id` ,`userid` ,`approved` ,`subject` ,`adbody` ,`sent` ,`added`) VALUES (NULL , '".$userid."', '0', '', '', '0', '0')");


			} elseif($item == $sitename." Banner Impressions ".$userid) {
				mysql_query("INSERT INTO transactions VALUES ('id', '".$userid."','Perfect Money payment - Banner Impressions','".time()."','$amount')");
				
				
					mysql_query("INSERT INTO `banners` ( `id` , `name` , `bannerurl` , `targeturl` , `userid` , `status` , `shown` , `clicks` , `max` , `added` )VALUES (NULL , '', '', '', '".$userid."', '0', '0', '0', '1000', '0')");

				
			} elseif($item == $sitename." Button Ad ".$userid) {


				mysql_query("INSERT INTO `buttons` ( `id` , `name` , `bannerurl` , `targeturl` , `userid` , `status` , `shown` , `clicks` , `max` , `added` )VALUES (NULL , '', '', '', '".$userid."', '0', '0', '0', '1000', '0')");
		
	mysql_query("INSERT INTO transactions VALUES ('id', '".$userid."','Perfect Money payment - Button Banner Ad','".time()."','$amount')");



			}  elseif($item == $sitename." Top Navigation Link ".$userid) {
				mysql_query("INSERT INTO transactions VALUES ('id','".$userid."','Perfect Money payment - Top Navigation link','".time()."','$amount')");
				
									mysql_query("INSERT INTO `topnav` ( `userid` , `date`) VALUES ('".$userid."', '".time()."')");
									}  elseif($item == $sitename." Bottom Navigation Link ".$userid) {
				mysql_query("INSERT INTO transactions VALUES ('id','".$userid."','Perfect Money payment - Bottom Navigation link','".time()."','$amount')");
				
									mysql_query("INSERT INTO `botnav` ( `userid` , `date`) VALUES ('".$userid."', '".time()."')");
									}

				
			 elseif($item == $sitename." Solo Footer Ad ".$userid) {



				mysql_query("INSERT INTO transactions VALUES ('id', '".$userid."','Perfect Money payment - ".$quantity." solo footer ad','".time()."','$payment_amount\$')");
				
				while($quantity > 0) {
					mysql_query("insert into footerads (userid,paid) values('$userid','100')");
					$quantity--;
				}
				

			} elseif($item == $sitename." Full Page Login Ad ".$userid) {
			
				$rented = $_POST['rentaldate'];
				mysql_query("insert into fullloginads (userid,rented,purchase) values('$userid','$rented',NOW())");

				mysql_query("INSERT INTO transactions VALUES ('id','".$userid."','Perfect Money payment - Full Page Login Ad $rented','".time()."','$amount')");	
				

			} elseif($item == $sitename." Featured Ad ".$userid) {
			
				$featuredadmaxhits = $_POST['max'];
				mysql_query("insert into featuredads (userid,max,purchase) values('$userid','$featuredadmaxhits',NOW())");

				mysql_query("INSERT INTO transactions VALUES ('id','".$userid."','Perfect Money payment - Featured Ad $featuredadmaxhits Impressions','".time()."','$amount')");	
				

			} elseif($item == $sitename." Hot Headline Ad ".$userid) {
				$hheadlineadmaxhits = $_POST['max'];
				mysql_query("INSERT INTO transactions VALUES ('id','".$userid."','Perfect Money payment - Hot Headline Ad $hheadlineadmaxhits Impressions','".time()."','$amount')");	
				while($quantity > 0) {
					mysql_query("insert into hheadlineads (userid,max,purchase) values('$userid','$hheadlineadmaxhits',NOW())");
					$quantity--;
				}
			} elseif($item == $sitename." Hot Header Ad ".$userid) {
				$hheaderadmaxhits = $_POST['max'];
				mysql_query("INSERT INTO transactions VALUES ('id','".$userid."','Perfect Money payment - Hot Header Ad $hheaderadmaxhits Clicks','".time()."','$amount')");
				while($quantity > 0) {
					mysql_query("insert into hheaderads (userid,max,purchase) values('$userid','$hheaderadmaxhits',NOW())");
					$quantity--;
				}
			} elseif($item == $sitename." Login Ad ".$userid) {
				mysql_query("INSERT INTO transactions VALUES ('id','".$userid."','Perfect Money payment - Login ad','".time()."','$amount')");
				
					mysql_query("insert into loginads (userid,max) values('$userid','1000')");


			} elseif($item == $sitename." Traffic link 50 ".$userid) {
				mysql_query("INSERT INTO transactions VALUES ('id', '".$userid."','Perfect Money payment - Traffic link 50','".time()."','$amount')");
				

					mysql_query("insert into tlinks (userid,paid) values('$userid','50')");

				
			} elseif($item == $sitename." Traffic link 100 ".$userid) {
				mysql_query("INSERT INTO transactions VALUES ('id', '".$userid."','Perfect Money payment - Traffic link 100','".time()."','$amount')");
				

					mysql_query("insert into tlinks (userid,paid) values('$userid','100')");

				

			} elseif($item == $sitename." Traffic link 200 ".$userid) {
				mysql_query("INSERT INTO transactions VALUES ('id', '".$userid."','Perfect Money payment -  Traffic link 200','".time()."','$amount')");
				

					mysql_query("insert into tlinks (userid,paid) values('$userid','200')");

						

			} elseif($item == $sitename." PTC 1 ".$userid) {
				mysql_query("INSERT INTO transactions VALUES ('id', '".$userid."','Perfect Money payment - PTC 50','".time()."','$amount')");
				

					mysql_query("insert into ptcads (userid,paid) values('$userid','50')");

				
			} elseif($item == $sitename." PTC 2 ".$userid) {
				mysql_query("INSERT INTO transactions VALUES ('id', '".$userid."','Perfect Money payment - PTC 100','".time()."','$amount')");
				

					mysql_query("insert into ptcads (userid,paid) values('$userid','100')");

				

			} elseif($item == $sitename." PTC 3 ".$userid) {
				mysql_query("INSERT INTO transactions VALUES ('id', '".$userid."','Perfect Money payment -  PTC 200','".time()."','$amount')");
				

					mysql_query("insert into ptcads (userid,paid) values('$userid','200')");

						

			} elseif($item == $sitename." Hot Link ".$userid) {
				mysql_query("INSERT INTO transactions VALUES ('id','".$userid."','Perfect Money payment - Hot Link','".time()."','$amount')");
				
					mysql_query("insert into hotlinks (userid,max) values('$userid','5000')");		
					
			} elseif($item == $sitename." Hot Link Pack 2 ".$userid) {
				mysql_query("INSERT INTO transactions VALUES ('id','".$userid."','Perfect Money payment - Hot Link 2','".time()."','$amount')");
				
					mysql_query("insert into hotlinks (userid,max) values('$userid','10000')");	

			} elseif($item == $sitename." Hot Link Pack 3 ".$userid) {
				mysql_query("INSERT INTO transactions VALUES ('id','".$userid."','Perfect Money payment - Hot Link 3','".time()."','$amount')");
				
					mysql_query("insert into hotlinks (userid,max) values('$userid','20000')");	

					

			} elseif($item == $sitename." Membership ".$userid) {

				mysql_query("INSERT INTO transactions VALUES ('id', '".$userid."','Perfect Money payment - " . $middlelevel . " Member Upgrade','".time()."','$amount')");
				upgrade_jv($userid);
				include "tripler_jv.php";			

			} elseif($item == $sitename." " . $toplevel . " Membership ".$userid) {

				mysql_query("INSERT INTO transactions VALUES ('id', '".$userid."','Perfect Money payment - " . $toplevel . " Upgrade','".time()."','$amount')");
				upgrade_superjv($userid);
				include "tripler_superjv.php";

			} elseif($item == $sitename." Special Offer") {

				$sql = mysql_query("SELECT * FROM offerpage LIMIT 1");
				$offer = mysql_fetch_array($sql);

mysql_query("INSERT INTO transactions VALUES ('id', '".$userid."','Perfect Money payment - Special Offer','".time()."','$amount')");

				if($offer['points']) mysql_query("UPDATE members SET points=points+".$offer['points']." WHERE userid='".$userid."'");

				if($offer['surfcredits']) mysql_query("UPDATE members SET surfcredits=surfcredits+".$offer['surfcredits']." WHERE userid='".$userid."'");

				if($offer['banner_num'] AND $offer['banner_views']) {

				

					$count = $offer['banner_num'];

					while($count > 0) {

						mysql_query("INSERT INTO `banners` ( `id` , `name` , `bannerurl` , `targeturl` , `userid` , `status` , `shown` , `clicks` , `max` , `added` )VALUES (NULL , '', '', '', '".$userid."', '0', '0', '0', '".$offer['banner_views']."', '0')");

						$count--;

					}

				}

				

				if($offer['button_num'] AND $offer['button_views']) {
					
						$count = $offer['button_num'];
						while($count > 0) {
							mysql_query("INSERT INTO `buttons` ( `id` , `name` , `bannerurl` , `targeturl` , `userid` , `status` , `shown` , `clicks` , `max` , `added` )VALUES (NULL , '', '', '', '".$userid."', '0', '0', '0', '".$offer['button_views']."', '0')");
							$count--;
						}
					} if($offer['traffic_num'] AND $offer['traffic_views']) {

				

					$count = $offer['traffic_num'];

					while($count > 0) {

						mysql_query("insert into tlinks (userid,paid) values('$userid','".$offer['traffic_views']."')");

						$count--;

					}

				}

				if($offer['login_num'] AND $offer['login_views']) {
					
						$count = $offer['login_num'];
						while($count > 0) {
							mysql_query("insert into loginads (userid,max) values('$userid','".$offer['login_views']."')");
							$count--;
						}
					}

				if($offer['hotlink_num'] AND $offer['hotlink_views']) {
					
						$count = $offer['hotlink_num'];
						while($count > 0) {
							mysql_query("INSERT INTO hotlinks (userid,max,purchase) values('$userid','".$offer['hotlink_views']."','".time()."')");
							$count--;
						}
					} if($offer['solo_num']) {

				

					$count = $offer['solo_num'];

					while($count > 0) {

						mysql_query("INSERT INTO `solos` (`id` ,`userid` ,`approved` ,`subject` ,`adbody` ,`sent` ,`added`) VALUES (NULL , '".$userid."', '0', '', '', '0', '0')");

						$count--;

					}

				}
					if($offer['hheadlinead_num'] AND $offer['hheadlinead_views']) {
						$count = $offer['hheadlinead_num'];
						while($count > 0) {
							mysql_query("insert into hheadlineads (userid,max,purchase) values('$userid','".$offer['hheadlinead_views']."',NOW())");
							$count--;
							}
						}
					if($offer['hheaderad_num'] AND $offer['hheaderad_views']) {
						$count = $offer['hheaderad_num'];
						while($count > 0) {
							mysql_query("insert into hheaderads (userid,max,purchase) values('$userid','".$offer['hheaderad_views']."',NOW())");
							$count--;
							}
						}
				
include "tripler_offer.php";

				if($offer['upgrade_pro']=="1") {
					upgrade_jv($userid);
					include "tripler_jv.php";

					}
					
				if($offer['upgrade_pro']=="2") {
					upgrade_superjv($userid);
					include "tripler_superjv.php";

					}
			           if($offer['ptc_num'] AND $offer['ptc_views']) {

				

					$count = $offer['ptc_num'];

					while($count > 0) {

						mysql_query("insert into ptcads (userid,paid) values('$userid','".$offer['ptc_views']."')");

						$count--;

					}

				}

   if($offer['topnav_num']) {
					
				$count = $offer['topnav_num'];
						while($count > 0) {		
							mysql_query("INSERT INTO `topnav` (`userid` , `date`) VALUES ('".$userid."', '".time()."')");
	
					$count--;
						}
					}

                                                                  if($offer['botnav_num']) {
					
				$count = $offer['botnav_num'];
						while($count > 0) {		
							mysql_query("INSERT INTO `botnav` (`userid` , `date`) VALUES ('".$userid."', '".time()."')");
	
					$count--;
						}
					}
			}

		
elseif($item == $sitename." Special Offer Ad Package") {

				$sql = mysql_query("SELECT * FROM offerpage LIMIT 1");
				$offer = mysql_fetch_array($sql);

mysql_query("INSERT INTO transactions VALUES ('id', '".$userid."','Perfect Money payment - Special Offer Ad Package','".time()."','$amount')");
		

				if($offer['points']) mysql_query("UPDATE members SET points=points+".$offer['points']." WHERE userid='".$userid."'");

				if($offer['banner_num'] AND $offer['banner_views']) {

				

					$count = $offer['banner_num'];

					while($count > 0) {

						mysql_query("INSERT INTO `banners` ( `id` , `name` , `bannerurl` , `targeturl` , `userid` , `status` , `shown` , `clicks` , `max` , `added` )VALUES (NULL , '', '', '', '".$userid."', '0', '0', '0', '".$offer['banner_views']."', '0')");

						$count--;

					}

				}

					if($offer['featuredad_num'] AND $offer['featuredad_views']) {
						$count = $offer['featuredad_num'];
						while($count > 0) {
							mysql_query("insert into featuredads (userid,max,purchase) values('$userid','".$offer['featuredad_views']."',NOW())");
							$count--;
							}
						}				

				if($offer['button_num'] AND $offer['button_views']) {
					
						$count = $offer['button_num'];
						while($count > 0) {
							mysql_query("INSERT INTO `buttons` ( `id` , `name` , `bannerurl` , `targeturl` , `userid` , `status` , `shown` , `clicks` , `max` , `added` )VALUES (NULL , '', '', '', '".$userid."', '0', '0', '0', '".$offer['button_views']."', '0')");
							$count--;
						}
					} if($offer['traffic_num'] AND $offer['traffic_views']) {

				

					$count = $offer['traffic_num'];

					while($count > 0) {

						mysql_query("insert into tlinks (userid,paid) values('$userid','".$offer['traffic_views']."')");

						$count--;

					}

				}

				if($offer['login_num'] AND $offer['login_views']) {
					
						$count = $offer['login_num'];
						while($count > 0) {
							mysql_query("insert into loginads (userid,max) values('$userid','".$offer['login_views']."')");
							$count--;
						}
					}

				if($offer['hotlink_num'] AND $offer['hotlink_views']) {
					
						$count = $offer['hotlink_num'];
						while($count > 0) {
							mysql_query("INSERT INTO hotlinks (userid,max,purchase) values('$userid','".$offer['hotlink_views']."','".time()."')");
							$count--;
						}
					} if($offer['solo_num']) {

				

					$count = $offer['solo_num'];

					while($count > 0) {

						mysql_query("INSERT INTO `solos` (`id` ,`userid` ,`approved` ,`subject` ,`adbody` ,`sent` ,`added`) VALUES (NULL , '".$userid."', '0', '', '', '0', '0')");

						$count--;

					}

				}

include "tripler_offer.php";

				if($offer['upgrade_pro']=="1") {
					upgrade_jv($userid);
					include "tripler_jv.php";

					}
					
				if($offer['upgrade_pro']=="2") {
					upgrade_superjv($userid);
					include "tripler_superjv.php";

					}
					
					if($offer['ptc_num'] AND $offer['ptc_views']) {


					$count = $offer['ptc_num'];

					while($count > 0) {

						mysql_query("insert into ptcads (userid,paid) values('$userid','".$offer['ptc_views']."')");

						$count--;

					}

				}

   if($offer['topnav_num']) {
					
				$count = $offer['topnav_num'];
						while($count > 0) {		
							mysql_query("INSERT INTO `topnav` (`userid` , `date`) VALUES ('".$userid."', '".time()."')");
	
					$count--;
						}
					}

                                                                  if($offer['botnav_num']) {
					
				$count = $offer['botnav_num'];
						while($count > 0) {		
							mysql_query("INSERT INTO `botnav` (`userid` , `date`) VALUES ('".$userid."', '".time()."')");
	
					$count--;
						}
					}

} 
#############################################################################

} # if ($numrows == 1) 

      // uncomment code below if you want to log successfull payments
      /* $f=fopen(PATH_TO_LOG."good.log", "ab+");
      fwrite($f, date("d.m.Y H:i")."; POST: ".serialize($_POST)."; STRING: $string; HASH: $hash\n");
      fclose($f); */

   }
   else
	{ // you can also save invalid payments for debug purposes

      // uncomment code below if you want to log requests with fake data
      /* $f=fopen(PATH_TO_LOG."bad.log", "ab+");
      fwrite($f, date("d.m.Y H:i")."; REASON: fake data; POST: ".serialize($_POST)."; STRING: $string; HASH: $hash\n");
      fclose($f); */

   }
#}
/*
else
{ // you can also save invalid payments for debug purposes

   // uncomment code below if you want to log requests with bad hash
   /* $f=fopen(PATH_TO_LOG."bad.log", "ab+");
   fwrite($f, date("d.m.Y H:i")."; REASON: bad hash; POST: ".serialize($_POST)."; STRING: $string; HASH: $hash\n");
   fclose($f); */

}
*/
?>