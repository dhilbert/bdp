<?php
include_once('../lib/session.php');
include_once('../lib/dbcon_bdp.php');

$updateDate  = date("Y-m-d H:i:s");




$selestadmin_setting_sql = "select imjang_state from admin_setting ";
$selestadmin_setting__res = mysqli_query($real_sock,$selestadmin_setting_sql);
$admin_Setting_info = mysqli_fetch_array($selestadmin_setting__res);
$imjang_state = $admin_Setting_info['imjang_state'];









//동부터
$region_code_sql = "select * from region_code where regionCode_full-floor(regionCode_full/100000)*100000>0 and 
(LastdealDateforTrade is not null or LastdealDateforChater is not null)
and maplv1 + maplv2 + maplv3 + maplv4 >0 

";
$region_code_res = mysqli_query($real_sock,$region_code_sql);
while($region_code_info = mysqli_fetch_array($region_code_res)){	
	$LastdealDate = max($region_code_info['LastdealDateforTrade'],$region_code_info['LastdealDateforChater']);
	$beforeDay = date("Y-m-d", strtotime($LastdealDate ." -".$admin_Setting_info['imjang_state']." day")); //통계 기준
	$LastdealDateforTrade	= $region_code_info['LastdealDateforTrade'];
	$LastdealDateforChater	= $region_code_info['LastdealDateforChater'];
	

	$c_table_name = "(select * from rawdata_charter_apt where regionCode_full='".$region_code_info['regionCode_full']."' and DealfullDate >= '".$beforeDay."' and Monthlyrent=0) as a";
	$t_table_name = "(select * from rawdata_trade_apt where regionCode_full='".$region_code_info['regionCode_full']."' and DealfullDate >= '".$beforeDay."') as a";
	$charter_sql = "select 

			AVG(a.Deposit) as rentPriceAvgTotal,
			count(a.Deposit) as volumeCharter,
			AVG(a.Deposit/floor(a.AreaforExclusiveUse/3.3)) as unitRentPriceAvgTotal

		from ".$c_table_name."
	";
	$charter_res = mysqli_query($real_sock,$charter_sql);
	$charter_info= mysqli_fetch_array($charter_res);

	

	$trade_sql = "select 
			AVG(a.TransactionAmount) as dealPriceAvgTotal,
			count(a.TransactionAmount) as volumeTrade,
			AVG(a.TransactionAmount/floor(a.AreaforExclusiveUse/3.3)) as unitPriceAvgTotal
		from ".$t_table_name."
	";
	$trade_res = mysqli_query($real_sock,$trade_sql);
	$trade_info= mysqli_fetch_array($trade_res);
	$dealVolumeforTrade		= $trade_info['volumeTrade'];
	$dealVolumeforCharter=  $charter_info['volumeCharter'];
	$volumeTotal = $charter_info['volumeCharter']+$trade_info['volumeTrade'];
	$unitPriceAvgTotal =round($trade_info['unitPriceAvgTotal'],5);
	$unitRentPriceAvgTotal = round($charter_info['unitRentPriceAvgTotal'],5);
	$dealPriceAvgTotal=round($trade_info['dealPriceAvgTotal'],5);
	$rentPriceAvgTotal=round($charter_info['rentPriceAvgTotal'],5);
	$investPriceforapt=round($trade_info['dealPriceAvgTotal'] - $charter_info['rentPriceAvgTotal'],5);
	$investPriceforbil =$trade_info['dealPriceAvgTotal']-$charter_info['rentPriceAvgTotal'];


	$update_sql = "
				update region_code set 
				iconTotal				=(select sum(printCheck) from invest_master where regionCode_full = '".$region_code_info['regionCode_full']."' ),
				unitPriceAvgTotal		='".$unitPriceAvgTotal."',
				unitRentPriceAvgTotal	='".$unitRentPriceAvgTotal."',
				volumeTotal				='".$volumeTotal."',
				dealPriceAvgTotal		='".$dealPriceAvgTotal."',
				rentPriceAvgTotal		='".$rentPriceAvgTotal."',
				updateDate				='".$updateDate."',
				investPriceforbil		=
											(select AVG(investPrice) from invest_master 
											where finderType = 'bil' and regionCode_full = '".$region_code_info['regionCode_full']."' 
											and LastCalDate >= '".$beforeDay."' and investPrice !=0
											) 
											,
				investPriceforapt	    =
											(select AVG(investPrice) from invest_master 
											where finderType = 'apt' and regionCode_full = '".$region_code_info['regionCode_full']."'
																						and LastCalDate >= '".$beforeDay."' and investPrice !=0
											) ,
				rentRateTotal			=
											(select AVG(rentRateTotal) from invest_master 
											where finderType = 'apt' and regionCode_full = '".$region_code_info['regionCode_full']."'
																						and LastCalDate >= '".$beforeDay."' and rentRateTotal !=0
											),

				minInvestpriceforapt		=
											(select LEAST(min(investPrice),min(kbinvestPrice)) from invest_master 
											where finderType = 'apt' and regionCode_full = '".$region_code_info['regionCode_full']."' 
											and LastCalDate >= '".$beforeDay."' and investPrice !=0
											) 
											,


				minInvestpriceforbil		=
											(select LEAST(min(investPrice),min(kbinvestPrice)) from invest_master 
											where finderType = 'bil' and regionCode_full = '".$region_code_info['regionCode_full']."' 
											and LastCalDate >= '".$beforeDay."' and investPrice !=0
											) 
											,


				minInvestpriceforop		=
											(select LEAST(min(investPrice),min(kbinvestPrice)) from invest_master 
											where finderType = 'op' and regionCode_full = '".$region_code_info['regionCode_full']."' 
											and LastCalDate >= '".$beforeDay."' and investPrice !=0
											) 
											,

				minInvestpricefordo		=
											(select LEAST(min(investPrice),min(kbinvestPrice)) from invest_master 
											where finderType = 'do' and regionCode_full = '".$region_code_info['regionCode_full']."' 
											and LastCalDate >= '".$beforeDay."' and investPrice !=0
											) 
											,
				

				LastdealDate			='".$LastdealDate."',";

	


	if($LastdealDateforTrade!=0){	$update_sql = $update_sql."LastdealDateforTrade				='".$LastdealDateforTrade."',";	}
	if($LastdealDateforChater!=0){	$update_sql = $update_sql."LastdealDateforChater				='".$LastdealDateforChater."',";	}
	$update_sql = $update_sql."dealVolumeforTrade		='".$dealVolumeforTrade."',
				dealVolumeforCharter	='".$dealVolumeforCharter."'				
		where idx = ".$region_code_info['idx'].";";
	$update_res = mysqli_query($real_sock,$update_sql);
	
}


