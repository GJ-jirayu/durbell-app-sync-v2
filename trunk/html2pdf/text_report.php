
<?php

include_once("../config.php");

/*########################### select promotion start #########################*/

/*
  # Connect using the default user ID and password
  $conn = sasql_connect( "UID=DBA;PWD=sql" );
  if( ! $conn ) {
      echo "sasql_connect failed\n";
  } else {
      echo "Connected successfully\n";
      # Execute a SELECT statement
      $result = sasql_query( $conn, "SELECT * FROM Customers" );
      if( ! $result ) {
          echo "sasql_query failed!";
      } else {
          echo "query completed successfully\n";
          # Generate HTML from the result set
          sasql_result_all( $result );
          sasql_free_result( $result );
      }
      sasql_close( $conn );
  }
*/


$htmlData="";
$sqlPromItem="SELECT pit.*,it.ItemDesc,ps.Step as Step,ps.BreakQty as BreakQty ,
ps.BreakUnitCode as BreakUnitCode,ps.BreakUnitFactor as BreakUnitFactor,
ps.BreakAmt as BreakAmt,ps.DiscBaht as DiscBaht,ps.PromStepNote as PromStepNote,ps.DiscPer as DiscPer
from PromItem pit
inner join PromStep ps  on pit.PromType=ps.PromType
and pit.PromNo=ps.PromNo
and pit.PromCode=pit.PromCode
left join Item it on pit.PromCode=it.ItemCode
where pit.PromType='DCI'
AND pit.PromNo='A11223344'
AND pit.PromCode='10101001'";


	$rsPromItem=odbc_exec($conn,$sqlPromItem);


	
	if (!$rsPromItem) {
	  exit("Error in SQL");
	}else{
		$j=0;
		 while (odbc_fetch_row($rsPromItem)) {
			  $PromType=odbc_result($rsPromItem,"PromType");
			  $PromNo=odbc_result($rsPromItem,"PromNo");
			  $PromCode=odbc_result($rsPromItem,"PromCode");
			  $ItemDesc=odbc_result($rsPromItem,"ItemDesc");
			  $BreakBy=odbc_result($rsPromItem,"BreakBy");
			  $DiscFor=odbc_result($rsPromItem,"DiscFor");
			  $LimitFreeQty=odbc_result($rsPromItem,"LimitFreeQty");
			  $FreeUnitCode=odbc_result($rsPromItem,"FreeUnitCode");
			  $LimitDiscBaht=odbc_result($rsPromItem,"LimitDiscBaht");

              /*
			  (Q-Quanlity A-Amonut LQ-Loop Quanlity LA-Loop Amonut)
			  (B-Baht P-Percent LB-Loop Baht LP-Loop Percent) 
			  */

			  if($BreakBy=="A" or $BreakBy=="LA"){
				  $BreakAmt=odbc_result($rsPromItem,"BreakAmt");
				  $Break=odbc_result($rsPromItem,"BreakAmt");
				  
			  }else{

				  $BreakQty=odbc_result($rsPromItem,"BreakQty");
				  $Break=odbc_result($rsPromItem,"BreakQty");
				 
			  }

			  if($DiscFor=="B" or $DiscFor=="LB"){
				  $DiscBaht=odbc_result($rsPromItem,"DiscBaht");
				  $Disc=odbc_result($rsPromItem,"DiscBaht");
				  
			  }else{

				  $DiscPer=odbc_result($rsPromItem,"DiscPer");
				  $Disc=odbc_result($rsPromItem,"DiscPer");
				 
			  }



			   $BreakUnitCode=odbc_result($rsPromItem,"BreakUnitCode");
			   $BreakUnitFactor=odbc_result($rsPromItem,"BreakUnitFactor");
			   $Step=odbc_result($rsPromItem,"Step");
			  
			  
			  
			  $PromStepNote=odbc_result($rsPromItem,"PromStepNote");
			 


			  
			  // echo  "level 1 PromType=".$PromType." PromNo=".$PromNo." PromCode=".$PromCode."<br>";


		$htmlData.='<tr style="text-align:left;" >';
			$htmlData.='<td>';
			$htmlData.=$PromCode.'';
			$htmlData.='</td>';
			$htmlData.='<td width="80">';
			$htmlData.=$ItemDesc.'';
			$htmlData.='</td>';
			$htmlData.='<td>';
			$htmlData.= $Step.'';
			$htmlData.='</td>';
			$htmlData.='<td>';
			$htmlData.=$BreakBy.'';
			$htmlData.='</td>';
			$htmlData.='<td>';
			$htmlData.=$Break.'';
			$htmlData.='</td>';
			$htmlData.='<td>';
			$htmlData.= $BreakUnitCode.'';
			$htmlData.='</td>';
			$htmlData.='<td>';
			$htmlData.=$DiscFor.'';
			$htmlData.='</td>';
			$htmlData.='<td>';
			$htmlData.=$DiscPer.'';
			$htmlData.='</td>';
			$htmlData.='<td> ';
			$htmlData.=$LimitFreeQty.'';
			$htmlData.='</td>';
			$htmlData.='<td>';
			$htmlData.=$Disc.'';
			$htmlData.='</td>';
			
			
 		


	

		

			  $sqlStepFreeItem="SELECT psft.*,Item.ItemDesc as ItemDesc from PromStepFreeItem  psft
left join Item on psft.FreeItemCode = Item.ItemCode
where PromType='DCI'
AND PromNo='A11223344'
AND PromCode='$PromCode'
AND Step=3";

			 $rsStepFreeItem=odbc_exec($conn,$sqlStepFreeItem);
			 $num=odbc_fetch_row($rsStepFreeItem);
			 if($num){
			 
			 }else{
				$htmlData.='<td>';
				$htmlData.='1';
				$htmlData.='</td>';
				$htmlData.='<td> ';
				$htmlData.='2';
				$htmlData.='</td>';
				$htmlData.='<td>';
				$htmlData.='3';
				$htmlData.='</td>';
				$htmlData.='<td>';
				$htmlData.='4';
				$htmlData.='</td> ';
				$htmlData.='<td>';
				$htmlData.='5';
				$htmlData.='</td>';
			 }
			
			 if (!$rsStepFreeItem) {
			  exit("Error in SQL");
			 }else{
					$i=1;
					 while (odbc_fetch_row($rsStepFreeItem)) {
					  $PromType=odbc_result($rsStepFreeItem,"PromType");
					  $PromNo=odbc_result($rsStepFreeItem,"PromNo");
					  $PromCode=odbc_result($rsStepFreeItem,"PromCode");
					  $Step=odbc_result($rsStepFreeItem,"Step");
					  $FreeItemCode=odbc_result($rsStepFreeItem,"FreeItemCode");
					  $ItemDesc=odbc_result($rsStepFreeItem,"ItemDesc");
					  $FreeQty=odbc_result($rsStepFreeItem,"FreeQty");
					  $FreeUnitCode=odbc_result($rsStepFreeItem,"FreeUnitCode");
					  
					 // echo "level 3 FreeItemCode=".$FreeItemCode."<br>";
					
						if($i==1){
							
							$htmlData.='<td>';
							$htmlData.=$i.'';
							$htmlData.='</td>';
							$htmlData.='<td> ';
							$htmlData.=$FreeItemCode.'';
							$htmlData.='</td>';
							$htmlData.='<td>';
							$htmlData.=$ItemDesc.'';
							$htmlData.='</td>';
							$htmlData.='<td>';
							$htmlData.=$FreeQty.'';
							$htmlData.='</td> ';
							$htmlData.='<td>';
							$htmlData.=$FreeUnitCode.'';
							$htmlData.='</td>';
							
						}else{

							$htmlData.='<tr>';
								$htmlData.='<td colspan="10">'.''.'</td>';
								$htmlData.='<td>';
								$htmlData.=$i.'';
								$htmlData.='</td>';
								$htmlData.='<td> ';
								$htmlData.=$FreeItemCode.'';
								$htmlData.='</td>';
								$htmlData.='<td>';
								$htmlData.=$ItemDesc.'';
								$htmlData.='</td>';
								$htmlData.='<td>';
								$htmlData.=$FreeQty.'';
								$htmlData.='</td> ';
								$htmlData.='<td>';
								$htmlData.=$FreeUnitCode.'';
								$htmlData.='</td>';
							$htmlData.='</tr>';
						}
							
						
					  $i++;
					 }//while

				 
				
			 }

			 $htmlData.='</tr>';
		 }//loop while
		 odbc_close($conn);

		 


	}//if reslult 
	//echo $htmlData;
