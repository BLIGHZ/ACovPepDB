<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
   "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US">
<head>
	<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="style1.css" media="screen" />
	<script src="./css/smorfdb.js" type="text/javascript"></script>
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


	<title>Search</title>
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
				<li><a href='./browse.php'>Browse</a></li>
				<li><a href='./search.php'><font color="black">Search</font></a></li>
                                <li><a href='./download.html'>Download</a></li>
				<li><a href='./feedback.php'>Feedback</a></li>
				<li><a href='./help.html '>Help</a>
			</ul>
		</div>
	</div>
</div>

<div id="top"> </div>

<div id="contentt">

	<div class="mid">
		<ul>
		<div id="content">
			<p class="intro"><br/>Users can search ACovPepDB by inputting keywords and choosing corresponding search terms. Search results can be downloaded in *.xml format.<br/>
		<?php
		     $br = "\n";  
		    error_reporting(E_ALL ^ E_NOTICE); 
			require_once 'pager/Wrapper.php'; 
			require_once './mm.php';
			set_include_path('/usr/php');
		    require_once 'DB.php';
			
			$dsn1 = array(
			  	   'phptype'  => 'mysql',
			  	   'username' => 'ACovPepDB',
			  	   'password' => 'ACovPepDBpassword',
			       'hostspec' => 'localhost',
			       'database' => 'ACovPepDB',
			   );
			
			$db = DB::connect($dsn1);
			if (DB::isError($db)){
				die("Could not connect to the databease:<br/>".DB::errorMessage($db));					
			}
            $db->query("SET NAMES utf8");
			
			$A1 = @$_GET['a1']; $B1 = trim(@$_GET['b1']);
			$A2 = @$_GET['a2']; $B2 = trim(@$_GET['b2']);
			$A3 = @$_GET['a3']; $B3 = trim(@$_GET['b3']);
			$C2 = @$_GET['c2'];
			$C3 = @$_GET['c3'];
			
			$tosearch = ($B1 != "" or $B2 !="" or $B3 !="");

			if ( $tosearch){

				$sql_0 = "SELECT * FROM acovpeptide where ";
				//$sql_0 = mysql_query("SELECT * FROM acovpeptide where ",$db);
			}
			
						
			



			if ($A1 == 'all'){$sql_1= "ACovPid like \"%$B1%\" or TrivialName like \"%$B1%\" or Sequence like \"%$B1%\" or NumberofAminoAcids like \"%$B1%\" or Source like \"%$B1%\" or AgainstVirus like \"%$B1%\" or InhibitionUnit like \"%$B1%\" or InhibitionUnit like \"%$B1%\" or InhibitoryEffect like \"%$B1%\" or Assay like \"%$B1%\" or Reference like \"%$B1%\" or TargetName like \"%$B1%\" or TargetType like \"%$B1%\" or UniportID like \"%$B1%\" or Synonyms like \"%$B1%\" or TargetSource like \"%$B1%\" or TargetStructure like \"%$B1%\" ";}
			elseif($A1 == 'TargetDomainName'){$sql_1 = " TargetName like \"%$B1%\" ";}
			else{$sql_1 = " $A1 like \"%$B1%\" ";}
			
			if ($A2 == 'all'){$sql_2= "ACovPid like \"%$B2%\" or TrivialName like \"%$B1%\" or Sequence like \"%$B2%\" or NumberofAminoAcids like \"%$B2%\" or Source like \"%$B2%\" or AgainstVirus like \"%$B2%\" or InhibitionUnit like \"%$B2%\" or InhibitionUnit like \"%$B2%\" or InhibitoryEffect like \"%$B2%\" or Assay like \"%$B2%\" or Reference like \"%$B2%\" or TargetName like \"%$B2%\" or TargetType like \"%$B2%\" or UniportID like \"%$B2%\" or Synonyms like \"%$B2%\" or TargetSource like \"%$B2%\" or TargetStructure like \"%$B2%\" ";}
			elseif($A2 == 'TargetDomainName'){$sql_2 = " TargetName like \"%$B2%\" ";}
			else{$sql_2 = " $A2 like \"%$B2%\" ";}
			
			if ($A3 == 'all'){$sql_3= "ACovPid like \"%$B3%\" or TrivialName like \"%$B1%\" or Sequence like \"%$B3%\" or NumberofAminoAcids like \"%$B3%\" or Source like \"%$B3%\" or AgainstVirus like \"%$B3%\" or InhibitionUnit like \"%$B3%\" or InhibitionUnit like \"%$B3%\" or InhibitoryEffect like \"%$B3%\" or Assay like \"%$B3%\" or Reference like \"%$B3%\" or TargetName like \"%$B3%\" or TargetType like \"%$B3%\" or UniportID like \"%$B3%\" or Synonyms like \"%$B3%\" or TargetSource like \"%$B3%\" or TargetStructure like \"%$B3%\" ";}
			elseif($A3 == 'TargetDomainName'){$sql_3 = " TargetName  like \"%$B3%\" ";}
			else{$sql_3 = " $A3 like \"%$B3%\" ";}
			
					
			
			
						

			
			

			$usql = "$sql_0 (($sql_1) $C2 ($sql_2) $C3 ($sql_3)) " ;

			

			@$numrows = mysql_num_rows( mysql_query($usql) );
			

			$paged_data = Pager_Wrapper_DB($db, $usql, $pager_options, false, DB_FETCHMODE_ASSOC);
			

			
			if ($tosearch and $numrows>0){
                                       echo "<p>" . $br;
					
                                       echo "<a style='margin-right: 15px;' href='download.php?" . $_SERVER["QUERY_STRING"] . "'>Download xml file</a>" . $br;
                                       echo "</p>" . $br;

			    echo '<br /><table id="center"><tr><th width="12%">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspACovPid</th><th width="25%">Against Virus</th><th width="5%" >Inhibition Unit</th><th width="8%" >Inhibitory Effect</th><th width="15%" >&nbsp&nbspTarget Domain Name</th><th width="6%">Detail</th></tr>';
			       foreach ($paged_data['data'] as $results){
				$AgainstVirusURL = explode(":",$results['AgainstVirus'])[1];
				$AgainstVirusURL = substr($AgainstVirusURL,1);
				$AgainstVirus_array = (explode(":",$results['AgainstVirus']));
				$AgainstVirus_name = $AgainstVirus_array[0];
				$AgainstVirus_ID = $AgainstVirus_array[1];
				$row2 = $db->getRow("select * from targetdomain where TargetID = '$results[TargetID]'");
                                   $LinkRecord = '<a  title="view more information" href= "http://i.uestc.edu.cn/ACovPepDB/browse.php?ACovPid='.$results['ACovPid'].'">'.$results['ACovPid'].'</a>';
			       echo '<tr><td align="center">'.$LinkRecord.'</td>';
						 if ($AgainstVirus_ID == NULL){
						 echo '<td align="left"><p>'.$AgainstVirus_name.'<a target="_blank" href="https://www.uniprot.org/taxonomy/'.$AgainstVirusURL.'">'.$AgainstVirus_ID.'</a></p></td>';

						 }
						 else{
						 echo '<td align="left"><p>'.$AgainstVirus_name.' : <a target="_blank" href="https://www.uniprot.org/taxonomy/'.$AgainstVirusURL.'">'.$AgainstVirus_ID.'</a></p></td>';

						 }
						 echo '<td align="center">'.$results['InhibitionUnit'].'</td><td align="left">'.$results['InhibitoryEffect'].'</td>
						<td align="left"><a target="_blank" href="http://i.uestc.edu.cn/ACovPepDB/browse_target_table.php?TargetID='.$results['TargetID'].'">'.$row2[1].'</a></td>
						
						<td align="left"><a href="http://i.uestc.edu.cn/ACovPepDB/browse.php?ACovPid='
							.$results['ACovPid'].'">more</a></td></tr>';
			       }
			       echo '</table><br />';
			       echo '<p class="p34">'.$paged_data['links'].'</p>';

			}
	   
			if ($tosearch and $numrows==0){
			echo '<p><br /><br /><center><img src="./images/mimodb_ant.gif" /></center></p><p><br /><br /><center><font size=3><b>No items found! Please revise your query and try again!</b></font></center></p>';
			}

			if (!$tosearch){?>
				<div>
				    
					<form action="search.php" method="get">
					<table class="none_border">
					

					<tr>
						<th width="30%" class="none_border" style="min-width:130px;">Select search field</th>
						<th width="50%" class="none_border">Input your string for searching</th>
						<th width="20%" class="none_border" style="min-width:130px;">Options</th>
					</tr>

					<tr><td class="none_border">&nbsp;</td><td class="none_border">&nbsp;</td><td class="none_border">&nbsp;</td></tr>

					<tr>
						<td class="none_border"><select name="a1"><?php echo displayoption()?></select></td> 
						<td class="none_border"><input type="text" name="b1" style="width:99%" /></td>&nbsp;
						<td class="none_border"><input type="radio" name="c2" value ="and" checked /> and &nbsp;                          
						<input type="radio" name="c2" value ="or"/>or</td>
					</tr>
          
					<tr><td class="none_border">&nbsp;</td><td class="none_border">&nbsp;</td><td class="none_border">&nbsp;</td></tr>
					
					<tr>
						<td class="none_border"><select name="a2" ><?php echo displayoption()?></select></td>
						<td class="none_border"><input type="text"   name="b2" style="width:99%" /></td>&nbsp;
						<td class="none_border"><input type="radio" name="c3" value ="and" checked /> and &nbsp;                          
						<input type="radio" name="c3" value ="or"/>or</td>
					</tr>
					
					<tr><td class="none_border">&nbsp;</td><td class="none_border">&nbsp;</td><td class="none_border">&nbsp;</td></tr>

					<tr>
						<td class="none_border"><select name="a3"><?php echo displayoption()?></select></td> 
						<td class="none_border"><input type="text" name="b3" style="width:99%" /></td>
					</tr>
          
					<tr><td class="none_border">&nbsp;</td><td class="none_border">&nbsp;</td><td class="none_border">&nbsp;</td></tr>
					<tr><td class="none_border">&nbsp;</td><td class="none_border">&nbsp;</td><td class="none_border">&nbsp;</td></tr>
					<tr><td align = "center" colspan="3" class="none_border">
						<input type="button" name="button" value ="Example" onclick="ExampleAdvancedSearch();" />&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="reset" name="reset" value ="Reset" />&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit" name="submit" value ="Submit Query" />&nbsp;&nbsp;&nbsp;&nbsp;
					</td></tr>   
					


					
	          </table></form></div>
			<?php }
			
			?>
			<div id="content">
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
</html>