// 읍 면 

$region_code_sql = "select * from region_code where (regionName LIKE '%면' or regionName LIKE '%읍') and 
(LastdealDateforTrade is not null or LastdealDateforChater is not null)
and maplv1 + maplv2 + maplv3 + maplv4 >0 


";
$region_code_res = mysqli_query($real_sock,$region_code_sql);
while($region_code_info = mysqli_fetch_array($region_code_res)){	

	$LastdealDate = max($region_code_info['LastdealDateforTrade'],$region_code_info['LastdealDateforChater']);
	$beforeDay = date("Y-m-d", strtotime($LastdealDate ." -".$admin_Setting_info['imjang_state']." day")); //통계 기준
	$LastdealDateforTrade	= $region_code_info['LastdealDateforTrade'];
	$LastdealDateforChater	= $region_code_info['LastdealDateforChater'];
	

	$c_table_name = "(select * from rawdata_charter_apt where myuncheck='".$region_code_info['myuncheck']."' and DealfullDate >= '".$beforeDay."' and Monthlyrent=0) as a";
	$t_table_name = "(select * from rawdata_trade_apt where myuncheck='".$region_code_info['myuncheck']."' and DealfullDate >= '".$beforeDay."' ) as a";
	$charter_sql = "select 

			AVG(a.Deposit) as rentPriceAvgTotal,
			count(a.Deposit) as volumeCharter,
			AVG(a.Deposit/floor(a.AreaforExclusiveUse/3.3)) as unitRentPriceAvgTotal

		from ".$c_table_name."
	";
	$charter_res = mysqli_query($real_sock,$charter_sql);
	$charter_info= mysqli_fetch_array($charter_res);

	

	$trade_sql = "select 
			AVG(a.TransactionAmount) as dealPriceAvgTotal,
			count(a.TransactionAmount) as volumeTrade,
			AVG(a.TransactionAmount/floor(a.AreaforExclusiveUse/3.3)) as unitPriceAvgTotal
		from ".$t_table_name."
	";
	$trade_res = mysqli_query($real_sock,$trade_sql);
	$trade_info= mysqli_fetch_array($trade_res);
	$dealVolumeforTrade		= $trade_info['volumeTrade'];
	$dealVolumeforCharter=  $charter_info['volumeCharter'];
	$volumeTotal = $charter_info['volumeCharter']+$trade_info['volumeTrade'];
	$unitPriceAvgTotal =round($trade_info['unitPriceAvgTotal'],5);
	$unitRentPriceAvgTotal = round($charter_info['unitRentPriceAvgTotal'],5);
	$dealPriceAvgTotal=round($trade_info['dealPriceAvgTotal'],5);
	$rentPriceAvgTotal=round($charter_info['rentPriceAvgTotal'],5);
	$investPriceforapt=round($trade_info['dealPriceAvgTotal'] - $charter_info['rentPriceAvgTotal'],5);
	$investPriceforbil =$trade_info['dealPriceAvgTotal']-$charter_info['rentPriceAvgTotal'];


	$update_sql = "
				update region_code set 
				iconTotal				=(select sum(printCheck) from invest_master where myuncheck = '".$region_code_info['myuncheck']."' ),
				unitPriceAvgTotal		='".$unitPriceAvgTotal."',
				unitRentPriceAvgTotal	='".$unitRentPriceAvgTotal."',
				volumeTotal				='".$volumeTotal."',
				dealPriceAvgTotal		='".$dealPriceAvgTotal."',
				rentPriceAvgTotal		='".$rentPriceAvgTotal."',
				updateDate				='".$updateDate."',
				investPriceforbil		=
											(select AVG(investPrice) from invest_master 
											where finderType = 'bil' and myuncheck = '".$region_code_info['myuncheck']."' 
											and LastCalDate >= '".$beforeDay."' and investPrice !=0
											) 
											,
				investPriceforapt	    =
											(select AVG(investPrice) from invest_master 
											where finderType = 'apt' and myuncheck = '".$region_code_info['myuncheck']."'
																						and LastCalDate >= '".$beforeDay."' and investPrice !=0
											) ,
				rentRateTotal			=
											(select AVG(rentRateTotal) from invest_master 
											where finderType = 'apt' and myuncheck = '".$region_code_info['myuncheck']."'
																						and LastCalDate >= '".$beforeDay."' and rentRateTotal !=0
											),


				minInvestpriceforapt		=
												(select LEAST(min(investPrice),min(kbinvestPrice)) from invest_master 
											where finderType = 'apt' and myuncheck = '".$region_code_info['myuncheck']."' 
											and LastCalDate >= '".$beforeDay."' and investPrice !=0
											) 
											,

				minInvestpriceforbil		=
												(select LEAST(min(investPrice),min(kbinvestPrice)) from invest_master 
											where finderType = 'bil' and myuncheck = '".$region_code_info['myuncheck']."' 
											and LastCalDate >= '".$beforeDay."'and investPrice !=0
											) 
											,


				minInvestpricefordo		=
												(select LEAST(min(investPrice),min(kbinvestPrice)) from invest_master 
											where finderType = 'do' and myuncheck = '".$region_code_info['myuncheck']."' 
											and LastCalDate >= '".$beforeDay."'and investPrice !=0
											) 
											,
				minInvestpriceforop		=
												(select LEAST(min(investPrice),min(kbinvestPrice)) from invest_master 
											where finderType = 'op' and myuncheck = '".$region_code_info['myuncheck']."' 
											and LastCalDate >= '".$beforeDay."'and investPrice !=0
											) 
											,


				LastdealDate			='".$LastdealDate."',";

	


	if($LastdealDateforTrade!=0){	$update_sql = $update_sql."LastdealDateforTrade				='".$LastdealDateforTrade."',";	}
	if($LastdealDateforChater!=0){	$update_sql = $update_sql."LastdealDateforChater				='".$LastdealDateforChater."',";	}
	$update_sql = $update_sql."dealVolumeforTrade		='".$dealVolumeforTrade."',
				dealVolumeforCharter	='".$dealVolumeforCharter."'				
		where idx = ".$region_code_info['idx'].";";
	$update_res = mysqli_query($real_sock,$update_sql);

}





