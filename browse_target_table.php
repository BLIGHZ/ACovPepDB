<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
   "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>	
	<title>Browse</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
	<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="style1.css" media="screen" />
	<script type="text/javascript" src="./css/smorfdb.js" ></script>
	<script type='text/javascript' src="./jquery-1.7.2.min.js"></script>
	<script>
	//check the entry ID to avoid radiculous..., added by Jian Huang 2011-8-13
		function checkEntryID(elem, min, max){
			var uInput = elem.value;
			if (uInput.match(/\D/)){
				alert("An entry ID should be a number!");
				return false;}
			if (uInput < min){
				alert("Entry IDs count from 1.");
				return false;}
			if (uInput > max){
				var mymsg = "The maximum entry ID in this table is "+ max +" !"; 
				alert( mymsg );
				return false;}
		}
	</script>

	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-25241394-1']);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
</head>
<!-- Now Body Part -->
<body >
<div id="wrap">
	<div id="header">
 		<a href="#"><img src="images/LOGO.png" alt="" title="ACovPepDB"></a>
	<div id="headermenu"> 
		<div class="headerm">
			<ul>
				<li><a href='./index.html'>Home</a></li>
				<li><a href='./browse.php'><font color="black">Browse</font></a></li>
				<li><a href='./search.php'>Search</a></li>
				
				<li><a href='./download.html'>Download</a></li>
				<li><a href='./feedback.php'>Feedback</a></li>
				<li><a href='./help.html '>Help</a></li>
			</ul>
		</div>
	</div>
</div>

<div id="top"> </div>

<div id="contentt">

<!--div class="left">
</div--> 

