<?php
/*
*	Created By	:	Mayank Jaitly
*	Date		:	18 June	2010
*	Version		:	1.0 
*/

// class file for functions other than Interspire. All the function will be contained here.......
// the class is declared as abstract because we don;t need to create its object any where, we will just extend the class in other class files......  
class ISC_ADMIN_CLARION  
{
	
	function fnSaveUserYMM($customerYMMdata,$customerID,$customerType,$OrderId=0) {
		
		return;
		if($customerType=='new') {
			
			$customerYMMdata['user_id']=$customerID;
			return $GLOBALS['ISC_CLASS_DB']->InsertQuery('user_ymm', $customerYMMdata);
		}
		if($customerType=='existing') {
			if(isset($_REQUEST['ymmID']) && $_REQUEST['ymmID']!='-1' ) {
				return $_REQUEST['ymmID'];
			}
			else {
				$query="SELECT * FROM isc_user_ymm 
								WHERE 
									user_id='".$customerID."' AND 
									year='".$_REQUEST['searchyear']."' AND
									make='".$_REQUEST['searchmake']."' AND
									model='".$_REQUEST['searchmodel']."'";
									
				$result=$GLOBALS['ISC_CLASS_DB']->Query($query);
				if($GLOBALS['ISC_CLASS_DB']->CountResult($result) == 0) {
					$customerYMMdata['user_id']=$customerID;
					return $GLOBALS['ISC_CLASS_DB']->InsertQuery('user_ymm', $customerYMMdata);
				}
				else {
					$ymm_row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
					return $ymm_row['id'];
				}
			} 
		}
		if($customerType=='anonymous') {
			$customerYMMdata['order_id']=$OrderId;
			return $GLOBALS['ISC_CLASS_DB']->InsertQuery('user_ymm', $customerYMMdata);
		}
	}#fnSaveUserYMM
	
	function fnUpdateOrderYMM($orderID,$ymmID) {
		
		$where="orderid='".$orderID."'";
		$values=array('orderymmid' => $ymmID);
		$GLOBALS['ISC_CLASS_DB']->UpdateQuery('orders', $values, $where);
		
	}#fnUpdateOrderYMM
	
	function fnLoadCustomerYMM($customerID) {
		$query="SELECT * FROM isc_user_ymm where user_id='".$customerID."'";
		$result=$GLOBALS['ISC_CLASS_DB']->Query($query);
		$resultset.='
					<table width="100%" border="0">
						<tr><td style="width:20px;">&nbsp;</td>
							<td class="FieldLabel">
									<strong>Year</strong> </td>
							<td class="FieldLabel">
									<strong>Make</strong> </td>
							<td class="FieldLabel">
								<strong>Model</strong> </td>
								<td class="FieldLabel">
								<strong>Bed Size</strong> </td>
								<td class="FieldLabel">
								<strong>Cab Size</strong> </td>
							
						</tr>';
		while($ymm_row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$resultset.='<tr>
							<td><input type="radio" name="ymmID" id="ymmID" value="'.$ymm_row['id'].'" onclick="ShowHideYMM(\'1\')" checked="checked"></td>
							<td class="FieldLabel">'.$ymm_row['year'].'</td>
							<td class="FieldLabel" >'.$ymm_row['make'].'</td>
							<td class="FieldLabel">'.ucfirst($ymm_row['model']).'</td>
							<td class="FieldLabel">'.$ymm_row['bed_size'].'</td>
							<td class="FieldLabel">'.$ymm_row['cab_size'].'</td>
						</tr>';
								
		}
		
		$resultset.='
		<tr><td><br><input type="radio" name="ymmID" id="ymmID" value="-1" onclick="ShowHideYMM(\'0\')"></td><td colspan="3"><br><strong>Select new YMM Combination : </strong> &nbsp;&nbsp;<td>&nbsp;
		<input type="hidden" name="WhichToPick" id="WhichToPick" value="1" />
		</td></td>
		</table>';
		return $resultset;
	}#fnLoadCustomerYMM
	
	function fn_getCabBedsize($flag) {
		
		if($flag==1) {
			// Cab Size
			$query="SELECT DISTINCT (`generalize_value`)
							FROM  [|PREFIX|]cabsize_translation 
					GROUP BY generalize_value
					HAVING generalize_value <>  ''";
			$result=$GLOBALS['ISC_CLASS_DB']->Query($query);
			$ret_str='<select name="cabsize" id="cabsize" >
					  <option value=""> Select cab size</option>';
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			
				$ret_str.='<option value="'.$row['generalize_value'].'">'.$row['generalize_value'].'</option>';
			}
			$ret_str.='</select>';
		
		}
		if($flag==2) {
			// Bed Size
			$query="SELECT DISTINCT (`generalize_value`)
							FROM  [|PREFIX|]bedsize_translation 
					GROUP BY generalize_value
					HAVING generalize_value <>  ''";
			$result=$GLOBALS['ISC_CLASS_DB']->Query($query);
			$ret_str='<select name="bedsize" id="bedsize" >
					  <option value=""> Select bed size</option>';
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			
				$ret_str.='<option value="'.$row['generalize_value'].'">'.$row['generalize_value'].'</option>';
			}
			$ret_str.='</select>';
		
		}
		return $ret_str;
	}#fn_getCabBedsize
	
	
	
	
}#Class