//구

$region_code_sql = "select * from region_code where regionCode_full/100000 = areaCode AND areaCode != stateAreaCode and 
(LastdealDateforTrade is not null or LastdealDateforChater is not null)
and maplv1 + maplv2 + maplv3 + maplv4 >0 


";

$region_code_res = mysqli_query($real_sock,$region_code_sql);
while($region_code_info = mysqli_fetch_array($region_code_res)){	

	$LastdealDate = max($region_code_info['LastdealDateforTrade'],$region_code_info['LastdealDateforChater']);
	$beforeDay = date("Y-m-d", strtotime($LastdealDate ." -".$admin_Setting_info['imjang_state']." day")); //통계 기준
	$LastdealDateforTrade	= $region_code_info['LastdealDateforTrade'];
	$LastdealDateforChater	= $region_code_info['LastdealDateforChater'];
	

	$c_table_name = "(select * from rawdata_charter_apt where areaCode='".$region_code_info['areaCode']."' and DealfullDate >= '".$beforeDay."' and Monthlyrent=0) as a";
	$t_table_name = "(select * from rawdata_trade_apt where areaCode='".$region_code_info['areaCode']."' and DealfullDate >= '".$beforeDay."') as a";
	$charter_sql = "select 

			AVG(a.Deposit) as rentPriceAvgTotal,
			count(a.Deposit) as volumeCharter,
			AVG(a.Deposit/floor(a.AreaforExclusiveUse/3.3)) as unitRentPriceAvgTotal

		from ".$c_table_name."
	";
	$charter_res = mysqli_query($real_sock,$charter_sql);
	$charter_info= mysqli_fetch_array($charter_res);



	$trade_sql = "select 
			AVG(a.TransactionAmount) as dealPriceAvgTotal,
			count(a.TransactionAmount) as volumeTrade,
			AVG(a.TransactionAmount/floor(a.AreaforExclusiveUse/3.3)) as unitPriceAvgTotal
		from ".$t_table_name."
	";
	$trade_res = mysqli_query($real_sock,$trade_sql);
	$trade_info= mysqli_fetch_array($trade_res);
	$dealVolumeforTrade		= $trade_info['volumeTrade'];
	$dealVolumeforCharter=  $charter_info['volumeCharter'];
	$volumeTotal = $charter_info['volumeCharter']+$trade_info['volumeTrade'];
	$unitPriceAvgTotal =round($trade_info['unitPriceAvgTotal'],5);
	$unitRentPriceAvgTotal = round($charter_info['unitRentPriceAvgTotal'],5);
	$dealPriceAvgTotal=round($trade_info['dealPriceAvgTotal'],5);
	$rentPriceAvgTotal=round($charter_info['rentPriceAvgTotal'],5);
	$investPriceforapt=round($trade_info['dealPriceAvgTotal'] - $charter_info['rentPriceAvgTotal'],5);
	$investPriceforbil =$trade_info['dealPriceAvgTotal']-$charter_info['rentPriceAvgTotal'];



	$update_sql = "
				update region_code set 
				iconTotal				=(select sum(printCheck) from invest_master where areaCode = '".$region_code_info['areaCode']."' ),
				unitPriceAvgTotal		='".$unitPriceAvgTotal."',
				unitRentPriceAvgTotal	='".$unitRentPriceAvgTotal."',
				volumeTotal				='".$volumeTotal."',
				dealPriceAvgTotal		='".$dealPriceAvgTotal."',
				rentPriceAvgTotal		='".$rentPriceAvgTotal."',
				updateDate				='".$updateDate."',
				investPriceforbil		=
											(select AVG(investPrice) from invest_master 
											where finderType = 'bil' and areaCode = '".$region_code_info['areaCode']."' 
											and LastCalDate >= '".$beforeDay."' and investPrice !=0
											) 
											,
				investPriceforapt	    =
											(select AVG(investPrice) from invest_master 
											where finderType = 'apt' and areaCode = '".$region_code_info['areaCode']."'
																						and LastCalDate >= '".$beforeDay."' and investPrice !=0
											) ,
				rentRateTotal			=
											(select AVG(rentRateTotal) from invest_master 
											where finderType = 'apt' and areaCode = '".$region_code_info['areaCode']."'
																						and LastCalDate >= '".$beforeDay."' and rentRateTotal !=0
											),

				minInvestpriceforapt		=
												(select LEAST(min(investPrice),min(kbinvestPrice)) from invest_master 
											where finderType = 'apt' and areaCode = '".$region_code_info['areaCode']."' 
											and LastCalDate >= '".$beforeDay."' and investPrice !=0
											) 
											,


				minInvestpriceforbil		=
												(select LEAST(min(investPrice),min(kbinvestPrice)) from invest_master 
											where finderType = 'bil' and areaCode = '".$region_code_info['areaCode']."' 
											and LastCalDate >= '".$beforeDay."' and investPrice !=0
											) 
											,

				minInvestpriceforop		=
												(select LEAST(min(investPrice),min(kbinvestPrice)) from invest_master 
											where finderType = 'op' and areaCode = '".$region_code_info['areaCode']."' 
											and LastCalDate >= '".$beforeDay."' and investPrice !=0
											) 
											,

				minInvestpricefordo		=
												(select LEAST(min(investPrice),min(kbinvestPrice)) from invest_master 
											where finderType = 'do' and areaCode = '".$region_code_info['areaCode']."' 
											and LastCalDate >= '".$beforeDay."' and investPrice !=0
											) 
											,
				LastdealDate			='".$LastdealDate."',";

	


	if($LastdealDateforTrade!=0){	$update_sql = $update_sql."LastdealDateforTrade				='".$LastdealDateforTrade."',";	}
	if($LastdealDateforChater!=0){	$update_sql = $update_sql."LastdealDateforChater				='".$LastdealDateforChater."',";	}
	$update_sql = $update_sql."dealVolumeforTrade		='".$dealVolumeforTrade."',
				dealVolumeforCharter	='".$dealVolumeforCharter."'				
		where idx = ".$region_code_info['idx'].";";
	$update_res = mysqli_query($real_sock,$update_sql);

}