/*########################### select promotion end #########################*/



/*
SELECT * from PromItem
where PromType='DCI'
AND PromNo='A11223344'

*/
?>
<div class="title" style="text-align:center"><h3>Discount Promotion By Item Report</h3></center>
<div class="date" style="text-align:center">Date : 8/4/2014 13:49</div>
<table border="1">
	<tr>
		<td>
			<div style="text-align:left;">
				<b>
				Promotion No:
				</b>
			</div>
		</td>
		<td>
			<div style="text-align:left;">
			
				DI520301 
			</div>
		</td>
		
		<td>
			<div style="text-align:left;">
				<b>
				Promotion Description:
				</b>
			</div>
		</td>
		
		<td>
			<div style="text-align:left;">
			Tea & Star Prom Start Date: 1-Jan-14 End Date: 31-May-14
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<div style="text-align:left;">
				<b>
				Branch:
				</b>
			</div>
		</td>
		<td colspan="3">
			<div style="text-align:left;">
				All Branch 
			</div>
		</td>
	</tr>
	<tr>
		<td>
		<div style="text-align:left;">
			<b>
			Sales Team:
			</b>
		</div>
		</td>
		<td colspan="3">
			<div style="text-align:left;">
				All Sales Team
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<div style="text-align:left;">
			<b>
				Shop Type:
			</b>
			</div>
		</td>
		<td colspan="3">
			<div style="text-align:left;">
			Shop Type 00-1,Shop Type 00-2,Shop Type 00-3,Shop Type 00-4,Shop Type 00-5
			</div>
		</td>
	</tr>
