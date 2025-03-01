<?
require_once('../includes/surya.dream.php');
//print date(Ymdhms);
$sql = "select * from ngo_users where  u_id>=101 and u_id <=5819 order by u_id asc ";  //5819
$result = db_query($sql);
while($line= mysqli_fetch_array($result)){
 	$bill_userid = $line[u_id];
	$bill_date =$line[u_date];
	$u_utype =$line[u_utype];
	// product details 
	
	$sql_prod = "select * from ngo_products_march09 where  prod_utypeid='$u_utype' ";
	$result_prod = db_query($sql_prod);
	$line_prod= mysqli_fetch_array($result_prod);

	if ($line_prod[prod_name]!='') { 
		$bill_prod1=$line_prod[prod_name]; //'Ladies Suit  / Saree';
		$bill_prodqty1=1;
		$bill_prodrate1=$line_prod[prod_price]; 
		$bill_prodamt1=$line_prod[prod_price];
 		$bill_taxable='nontaxable';
		$bill_tax_rate ='';
		$bill_prod2='';
		$bill_prodqty2='';
		$bill_prodrate2='';
		$bill_prodamt2='';
		$bill_prodtax='';
 	 
 	}
		$bill_id = db_scalar("select bill_id from ngo_bill where bill_userid='$bill_userid'");
		//if ($bill_tax_rate!='' && $bill_prodamt2!='') { $bill_prodtax =round((($bill_prodamt2*$bill_tax_rate)/100),0);}
 		$bill_amount = $bill_prodamt1+$bill_prodamt2+$bill_prodtax;
		$bill_amt_inword = "Rs. " .convert_number($bill_prodamt1). " only" ;
		if ($bill_id!='') {
		  	$sql = "update ngo_bill set  bill_date='$bill_date',bill_taxable='$bill_taxable',bill_tax_rate='$bill_tax_rate',bill_note='$bill_note', bill_userid='$bill_userid', bill_prod1='$bill_prod1', bill_prodqty1='$bill_prodqty1', bill_prodrate1='$bill_prodrate1',bill_prodamt1='$bill_prodamt1', bill_prod2='$bill_prod2' , bill_prodqty2='$bill_prodqty2', bill_prodrate2='$bill_prodrate2',bill_prodamt2='$bill_prodamt2' ,bill_prodtax='$bill_prodtax' ,bill_amount='$bill_amount' ,bill_amt_inword='$bill_amt_inword' where bill_id='$bill_id'";
			db_query($sql);
 		} else {
			$sql = "insert into ngo_bill set  bill_date='$bill_date',bill_taxable='$bill_taxable',bill_tax_rate='$bill_tax_rate',bill_note='$bill_note', bill_userid='$bill_userid', bill_prod1='$bill_prod1', bill_prodqty1='$bill_prodqty1', bill_prodrate1='$bill_prodrate1',bill_prodamt1='$bill_prodamt1', bill_prod2='$bill_prod2' , bill_prodqty2='$bill_prodqty2', bill_prodrate2='$bill_prodrate2',bill_prodamt2='$bill_prodamt2' ,bill_prodtax='$bill_prodtax' ,bill_amount='$bill_amount' ,bill_amt_inword='$bill_amt_inword' ";
			db_query($sql);
			 
 		}
		print "<br>counter = ".$bill_userid;
		 
 }

 

?>
 