//작은시

$region_code_sql = "select * from region_code where 
regionName LIKE '%시' AND areaCode != stateAreaCode and 
(LastdealDateforTrade is not null or LastdealDateforChater is not null)
and maplv1 + maplv2 + maplv3 + maplv4 >0 


";
$region_code_res = mysqli_query($real_sock,$region_code_sql);
while($region_code_info = mysqli_fetch_array($region_code_res)){	

	$LastdealDate = max($region_code_info['LastdealDateforTrade'],$region_code_info['LastdealDateforChater']);
	$beforeDay = date("Y-m-d", strtotime($LastdealDate ." -".$admin_Setting_info['imjang_state']." day")); //통계 기준
	$LastdealDateforTrade	= $region_code_info['LastdealDateforTrade'];
	$LastdealDateforChater	= $region_code_info['LastdealDateforChater'];
	

	$c_table_name = "(select * from rawdata_charter_apt where sicheck='".$region_code_info['sicheck']."' and DealfullDate >= '".$beforeDay."' and Monthlyrent=0) as a";
	$t_table_name = "(select * from rawdata_trade_apt where sicheck='".$region_code_info['sicheck']."' and DealfullDate >= '".$beforeDay."') as a";
	$charter_sql = "select 

			AVG(a.Deposit) as rentPriceAvgTotal,
			count(a.Deposit) as volumeCharter,
			AVG(a.Deposit/floor(a.AreaforExclusiveUse/3.3)) as unitRentPriceAvgTotal

		from ".$c_table_name."
	";
	$charter_res = mysqli_query($real_sock,$charter_sql);
	$charter_info= mysqli_fetch_array($charter_res);



	$trade_sql = "select 
			AVG(a.TransactionAmount) as dealPriceAvgTotal,
			count(a.TransactionAmount) as volumeTrade,
			AVG(a.TransactionAmount/floor(a.AreaforExclusiveUse/3.3)) as unitPriceAvgTotal
		from ".$t_table_name."
	";
	$trade_res = mysqli_query($real_sock,$trade_sql);
	$trade_info= mysqli_fetch_array($trade_res);
	$dealVolumeforTrade		= $trade_info['volumeTrade'];
	$dealVolumeforCharter=  $charter_info['volumeCharter'];
	$volumeTotal = $charter_info['volumeCharter']+$trade_info['volumeTrade'];
	$unitPriceAvgTotal =round($trade_info['unitPriceAvgTotal'],5);
	$unitRentPriceAvgTotal = round($charter_info['unitRentPriceAvgTotal'],5);
	$dealPriceAvgTotal=round($trade_info['dealPriceAvgTotal'],5);
	$rentPriceAvgTotal=round($charter_info['rentPriceAvgTotal'],5);
	$investPriceforapt=round($trade_info['dealPriceAvgTotal'] - $charter_info['rentPriceAvgTotal'],5);
	$investPriceforbil =$trade_info['dealPriceAvgTotal']-$charter_info['rentPriceAvgTotal'];


	$update_sql = "
				update region_code set 
				iconTotal				=(select sum(printCheck) from invest_master where sicheck = '".$region_code_info['sicheck']."' ),
				unitPriceAvgTotal		='".$unitPriceAvgTotal."',
				unitRentPriceAvgTotal	='".$unitRentPriceAvgTotal."',
				volumeTotal				='".$volumeTotal."',
				dealPriceAvgTotal		='".$dealPriceAvgTotal."',
				rentPriceAvgTotal		='".$rentPriceAvgTotal."',
				updateDate				='".$updateDate."',
				investPriceforbil		=
											(select AVG(investPrice) from invest_master 
											where finderType = 'bil' and sicheck = '".$region_code_info['sicheck']."' 
											and LastCalDate >= '".$beforeDay."' and investPrice !=0
											) 
											,
				investPriceforapt	    =
											(select AVG(investPrice) from invest_master 
											where finderType = 'apt' and sicheck = '".$region_code_info['sicheck']."'
																						and LastCalDate >= '".$beforeDay."' and investPrice !=0
											) ,
				rentRateTotal			=
											(select AVG(rentRateTotal) from invest_master 
											where finderType = 'apt' and sicheck = '".$region_code_info['sicheck']."'
																						and LastCalDate >= '".$beforeDay."' and rentRateTotal !=0
											),

				minInvestpriceforapt		=
												(select LEAST(min(investPrice),min(kbinvestPrice)) from invest_master 
											where finderType = 'apt' and sicheck = '".$region_code_info['sicheck']."' 
											and LastCalDate >= '".$beforeDay."' and investPrice !=0
											) 
											,


				minInvestpriceforbil		=
												(select LEAST(min(investPrice),min(kbinvestPrice)) from invest_master 
											where finderType = 'bil' and sicheck = '".$region_code_info['sicheck']."' 
											and LastCalDate >= '".$beforeDay."' and investPrice !=0
											) 
											,
				minInvestpricefordo		=
												(select LEAST(min(investPrice),min(kbinvestPrice)) from invest_master 
											where finderType = 'do' and sicheck = '".$region_code_info['sicheck']."' 
											and LastCalDate >= '".$beforeDay."' and investPrice !=0
											) 
											,
				minInvestpriceforop		=
	(select LEAST(min(investPrice),min(kbinvestPrice)) from invest_master 
											where finderType = 'op' and sicheck = '".$region_code_info['sicheck']."' 
											and LastCalDate >= '".$beforeDay."' and investPrice !=0
											) 
											,


				LastdealDate			='".$LastdealDate."',";

	


	if($LastdealDateforTrade!=0){	$update_sql = $update_sql."LastdealDateforTrade				='".$LastdealDateforTrade."',";	}
	if($LastdealDateforChater!=0){	$update_sql = $update_sql."LastdealDateforChater				='".$LastdealDateforChater."',";	}
	$update_sql = $update_sql."dealVolumeforTrade		='".$dealVolumeforTrade."',
				dealVolumeforCharter	='".$dealVolumeforCharter."'				
		where idx = ".$region_code_info['idx'].";";
	$update_res = mysqli_query($real_sock,$update_sql);




}





