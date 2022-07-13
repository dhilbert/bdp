<div class="tab-pane fade " id="pilltab5">
	
	<table data-toggle="table"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
		<thead>
			<tr>
				<th data-field="s_0" data-sortable="true" >No</th>
				<th data-field="s_1" data-sortable="true" >지역명  </th>
				<th data-field="s_2" data-sortable="true" >출력명 </th>
				<th data-field="s_3" data-sortable="true" >maplv1  </th>
				<th data-field="s_4" data-sortable="true" >maplv2  </th>
				<th data-field="s_5" data-sortable="true" >maplv3  </th>
				<th data-field="s_6" data-sortable="true" >maplv4  </th>

			</tr>
		</thead>
		<tbody><?php $count_n = 0;
			
			
			$sql = "select  regionName,printName,maplv1,maplv2,maplv3,maplv4 from region_code
			where maplv4 = 1;";
			$res = mysqli_query($real_sock,$sql);
			while($info = mysqli_fetch_array($res)){

				$count_n += 1;
				echo "
					<tr>
						<td  data-field='s_0' data-sortable='true'>".$count_n."</td>
						<td  data-field='s_1' data-sortable='true'>".$info['regionName']."</td>
						<td  data-field='s_2' data-sortable='true'>".$info['printName']."</td>
						<td  data-field='s_3' data-sortable='true'>".hd_check_print($info['maplv1'])."</td>
						<td  data-field='s_4' data-sortable='true'>".hd_check_print($info['maplv2'])."</td>
						<td  data-field='s_5' data-sortable='true'>".hd_check_print($info['maplv3'])."</td>
						<td  data-field='s_6' data-sortable='true'>".hd_check_print($info['maplv4'])."</td>



					</tr>

						
			
				";



			}
			
			?>
		</tbody>
	</table>







</div>