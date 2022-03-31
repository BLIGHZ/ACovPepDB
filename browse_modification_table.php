<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
   "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>	
	<title>Browse</title>

	<script>

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
                        <li><a href='./browse.php' style="color:black">Browse</a></li>
                        <li><a href='./search.php'>Search</a></li>
			<li><a href='./cgi-bin/blastsearch.pl '>ACovPBlast</a></li>
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

				
				


			
				
				
				$db->query("SET NAMES utf8");
					function test_input($data) 
						{
 							$data = trim($data);
  						    $data = stripslashes($data);
  						    $data = htmlspecialchars($data);
 							return $data;
						}
			
				@$ModificationID= test_input($_REQUEST['ModificationID']);


				// display the paged summary table 
				if ($ModificationID=="")  {
					$sql = 'SELECT * FROM modification';
					$row = $db->getRow($sql);
					//echo $row;

					$paged_data = Pager_Wrapper_DB($db, $sql, $pager_options, false, DB_FETCHMODE_ASSOC);
					//echo '<tr><td><a title="Target Domain Table" target="_blank" href="http://i.uestc.edu.cn/ACovPepDB/browse.php"><b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspBack</a></td></tr>';
					
					echo '<tr><a title="Acovpeptide Table"  href="http://i.uestc.edu.cn/ACovPepDB/browse.php"><b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspAcovpeptide Table</b></a></td><a title="Target Domain Table" href="http://i.uestc.edu.cn/ACovPepDB/browse_target_table.php"><b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspTarget Domain Table</b></a><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspModification Table</td></tr>';



					echo '<br /><br /><table id="center" width="100%"><tr><th width="15%">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspModificationID</th><th width="35%" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspModification Name</th><th width="25%">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspDetail</th></tr>';


					foreach ($paged_data['data'] as $results){
						$sql2 = 'SELECT * FROM modification WHERE ModificationID = $results[ModificationID]';
						$row2 = $db->getRow("select * from modification where ModificationID = '$results[ModificationID]'");
						
						$TargetSourceURL = explode(":",$results['TargetSource'])[1];
						$TargetSourceURL = substr($TargetSourceURL ,1);


						$paged_data2 = Pager_Wrapper_DB($db, $sql2, $pager_options, false, DB_FETCHMODE_ASSOC);
						$results2= $paged_data['data'][0];
								
						$LinkRecord = '<a  title="view more information" href= "http://i.uestc.edu.cn/ACovPepDB/browse_modification_table.php?ModificationID='
							.$results['ModificationID'].'">'.$results['ModificationID'].'</a>';
						$TargetSource_array = (explode(":",$results['TargetSource']));
						$TargetSource_name = $TargetSource_array[0];
						$TargetSource_ID = $TargetSource_array[1];

								
						$name = str_replace("%20"," ", $results['ModificationName']);
						echo '<tr><td align="center">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$LinkRecord.'</td><td align="center">'.$results['ModificationName'].'</td>


						
						
						<td align="left"><a href="http://i.uestc.edu.cn/ACovPepDB/search.php?a1=all&b1='.$name.'&c2=and&a2=all&b2=&c3=and&a3=all&b3=&submit=Submit+Query">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspModified Peptide</a></td></tr>';



												
						
					}
					echo '</table><br />';

					//saypager("acovpdb", $paged_data['links']);
					
					
				}
				
				if ($ModificationID!="")  {
										

					//echo '<br /><table id="center" > <tr bgcolor="#0196c1"><td colspan="11" class="td1"><font color="#FFFFF7">Modification information</font></td></tr>';
                                        $row = $db->getRow("select * from modification where ModificationID = \"$ModificationID\"");
			                echo '<br /><table id="center"> <tr bgcolor="#0196c1"><td colspan="2" class="td1"><font color="#FFFFF7">Modification information</font></td></tr>';
                                        echo '<tr><td width="20%">ModificationID:</td><td>'.$row[0].'</td></tr>';
					echo '<tr><td width="20%">Modification Name:</td><td>'.$row[1].'</td></tr>';
					
					

					$phpExcel = PHPExcel_IOFactory::load($fileName2);// 载入当前文件
					$phpExcel->setActiveSheetIndex(0);// 设置为默认表
					$sheetCount = $phpExcel->getSheetCount();// 获取表格数量
					$exclerow = $phpExcel->getActiveSheet()->getHighestRow();// 获取行数
					$column = $phpExcel->getActiveSheet()->getHighestColumn();// 获取列数
					$data = "";
					// 行数循环
					for ($j = 'A'; $j <= $column; $j++){
						
							$nowcol = $phpExcel->getActiveSheet()->getCell($j . 1)->getValue();
							
							if((string)$nowcol== $row[0]){
								echo '<tr><td width="20%">Modified Peptide:</td>';echo '<td>';
								for ($i = 2; $i <= $exclerow; $i++) {
									$modacovpid = $phpExcel->getActiveSheet()->getCell($j . $i)->getValue();
									if($modacovpid != "NO"){
	
										echo '<a  target="_blank" href="http://i.uestc.edu.cn/ACovPepDB/browse.php?ACovPid='.(string)$modacovpid.'"><b>'.(string)$modacovpid.'  </b><b> </b></a>';
										

									}
									
								}
								echo '</td>';
								//echo '<td>'.$seq.'</td>';
								echo '</tr>';
									
						
						}

					}




					
					
					
					                                

					


					echo '</table>';
					
                                        
					                                                                                 
					



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