<div class="mid">
	<ul>
			<?php
				error_reporting (E_ALL^E_NOTICE);
				require_once 'pager/Wrapper.php'; 
				set_include_path('/usr/php');
				require_once 'DB.php';
				require_once './mm.php';
				
				
				$dsn1 = array(
			  	   'phptype'  => 'mysql',
			  	   'username' => 'ACovPepDB',
			  	   'password' => 'ACovPepDBpassword',
			       'hostspec' => 'localhost',
			       'database' => 'ACovPepDB',
			   );
			   $db = DB::connect($dsn1);
			
			  }
			
				
				
				$db->query("SET NAMES utf8");
					function test_input($data) 
						{
 							$data = trim($data);
  						    $data = stripslashes($data);
  						    $data = htmlspecialchars($data);
 							return $data;
						}
			
				@$TargetID= test_input($_REQUEST['TargetID']);


				 
				if ($TargetID=="")  {
					$sql = 'SELECT * FROM targetdomain';
					$row = $db->getRow($sql);
					

					$paged_data = Pager_Wrapper_DB($db, $sql, $pager_options, false, DB_FETCHMODE_ASSOC);
					echo '<tr><a title="Acovpeptide Table"  href="http://i.uestc.edu.cn/ACovPepDB/browse.php"><b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspAcovpeptide Table</b></a></td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspTarget Domain Table</td><td></tr>';



					echo '<br /><br /><table id="center" width="100%"><tr><th width="5%">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspTargetID</th><th width="15%" >Target Domain Name</th><th width="8%" >&nbsp&nbsp&nbsp&nbspTarget Type</th><th width="8%" >UniprotID</th><th width="15%" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspTarget Source</th><th width="6%">Detail</th></tr>';


					foreach ($paged_data['data'] as $results){
						$sql2 = 'SELECT * FROM targetdomain WHERE TargetID = $results[TargetID]';
						$row2 = $db->getRow("select * from targetdomain where TargetID = '$results[TargetID]'");
						
						$TargetSourceURL = explode(":",$results['TargetSource'])[1];
						$TargetSourceURL = substr($TargetSourceURL ,1);


						$paged_data2 = Pager_Wrapper_DB($db, $sql2, $pager_options, false, DB_FETCHMODE_ASSOC);
						$results2= $paged_data['data'][0];
								
						$LinkRecord = '<a  title="view more information" href= "http://i.uestc.edu.cn/ACovPepDB/browse_target_table.php?TargetID='
							.$results['TargetID'].'">'.$results['TargetID'].'</a>';
						$TargetSource_array = (explode(":",$results['TargetSource']));
						$TargetSource_name = $TargetSource_array[0];
						$TargetSource_ID = $TargetSource_array[1];
					echo '<tr><td align="center">'.$LinkRecord.'</td><td align="left">'.$results['TargetDomainName'].'</td><td align="center">'.$results['TargetType'].'</td>
						
						<td align="left"><a target="_blank" href="https://www.uniprot.org/uniprot/'.$results['UniportID'].'">'.$results['UniportID'].'</a>';
						if ($results['TargetID'] == "17" ){
						echo '
						<td align="left"><p>'.$TargetSource_name.' <a target="_blank" href="https://www.uniprot.org/taxonomy/'.$TargetSourceURL.'">'.$TargetSource_ID.'</a></p></td>
						

						<td align="left"><a href="http://i.uestc.edu.cn/ACovPepDB/browse_target_table.php?TargetID='
							.$results['TargetID'].'">more</a></td></tr>';
						}
						else{
						echo '
						<td align="left"><p>'.$TargetSource_name.' <a target="_blank" href="https://www.uniprot.org/taxonomy/'.$TargetSourceURL.'">: '.$TargetSource_ID.'</a></p></td>
						

						<td align="left"><a href="http://i.uestc.edu.cn/ACovPepDB/browse_target_table.php?TargetID='
							.$results['TargetID'].'">more</a></td></tr>';
						}
						
					}
					echo '</table><br />';

					saypager("acovpdb", $paged_data['links']);
					
					
				}
				
				if ($TargetID!="")  {
					$row = $db->getRow("select * from targetdomain where TargetID= \"$TargetID\"");
					echo '<br /><table id="center"> <tr bgcolor="#0196c1"><td colspan="2" class="td1"><font color="#FFFFF7">Target Domain information</font></td></tr>';
			                echo '<tr><td width="20%">TargetID:</td><td>'.$row[0].'</td></tr>';
					echo '<tr><td width="20%">Target Domain Name:</td><td>'.$row[1].'</td></tr>';			
                                        echo '<tr><td width="20%">Target Domain Full Name:</td><td>'.$row[2].'</td></tr>';
                                        echo '<tr><td width="20%">Target Type:</td><td>'.$row[3].'</td></tr>';

					$UniportID_array = (explode(" ",$row[5]));
					$UniportID = $UniportID_array[0];
					$UniportID_seq = $UniportID_array[1];


					}


					echo '<tr><td width="20%">UniprotID [Sequence] :</td><td align="left"><p><a target="_blank" href="https://www.uniprot.org/uniprot/'.$UniportID.'">'.$UniportID.'</a> '.$UniportID_seq.'</p></td></tr>';
					
					

					
                                        echo '<tr><td width="20%">Target Synonyms:</td><td>'.$row[6].'</td></tr>';	

					
					$TargetSource_array = (explode(":",$row[7]));
					$TargetSource_name = $TargetSource_array[0];
					$TargetSource_ID = $TargetSource_array[1];
					$clear_TargetSource_ID= substr($TargetSource_ID,1);
					if($TargetID == "17"){
					echo '<tr><td width="20%">Target Source:</td><td align="left"><p>'.$TargetSource_name.'<a target="_blank" href="https://www.uniprot.org/taxonomy/'.$clear_TargetSource_ID.'">'.$TargetSource_ID.'</a></p></td></tr>';
					}
					else{
					echo '<tr><td width="20%">Target Source:</td><td align="left"><p>'.$TargetSource_name.' : <a target="_blank" href="https://www.uniprot.org/taxonomy/'.$clear_TargetSource_ID.'">'.$TargetSource_ID.'</a></p></td></tr>';
					}
					echo '<tr><td width="20%">Target Structure:</td><td>'.$row[8].'</td></tr>';
					
					
                                        echo '</table>';
					
                                        
					                                                                                 
					echo '</table>';


					saypager("acovpdb", $paged_data['links']);
				}
				
				
				?>
				
	</ul>
</div>

<!--div class="right">
</div-->

<div style="clear: both;">
</div>

</div>

<div id="bottom"> </div>
</div>

</body>
<script>
	$(function(){
	　　$("tr:gt(0)").mouseenter(function(){
　　　　var color = $(this).css("background-color");
　　　　$(this).css("background-color","#5caecd").css("color","#000000");
　　　　$(this).mouseleave(function(){
　　　　　　$(this).css("background-color",color).css("color","#000000");
　　　　});
　　　　$(this).mousedown(function(){
　　　　　　$(this).css("background-color","#5caecd").css("color","#000000");
　　　　});
　　　　$(this).mouseup(function(){
　　　　　　$(this).css("background-color","#5caecd").css("color","#000000");
　　　　});
　　});
});
</script>
</html>