</table>
<br style="clear:both">
<table border="1">
	<thead >
		<tr style="text-align:left; font-weight:bold; border:1px #cccccc solid" >
			<th>
			<div style="text-align:left;border:1px #cccccc solid;">
			Item Code
			</div>
			</th>
			<th>
			Item Description
			</th>
			<th>
			Step
			</th>
			<th>
			Break
			</th>
			<th>
			Break Uint
			</th>
			<th>
			Break By
			</th>
			<th>
			Discount 
			</th>
			<th> 
			Discount For 
			</th>
			<th> 
			Limit Free 
			</th>
			<th>
			Limit Discount 
			</th>
			<th>
			Seq
			</th>
			<th> 
			Free Item Code
			</th>
			<th>
			Description 
			</th>
			<th>
			Free Qty
			</th> 
			<th>
			Unit 
			</th>
 		</tr>
	</thead>
	<tbody>
	<!--
		<tr style="text-align:left;">
			<td>
			11130802
			</td>
			<td>
			ค่ารามูโจ้ 18 g ฮ็อดชิลลี่1 
			</td>
			<td>
			1
			</td>
			<td>
			10
			</td>
			<td>
			ชิ้น
			</td>
			<td>
			 Quanlity
			</td>
			<td>
			5
			</td>
			<td>
			Percent
			</td>
			<td>
			 1
			</td>
			<td>
			5
			</td>
			<td>
			1
			</td>
			<td>
			01010006A
			</td>
			<td>
			กระทิงแดง 150 มล. 
			</td>
			<td>
			 1
			</td>
			<td>
			ชิ้นชิ้น
			</td>
		</tr>
		<tr style="text-align:left;">
			
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>


			<td>2</td>
			<td>01010007A</td>
			<td> กระทิงแดง 150 มล.(พ),</td>
			<td>1</td>
			<td>ชิ้น</td>
		</tr>
		<tr style="text-align:left;">
			
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>


			<td>3</td>
			<td>01010007A</td>
			<td> กระทิงแดง 150 มล.(พ),</td>
			<td>1</td>
			<td>ชิ้น</td>
		</tr>
		<tr style="text-align:left;">
			
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>


			<td>4</td>
			<td>01010007A</td>
			<td> กระทิงแดง 150 มล.(พ),</td>
			<td>1</td>
			<td>ชิ้น</td>
		</tr>
		<tr style="text-align:left;">
			<td>
			11130801 
			</td>
			<td>
			ค่ารามูโจ้ 18 g ฮ็อดชิลลี่1 
			</td>
			<td>
			1
			</td>
			<td>
			10
			</td>
			<td>
			ชิ้น
			</td>
			<td>
			 Quanlity
			</td>
			<td>
			5
			</td>
			<td>
			Percent
			</td>
			<td>
			 1
			</td>
			<td>
			5
			</td>
			<td>
			1
			</td>
			<td>
			01010006A
			</td>
			<td>
			กระทิงแดง 150 มล. 
			</td>
			<td>
			 1
			</td>
			<td>
			ชิ้นชิ้น
			</td>
		</tr>
		<tr style="text-align:left;">
			
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>


			<td>2</td>
			<td>01010007A</td>
			<td> กระทิงแดง 150 มล.(พ),</td>
			<td>1</td>
			<td>ชิ้น</td>
		</tr>
		<tr style="text-align:left;">
			
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>


			<td>3</td>
			<td>01010007A</td>
			<td> กระทิงแดง 150 มล.(พ),</td>
			<td>1</td>
			<td>ชิ้น</td>
		</tr>
		<tr style="text-align:left;">
			
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>


			<td>4</td>
			<td>01010007A</td>
			<td> กระทิงแดง 150 มล.(พ),</td>
			<td>1</td>
			<td>ชิ้น</td>
		</tr>
		-->
		<?=$htmlData?>
	</tbody>
</table>