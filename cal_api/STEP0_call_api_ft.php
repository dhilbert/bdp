<?php

//국토부 불러오는 API 





///// 전세 거래 		
		
			//아파트 전세 거래
				$api_url = 'http://openapi.molit.go.kr:8081/OpenAPI_ToolInstallPackage/service/rest/RTMSOBJSvc/getRTMSDataSvcAptRent';
				$url =$api_url."?serviceKey=".$serviceKey."&LAWD_CD=".$LAWD_CD."&DEAL_YMD=".$DEAL_YMD."";
				$response = file_get_contents($url);
				$object = simplexml_load_string($response);
				$data_arr = $object->body[0]->items[0]; 
				$sql = "INSERT INTO rawdata_charter_apt (BuildYear,AreaforExclusiveUse,DealYear,Courtbuilding,deposit,DealMonth,Monthlyrent,Dealday,AreaCode,buildingName,buildingNumber,buildingfloor,UpdateDate)VALUES ";
				$temp_sql = $sql;
				$n = 0;
				for($i =0 ; $i < count($data_arr) ;$i++ ){
					$n += 1;
					$temps_array = $data_arr->item[$i];
					$BuildYear = $temps_array->건축년도;
					$AreaforExclusiveUse = $temps_array->전용면적;
					$DealYear = $temps_array->년;
					$Courtbuilding = $temps_array->법정동;
					$deposit = $temps_array->보증금액;
					$DealMonth = $temps_array->월;
					$Monthlyrent = $temps_array->월세금액;
					$Dealday = $temps_array->일;
					$AreaCode = $temps_array->지역코드;
					$buildingName = $temps_array->아파트;
					$buildingNumber = $temps_array->지번;
					$buildingfloor = $temps_array->층;
				


					$deposit = hd_text_to_int($deposit);
					$Monthlyrent= hd_text_to_int($Monthlyrent);

					$sql = $sql."('".$BuildYear."',
								'".$AreaforExclusiveUse."',
								'".$DealYear."',
								'".trim($Courtbuilding)."',
								'".$deposit."',
								'".$DealMonth."',
								'".$Monthlyrent."',
								'".$Dealday."',
								'".$AreaCode."',
								'".$buildingName."',
								'".$buildingNumber."',
								'".$buildingfloor."',
								'".$today_time."'
								),";
					if($n==$value_count){$n=0;$sql=substr($sql, 0, -1);$res = mysqli_query($real_sock,$sql);$sql = $temp_sql;}

				}
				$cnt_1 = count($data_arr);
				$sql=substr($sql, 0, -1);
				$res = mysqli_query($real_sock,$sql);
			//아파트 전세 거래 끝

			


			/*
			// 다가구 전세 거래
			$api_url = 'http://openapi.molit.go.kr:8081/OpenAPI_ToolInstallPackage/service/rest/RTMSOBJSvc/getRTMSDataSvcSHRent';
			$url =$api_url."?serviceKey=".$serviceKey."&LAWD_CD=".$LAWD_CD."&DEAL_YMD=".$DEAL_YMD."";
			$response = file_get_contents($url);
			$object = simplexml_load_string($response);
			$data_arr = $object->body[0]->items[0]; 
			$sql = "INSERT INTO rawdata_charter_multifamilyhouse (
							BuildYear,
							Contractarea,
							DealYear,
							Courtbuilding,
							deposit,
							DealMonth,
							Monthlyrent,
							Dealday,
							AreaCode,UpdateDate
			)VALUES ";
			$temp_sql = $sql;
			$n=0;
			for($i =0 ; $i < count($data_arr) ;$i++ ){
				$n += 1;
				$temps_array = $data_arr->item[$i];
				$BuildYear = $temps_array->건축년도;
				$Contractarea = $temps_array->계약면적;
				$DealYear = $temps_array->년;
				$Courtbuilding = $temps_array->법정동;
				$deposit = $temps_array->보증금액;
				$DealMonth = $temps_array->월;
				$Monthlyrent = $temps_array->월세금액;
				$Dealday = $temps_array->일;
				$AreaCode = $temps_array->지역코드;	
					$deposit = hd_text_to_int($deposit);
					$Monthlyrent= hd_text_to_int($Monthlyrent);



				$sql = $sql."(
						'".$BuildYear."',
						'".$Contractarea."',
						'".$DealYear."',
						'".trim($Courtbuilding)."',
						'".$deposit."',
						'".$DealMonth."',
						'".$Monthlyrent."',
						'".$Dealday."',
						'".$AreaCode."',
						'".$today_time."'),";
				if($n==$value_count){$n=0;$sql=substr($sql, 0, -1);
				$res = mysqli_query($real_sock,$sql);$sql = $temp_sql;}
			}
			$sql=substr($sql, 0, -1);
			$res = mysqli_query($real_sock,$sql);
			*/

			// 오피 전세 거래

			$api_url = 'http://openapi.molit.go.kr/OpenAPI_ToolInstallPackage/service/rest/RTMSOBJSvc/getRTMSDataSvcOffiRent';
			$url =$api_url."?serviceKey=".$serviceKey."&LAWD_CD=".$LAWD_CD."&DEAL_YMD=".$DEAL_YMD."";
			$response = file_get_contents($url);
			$object = simplexml_load_string($response);
			$data_arr = $object->body[0]->items[0]; 
			$sql = "INSERT INTO rawdata_charter_op (
							BuildYear,
							DealYear,
							buildingName,
							Courtbuilding,
							deposit,
							DealMonth ,
							Monthlyrent,
							Dealday,
							AreaforExclusiveUse,
							buildingNumber,
							AreaCode,
							buildingfloor,UpdateDate)VALUES ";

			$n=0;
			$temp_sql = $sql;
			for($i =0 ; $i < count($data_arr) ;$i++ ){
				$n+=1;
				$temps_array = $data_arr->item[$i];
				$BuildYear = $temps_array->건축년도;
				$DealYear = $temps_array->년;
				$buildingName = $temps_array->단지;
				$Courtbuilding = $temps_array->법정동;
				$deposit = $temps_array->보증금;
				$DealMonth = $temps_array->월;
				$Monthlyrent = $temps_array->월세;
				$Dealday = $temps_array->일;
				$AreaforExclusiveUse = $temps_array->전용면적;
				$buildingNumber = $temps_array->지번;
				$AreaCode = $temps_array->지역코드;			
				$buildingfloor = $temps_array->층;

				$deposit = hd_text_to_int($deposit);
				$Monthlyrent= hd_text_to_int($Monthlyrent);

				$sql = $sql."('".$BuildYear."',
					'".$DealYear."',
					'".$buildingName."',
					'".trim($Courtbuilding)."',
					'".$deposit."',
					'".$DealMonth."',
					'".$Monthlyrent."',
					'".$Dealday."',
					'".$AreaforExclusiveUse."',
					'".$buildingNumber."',
					'".$AreaCode."',
					'".$buildingfloor."',	
					'".$today_time."'),";

				if($n==$value_count){$n=0;$sql=substr($sql, 0, -1);$res = mysqli_query($real_sock,$sql);$sql = $temp_sql;}
			}

			$sql=substr($sql, 0, -1);

			$res = mysqli_query($real_sock,$sql);



			//연립 전세 거래  rawdata_charter_tenementhouse
			$api_url = 'http://openapi.molit.go.kr:8081/OpenAPI_ToolInstallPackage/service/rest/RTMSOBJSvc/getRTMSDataSvcRHRent';
			$url =$api_url."?serviceKey=".$serviceKey."&LAWD_CD=".$LAWD_CD."&DEAL_YMD=".$DEAL_YMD."";
			$response = file_get_contents($url);
			$object = simplexml_load_string($response);
			$data_arr = $object->body[0]->items[0]; 
			$sql = "INSERT INTO rawdata_charter_tenementhouse (
							BuildYear,
							DealYear,
							Courtbuilding,
							deposit,
							buildingName,
							DealMonth,
							Monthlyrent,
							Dealday,
							AreaforExclusiveUse,
							buildingNumber,
							AreaCode,
							buildingfloor,UpdateDate
							)VALUES ";
						$n=0;
			$temp_sql = $sql;
			for($i =0 ; $i < count($data_arr) ;$i++ ){
				$n+=1;

				$temps_array = $data_arr->item[$i];
				$BuildYear = $temps_array->건축년도;
				$DealYear = $temps_array->년;
				$Courtbuilding = $temps_array->법정동;
				$deposit = $temps_array->보증금액;
				$buildingName = $temps_array->연립다세대;
				$DealMonth = $temps_array->월;
				$Monthlyrent = $temps_array->월세금액;
				$Dealday = $temps_array->일;
				$AreaforExclusiveUse = $temps_array->전용면적;
				$buildingNumber = $temps_array->지번;
				$AreaCode = $temps_array->지역코드;			
				$buildingfloor = $temps_array->층;

				$deposit = hd_text_to_int($deposit);
				$Monthlyrent= hd_text_to_int($Monthlyrent);

				$sql = $sql."
					('".$BuildYear."',
					'".$DealYear."',
					'".trim($Courtbuilding)."',
					'".$deposit."',
					'".$buildingName."',
					'".$DealMonth."',
					'".$Monthlyrent."',
					'".$Dealday."',
					'".$AreaforExclusiveUse."',
					'".$buildingNumber."',
					'".$AreaCode."',
					'".$buildingfloor."',
					'".$today_time."'),";
				if($n==$value_count){$n=0;$sql=substr($sql, 0, -1);$res = mysqli_query($real_sock,$sql);$sql = $temp_sql;}

			}

			$sql=substr($sql, 0, -1);

			$res = mysqli_query($real_sock,$sql);







	
	///// 전세 거래 끝
	/// 매매 거래 불러 오기 
			//아파트 매매 거래  rawdata_trade_apt
			$api_url = 'http://openapi.molit.go.kr:8081/OpenAPI_ToolInstallPackage/service/rest/RTMSOBJSvc/getRTMSDataSvcAptTrade';
			$url =$api_url."?serviceKey=".$serviceKey."&LAWD_CD=".$LAWD_CD."&DEAL_YMD=".$DEAL_YMD."";
			$sql = "INSERT INTO rawdata_trade_apt (
							TransactionAmount,
							BuildYear,
							DealYear,
							Courtbuilding,
							buildingName,
							DealMonth,
							Dealday,
							AreaforExclusiveUse,
							buildingNumber,
							AreaCode,
							buildingfloor,UpdateDate
			)VALUES ";		
			$response = file_get_contents($url);
			$object = simplexml_load_string($response);
			$data_arr = $object->body[0]->items[0]; 
					$n=0;
			$temp_sql = $sql;
			for($i =0 ; $i < count($data_arr) ;$i++ ){
				$n+=1;


				$temps_array = $data_arr->item[$i];

				$TransactionAmount = $temps_array->거래금액;
				$BuildYear = $temps_array->건축년도;
				$DealYear = $temps_array->년;
				$Courtbuilding = $temps_array->법정동;
				$buildingName = $temps_array->아파트;			
				$DealMonth = $temps_array->월;
				$Dealday = $temps_array->일;	
				$AreaforExclusiveUse = $temps_array->전용면적;
				$buildingNumber = $temps_array->지번;
				$AreaCode = $temps_array->지역코드;
				$buildingfloor = $temps_array->층;


				$TransactionAmount = hd_text_to_int($TransactionAmount);
				$sql = $sql."(
						'".$TransactionAmount."',
						'".$BuildYear."',
						'".$DealYear."',
						'".trim($Courtbuilding)."',
						'".$buildingName."',
						'".$DealMonth."',
						'".$Dealday."',
						'".$AreaforExclusiveUse."',
						'".$buildingNumber."',
						'".$AreaCode."',
						'".$buildingfloor."',
								'".$today_time."'),";
				if($n==$value_count){$n=0;$sql=substr($sql, 0, -1);$res = mysqli_query($real_sock,$sql);$sql = $temp_sql;}
			}


			$sql=substr($sql, 0, -1);
			$res = mysqli_query($real_sock,$sql);

	/*
			//단독/다세대 매매  rawdata_trade_apt rawdata_trade_multifamilyhouse
			$api_url = 'http://openapi.molit.go.kr:8081/OpenAPI_ToolInstallPackage/service/rest/RTMSOBJSvc/getRTMSDataSvcSHTrade';
			$url =$api_url."?serviceKey=".$serviceKey."&LAWD_CD=".$LAWD_CD."&DEAL_YMD=".$DEAL_YMD."";
			$response = file_get_contents($url);
			$object = simplexml_load_string($response);
			$data_arr = $object->body[0]->items[0]; 
			$sql = "INSERT INTO rawdata_trade_multifamilyhouse (TransactionAmount, BuildYear, DealYear,landArea,Courtbuilding,AreaforExclusiveUse,DealMonth,Dealday,houseType,AreaCode,UpdateDate)VALUES ";
			$n=0;
			$temp_sql = $sql;
			for($i =0 ; $i < count($data_arr) ;$i++ ){
				$n+=1;


				$temps_array = $data_arr->item[$i];

				$TransactionAmount = $temps_array->거래금액;
				$BuildYear = $temps_array->건축년도;
				$DealYear = $temps_array->년;
				$landArea = $temps_array->대지면적;
				$Courtbuilding = $temps_array->법정동;
				$AreaforExclusiveUse = $temps_array->연면적;
				$DealMonth = $temps_array->월;
				$Dealday = $temps_array->일;	
				$houseType = $temps_array->주택유형;	
				$AreaCode = $temps_array->지역코드;


				$TransactionAmount = hd_text_to_int($TransactionAmount);
				$sql = $sql."
						('".$TransactionAmount."',
						 '".$BuildYear."',
						 '".$DealYear."',
						 '".$landArea."',
						 '".trim($Courtbuilding)."',
						 '".$AreaforExclusiveUse."',
						'".$DealMonth."',
						'".$Dealday."',
						 '".$houseType."',
						 '".$AreaCode."',
								'".$today_time."'),";
				if($n==$value_count){$n=0;$sql=substr($sql, 0, -1);$res = mysqli_query($real_sock,$sql);$sql = $temp_sql;}
			}				

			$sql=substr($sql, 0, -1);
			$res = mysqli_query($real_sock,$sql);

*/

			//rawdata_trade_op 오피 매매
			$api_url = 'http://openapi.molit.go.kr/OpenAPI_ToolInstallPackage/service/rest/RTMSOBJSvc/getRTMSDataSvcOffiTrade';
			$url =$api_url."?serviceKey=".$serviceKey."&LAWD_CD=".$LAWD_CD."&DEAL_YMD=".$DEAL_YMD."";		
			$response = file_get_contents($url);
			$object = simplexml_load_string($response);
			$data_arr = $object->body[0]->items[0]; 
			$sql = "INSERT INTO rawdata_trade_op (TransactionAmount, BuildYear, DealYear,buildingName,Courtbuilding,DealMonth,Dealday,AreaforExclusiveUse,buildingNumber,AreaCode,buildingfloor,UpdateDate)VALUES ";				
						$n=0;
			$temp_sql = $sql;
			for($i =0 ; $i < count($data_arr) ;$i++ ){
				$n+=1;

				$temps_array = $data_arr->item[$i];

				$TransactionAmount = $temps_array->거래금액;
				$BuildYear = $temps_array->건축년도;
				$DealYear = $temps_array->년;
				$buildingName = $temps_array->단지;						
				$Courtbuilding = $temps_array->법정동;			
				$DealMonth = $temps_array->월;
				$Dealday = $temps_array->일;	
				$AreaforExclusiveUse = $temps_array->전용면적;
				$buildingNumber = $temps_array->지번;
				$AreaCode = $temps_array->지역코드;
				$buildingfloor = $temps_array->층;	
				

				$TransactionAmount = hd_text_to_int($TransactionAmount);
				$sql = $sql."(
						'".$TransactionAmount."',
						'".$BuildYear."',
						'".$DealYear."',
						'".$buildingName."',
						'".$Courtbuilding."',
						'".$DealMonth."',
						'".$Dealday."',
						'".$AreaforExclusiveUse."',
						'".$buildingNumber."',
						'".$AreaCode."',
						'".$buildingfloor."',
								'".$today_time."'),";
				if($n==500){$n=0;$sql=substr($sql, 0, -1);$res = mysqli_query($real_sock,$sql);$sql = $temp_sql;}
			}

			$sql=substr($sql, 0, -1);
			$res = mysqli_query($real_sock,$sql);






			//rawdata_trade_tenementhouse 연립 매매
			$api_url = 'http://openapi.molit.go.kr:8081/OpenAPI_ToolInstallPackage/service/rest/RTMSOBJSvc/getRTMSDataSvcRHTrade';
			$url =$api_url."?serviceKey=".$serviceKey."&LAWD_CD=".$LAWD_CD."&DEAL_YMD=".$DEAL_YMD."";

			$response = file_get_contents($url);
			$object = simplexml_load_string($response);
			$data_arr = $object->body[0]->items[0]; 
			$sql = "INSERT INTO rawdata_trade_tenementhouse (TransactionAmount, BuildYear, DealYear,landArea,Courtbuilding,
			buildingName,DealMonth,Dealday,AreaforExclusiveUse,buildingNumber,AreaCode,buildingfloor,UpdateDate)VALUES ";
						$n=0;
			$temp_sql = $sql;
			for($i =0 ; $i < count($data_arr) ;$i++ ){
				$n+=1;

				$temps_array = $data_arr->item[$i];
				$TransactionAmount = $temps_array->거래금액;
				$BuildYear = $temps_array->건축년도;
				$DealYear = $temps_array->년;
				$landArea = $temps_array->대지권면적;
				$Courtbuilding = $temps_array->법정동;			
				$buildingName = $temps_array->연립다세대;						
				$DealMonth = $temps_array->월;
				$Dealday = $temps_array->일;	
				$AreaforExclusiveUse = $temps_array->전용면적;
				$buildingNumber = $temps_array->지번;
				$AreaCode = $temps_array->지역코드;
				$buildingfloor = $temps_array->층;

				$TransactionAmount = hd_text_to_int($TransactionAmount);

				$sql = $sql."(
						'".$TransactionAmount."',
						'".$BuildYear."',
						'".$DealYear."',
						'".$landArea."',
						'".$Courtbuilding."',
						
						'".$buildingName."',
						'".$DealMonth."',
						'".$Dealday."',
						'".$AreaforExclusiveUse."',
						'".$buildingNumber."',
						'".$AreaCode."',
						'".$buildingfloor."',
								'".$today_time."'),";
				
				if($n==$value_count){$n=0;$sql=substr($sql, 0, -1);$res = mysqli_query($real_sock,$sql);$sql = $temp_sql;}
			}
			
			$sql	= substr($sql, 0, -1);
			$res	= mysqli_query($real_sock,$sql);
		

	/// 매매 거래 넣기 끝
?>