//큰시

$region_code_sql = "select * from region_code where 
areaCode = stateAreaCode and 
(LastdealDateforTrade is not null or LastdealDateforChater is not null)
and maplv1 + maplv2 + maplv3 + maplv4 >0
AND regionCode_full/100000 = stateAreaCode 
";
$region_code_res = mysqli_query($real_sock,$region_code_sql);
while($region_code_info = mysqli_fetch_array($region_code_res)){	

	$LastdealDate = max($region_code_info['LastdealDateforTrade'],$region_code_info['LastdealDateforChater']);
	$beforeDay = date("Y-m-d", strtotime($LastdealDate ." -".$admin_Setting_info['imjang_state']." day")); //통계 기준
	$LastdealDateforTrade	= $region_code_info['LastdealDateforTrade'];
	$LastdealDateforChater	= $region_code_info['LastdealDateforChater'];
	

	$c_table_name = "(select * from rawdata_charter_apt where stateAreaCode='".$region_code_info['stateAreaCode']."' and DealfullDate >= '".$beforeDay."' and Monthlyrent=0) as a";
	$t_table_name = "(select * from rawdata_trade_apt where stateAreaCode='".$region_code_info['stateAreaCode']."' and DealfullDate >= '".$beforeDay."') as a";
	$charter_sql = "select 

			AVG(a.Deposit) as rentPriceAvgTotal,
			count(a.Deposit) as volumeCharter,
			AVG(a.Deposit/floor(a.AreaforExclusiveUse/3.3)) as unitRentPriceAvgTotal

		from ".$c_table_name."
	";
	$charter_res = mysqli_query($real_sock,$charter_sql);
	$charter_info= mysqli_fetch_array($charter_res);


	$trade_sql = "select 
			AVG(a.TransactionAmount) as dealPriceAvgTotal,
			count(a.TransactionAmount) as volumeTrade,
			AVG(a.TransactionAmount/floor(a.AreaforExclusiveUse/3.3)) as unitPriceAvgTotal
		from ".$t_table_name."
	";
	$trade_res = mysqli_query($real_sock,$trade_sql);
	$trade_info= mysqli_fetch_array($trade_res);
	$dealVolumeforTrade		= $trade_info['volumeTrade'];
	$dealVolumeforCharter=  $charter_info['volumeCharter'];
	$volumeTotal = $charter_info['volumeCharter']+$trade_info['volumeTrade'];
	$unitPriceAvgTotal =round($trade_info['unitPriceAvgTotal'],5);
	$unitRentPriceAvgTotal = round($charter_info['unitRentPriceAvgTotal'],5);
	$dealPriceAvgTotal=round($trade_info['dealPriceAvgTotal'],5);
	$rentPriceAvgTotal=round($charter_info['rentPriceAvgTotal'],5);
	$investPriceforapt=round($trade_info['dealPriceAvgTotal'] - $charter_info['rentPriceAvgTotal'],5);
	$investPriceforbil =$trade_info['dealPriceAvgTotal']-$charter_info['rentPriceAvgTotal'];




	$update_sql = "
				update region_code set 
				iconTotal				=(select sum(printCheck) from invest_master where stateAreaCode = '".$region_code_info['stateAreaCode']."' ),
				unitPriceAvgTotal		='".$unitPriceAvgTotal."',
				unitRentPriceAvgTotal	='".$unitRentPriceAvgTotal."',
				volumeTotal				='".$volumeTotal."',
				dealPriceAvgTotal		='".$dealPriceAvgTotal."',
				rentPriceAvgTotal		='".$rentPriceAvgTotal."',
				updateDate				='".$updateDate."',
				investPriceforbil		=
											(select AVG(investPrice) from invest_master 
											where finderType = 'bil' and stateAreaCode = '".$region_code_info['stateAreaCode']."' 
											and LastCalDate >= '".$beforeDay."' and investPrice !=0
											) 
											,
				investPriceforapt	    =
											(select AVG(investPrice) from invest_master 
											where finderType = 'apt' and stateAreaCode = '".$region_code_info['stateAreaCode']."'
																						and LastCalDate >= '".$beforeDay."' and investPrice !=0
											) ,
				rentRateTotal			=
											(select AVG(rentRateTotal) from invest_master 
											where finderType = 'apt' and stateAreaCode = '".$region_code_info['stateAreaCode']."'
																						and LastCalDate >= '".$beforeDay."' and rentRateTotal !=0
											),



				minInvestpriceforbil		=
												(select LEAST(min(investPrice),min(kbinvestPrice)) from invest_master 
											where finderType = 'bil' and stateAreaCode = '".$region_code_info['stateAreaCode']."' 
											and LastCalDate >= '".$beforeDay."' and investPrice !=0
											) 
											,

				minInvestpriceforapt		=
												(select LEAST(min(investPrice),min(kbinvestPrice)) from invest_master 
											where finderType = 'apt' and stateAreaCode = '".$region_code_info['stateAreaCode']."' 
											and LastCalDate >= '".$beforeDay."' and investPrice !=0
											) 
											,

				minInvestpricefordo		=
												(select LEAST(min(investPrice),min(kbinvestPrice)) from invest_master 
											where finderType = 'do' and stateAreaCode = '".$region_code_info['stateAreaCode']."' 
											and LastCalDate >= '".$beforeDay."' and investPrice !=0
											) 
											,
				minInvestpriceforop		=
												(select LEAST(min(investPrice),min(kbinvestPrice)) from invest_master 
											where finderType = 'op' and stateAreaCode = '".$region_code_info['stateAreaCode']."' 
											and LastCalDate >= '".$beforeDay."' and investPrice !=0
											) 
											,

				LastdealDate			='".$LastdealDate."',";

	


	if($LastdealDateforTrade!=0){	$update_sql = $update_sql."LastdealDateforTrade				='".$LastdealDateforTrade."',";	}
	if($LastdealDateforChater!=0){	$update_sql = $update_sql."LastdealDateforChater				='".$LastdealDateforChater."',";	}
	$update_sql = $update_sql."dealVolumeforTrade		='".$dealVolumeforTrade."',
				dealVolumeforCharter	='".$dealVolumeforCharter."'				
		where idx = ".$region_code_info['idx'].";";
	$update_res = mysqli_query($real_sock,$update_sql);

	

}




$update_sql = "TRUNCATE region_code_iconcount;";
$update_res = mysqli_query($real_sock,$update_sql);







?>


 <p> <p> <p>
해당 페이지에서 작업 <p>
1.동통계  <br>


<br><p><br>
다음 버튼 클릭 해서 다음 작업 진행해야 함. 
<br><p><br>

<a href = '/BDP_ADMIN/cal_api_0/step5_cal_makedong_proc_3.php' >다음</a>
