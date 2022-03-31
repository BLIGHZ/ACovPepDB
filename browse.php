<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
   "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

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
				
			
				@$ACovPid = test_input($_REQUEST['ACovPid']);


				if ($ACovPid =="")  {
					
					echo '<tr><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspAcovpeptide Table</td><a title="Target Domain Table" href="http://i.uestc.edu.cn/ACovPepDB/browse_target_table.php"><b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspTarget Domain Table</b></a></td><td><a title="Modification Table" href="http://i.uestc.edu.cn/ACovPepDB/browse_modification_table.php"><b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspModification Table</b></a></td></tr>';
					


					echo '<br /><br /><table id="center" width="100%"><tr><th width="12%">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspACovPid</th><th width="25%" >Against Virus</th><th width="8%" >Inhibition Value Type</th><th width="5%" >Inhibitory Effect</th><th width="3%" >Inhibitory Unit</th><th width="20%" >&nbsp&nbspTarget Domain Name</th><th width="6%">Detail</th></tr>';
					

					foreach ($paged_data['data'] as $results){
						$AgainstVirusURL = explode(":",$results['AgainstVirus'])[1];
						$AgainstVirusURL = substr($AgainstVirusURL,1);
						
						
						$results2= $paged_data['data'][0];
								
						$LinkRecord = '<a  title="view more information" href= "http://i.uestc.edu.cn/ACovPepDB/browse.php?ACovPid='
							.$results['ACovPid'].'">'.$results['ACovPid'].'</a>';
						$AgainstVirus_array = (explode(":",$results['AgainstVirus']));
						$AgainstVirus_name = $AgainstVirus_array[0];
						$AgainstVirus_ID = $AgainstVirus_array[1];
						echo '<tr><td align="center">'.$LinkRecord.'</td>';
						if ($AgainstVirus_ID == NULL){
 
						echo '<td align="left"><p>'.$AgainstVirus_name.'<a target="_blank" href="https://www.uniprot.org/taxonomy/'.$AgainstVirusURL.'">'.$AgainstVirus_ID.'</a></p></td>';
						}
						else{
 
						echo '<td align="left"><p>'.$AgainstVirus_name.' : <a target="_blank" href="https://www.uniprot.org/taxonomy/'.$AgainstVirusURL.'">'.$AgainstVirus_ID.'</a></p></td>';
						}

						echo '<td align="center">'.$results['InhibitionValueType'].'</td><td align="left">'.$results['InhibitoryEffect'].'</td><td align="center">'.$results['InhibitoryUnit'].'</td>
						<td align="left"><a target="_blank" href="http://i.uestc.edu.cn/ACovPepDB/browse_target_table.php?TargetID='.$results['TargetID'].'">'.$row2[1].'</a></td>

						
						<td align="left"><a href="http://i.uestc.edu.cn/ACovPepDB/browse.php?ACovPid='
							.$results['ACovPid'].'">more</a></td></tr>';
						
					}
					echo '</table><br />';

					saypager("acovpdb", $paged_data['links']);
					
					
				}
				
				if ($ACovPid!="")  {
					echo '<br /><table id="center"> <tr bgcolor="#0196c1"><td colspan="2" class="td1"><font color="#FFFFF7">General information</font></td></tr>';
			                echo '<tr><td width="20%">ACovPid:</td><td>'.$row[0].'</td></tr>';
					echo '<tr><td width="20%">Trivial Name:</td><td>'.$row[1].'</td></tr>';			
                                        //echo '<tr><td width="20%">Trivial Name:</td><td><a target="_blank" href="https://www.ncbi.nlm.nih.gov/protein/'.$row[1].'"><b>'.$row[1].'</b></a></td></tr>';
                                        
					if (($row[3]>80) && ($row[3]<200)){
					$seq_arr = str_split($row[2],70);
					$seq_result = $seq_arr[0].' '.$seq_arr[1].' '.$seq_arr[2];
					echo '<tr><td width="20%">Amino Acids Sequence:</td><td>'.$seq_result.'</td></tr>';
					
					}
					else{
					echo '<tr><td width="20%">Amino Acids Sequence:</td><td>'.$row[2].'</td></tr>';
					}
					
					
					echo '<tr><td width="20%">Length:</td><td>'.$row[3].'</td></tr>';
					
	
					echo '<tr><td width="20%">C-Terminal Modification:</td><td>';
					if($row[4]=="None"){
						echo 'None</td></tr>';			
					}else{
						echo '<a title="Modification Information" href="http://i.uestc.edu.cn/ACovPepDB/browse_modification_table.php?ModificationID='.$row3[0].'"><b>'.$row3[1].'&nbsp&nbsp</b></a>';			
					}
					echo '</td></tr>';

					echo '<tr><td width="20%">N-Terminal Modification:</td><td>';
					if($row[5]=="None"){
						echo 'None</td></tr>';			
					}else{
						echo '<a title="Modification Information" href="http://i.uestc.edu.cn/ACovPepDB/browse_modification_table.php?ModificationID='.$row4[0].'"><b>'.$row4[1].'&nbsp&nbsp</b></a>';			
					}
					echo '</td></tr>';					



	
					echo '<tr><td width="20%">Chemical Modification:</td><td>';
					if($row[6]=="None"){
						echo 'None</td></tr>';			
					}else{
						$midifytime = substr_count($row[6],';');
						for ($midifyloop = 1; $midifyloop  <= $midifytime; $midifyloop++) {
							$array = explode(';', $row[6]);						
						
						}
						for ($midifyloop = 0; $midifyloop  < $midifytime; $midifyloop++) {
							if($array[$midifyloop][0]==' '){
								$outputmodify = substr($array[$midifyloop], 1); 
							}else{
								$outputmodify = $array[$midifyloop];
							}
							//echo ''.$outputmodify[0].''.$outputmodify[1].'';
							echo '<a title="Modification Information" href="http://i.uestc.edu.cn/ACovPepDB/browse_modification_table.php?ModificationID='.$row5[0].'"><b>'.$outputmodify.';&nbsp&nbsp</b></a>';
							//echo '<a title="Modification Table" href="http://i.uestc.edu.cn/ACovPepDB/browse_modification_table.php"><b>'.$array[$midifyloop].';&nbsp&nbsp</b></a>';
						
						}
					}				
					echo '</td></tr>';









					
					$PeptideSourceURL = explode(":",$row[7])[1];
					$PeptideSourceURL = substr($PeptideSourceURL ,1);
					$PeptideSource_array = (explode(":",$row[7]));
					$PeptideSource_name = $PeptideSource_array[0];
					$PeptideSource_ID = $PeptideSource_array[1];
					if ($PeptideSource_name == ""){
					echo '<tr><td width="20%">Peptide Source:</td></tr>';
					}else{
                                        echo '<tr><td width="20%">Peptide Source:</td><td align="left"><p>'.$PeptideSource_name.' : <a target="_blank" href="https://www.uniprot.org/taxonomy/'.$PeptideSourceURL.'">'.$PeptideSource_ID.'</a></p></td></tr>';
					}

                                        echo '<tr><td width="20%">Source Description:</td><td>'.$row[8].'</td></tr>';	

					$AgainstVirusURL = explode(":",$row[9])[1];
					$AgainstVirusURL = substr($AgainstVirusURL ,1);
					$AgainstVirus_array = (explode(":",$row[9]));
					$AgainstVirus_name = $AgainstVirus_array[0];
					$AgainstVirus_ID = $AgainstVirus_array[1];
					if ($AgainstVirus_ID == NULL){

					echo '<tr><td width="20%">Against Virus:</td><td align="left"><p>'.$AgainstVirus_name.'<a target="_blank" href="https://www.uniprot.org/taxonomy/'.$AgainstVirusURL.'">'.$AgainstVirus_ID.'</a></p></td></tr>';
					}
					else{

					echo '<tr><td width="20%">Against Virus:</td><td align="left"><p>'.$AgainstVirus_name.' : <a target="_blank" href="https://www.uniprot.org/taxonomy/'.$AgainstVirusURL.'">'.$AgainstVirus_ID.'</a></p></td></tr>';
					}
					//if ($row[1]=="A7TMA9"||$row[1]=="H2J4R4"){
                                        //echo '<tr><td width="20%">ProteinSequence:</td><td><a target="_blank" href="https://www.uniprot.org/uniprot/'.$row[1].'.fasta"><b>'.$row[1].'.fasta</b></a></td></tr>';
					//}
                                        //else{
                                        //echo '<tr><td width="20%">ProteinSequence:</td><td><a target="_blank" href="https://www.ncbi.nlm.nih.gov/protein/'.$row[1].'?report=fasta"><b>'.$row[1].'.fasta</b></a></td></tr>';
                                        //}
                                        echo '<tr><td width="20%">Inhibition Value Type:</td><td>'.$row[10].'</td></tr>';
					echo '<tr><td width="20%">Inhibitory Effect:</td><td>'.$row[11].'</td></tr>';
					echo '<tr><td width="20%">Inhibitory Unit:</td><td>'.$row[12].'</td></tr>';

					
					$row2 = $db->getRow("select * from targetdomain where TargetID = '$row[13]'");
					
                                        echo '<tr><td width="20%">Target Domain Name:</td><td>'.$row2[1].'</td></tr>';
					//echo '<a  target="_blank" href="http://i.uestc.edu.cn/ACovPepDB/browse.php?ACovPid=ACoVP'.$r1.'"><b>ACoVP'.$r1.' ('.$s1.')</b></a>';


					
					

					//echo '<tr><td width="20%">Modification:</td><td>'.$row[10].'</td></tr>';
					echo '<tr><td width="20%">Assay:</td><td>'.$row[14].'</td></tr>';
					//echo '<tr><td width="20%">GeneID:</td><td><a target="_blank" href="https://www.ncbi.nlm.nih.gov/gene/'.$row[10].'"><b>'.$row[10].'</b></a></td></tr>';						
                                        echo '<tr><td width="20%">Assay Description:</td><td>'.$row[15].'</td></tr>';			
					echo '<tr><td width="20%">Anti-CoV activity in vivo:</td><td>'.$row[16].'</td></tr>';
					//echo '<tr><td width="20%">Reference:</td><td>'.$row[15].'</td></tr>';
					echo '<tr><td width="20%">Reference:</td><td><a title="PMID" target="_blank" href="https://pubmed.ncbi.nlm.nih.gov/'.$row[17].'"><b>'.$row[17].'</b></a></td></tr>';
					echo '<tr><td width="20%">Comment:</td><td>'.$row[18].'</td></tr>';

					
					
					
					$basicpath = "http://i.uestc.edu.cn/ACovPepDB/jmol/PDB/";
					$filepath = $basicpath.$row[0].".pdb";
					$fileExists = @file_get_contents($filepath ,null,null,-1,1) ? true : false ;

					if($fileExists){
						echo '<tr><td width="20%">3D structure:</td><td align="left"><p><a target="_blank" href="http://i.uestc.edu.cn/ACovPepDB/3dstructure.php?ACovPid='.$row[0].'">Structure'.$row[0].'</a></p></td></tr>';
					}else{
						echo '<tr><td width="20%">3D structure:</td><td align="left"><p><a target="_blank" href="http://i.uestc.edu.cn/ACovPepDB/3dstructure.php?ACovPid='.$row[0].'"></a></p></td></tr>';
					}
					//if(in_array($row[0],$structureexistarray)){
					//	echo '<tr><td width="20%">3D structure:</td><td align="left"><p><a target="_blank" href="http://i.uestc.edu.cn/ACovPepDB/3dstructure.php?ACovPid='.$row[0].'"></a></p>'.$filepath.'</td></tr>';
					//}else{
					//	echo '<tr><td width="20%">3D structure:</td><td align="left"><p><a target="_blank" href="http://i.uestc.edu.cn/ACovPepDB/3dstructure.php?ACovPid='.$row[0].'">Structure'.$row[0].'</a></p></td></tr>';
					//}
					echo '<tr><td width="20%">Structure Experiment Verified:</td><td>'.$row[19].'</td></tr>';



					


						echo '<tr><td width="20%">Similar Peptides:</td>';
						echo '<td>';

						if($r1!=""){
						//echo '<a  target="_blank" href="http://i.uestc.edu.cn/ACovPepDB/browse.php?ACovPid=ACoVP'.$r1.'"><b>ACoVP'.$r1.' ('.$s1.')</b></a>
						echo '<a  target="_blank" href="http://i.uestc.edu.cn/ACovPepDB/browse.php?ACovPid=ACoVP'.$r1.'"><b>ACoVP'.$r1.' </b></a>
						&nbsp&nbsp';}

						if($r2!=""){
						echo '<a  target="_blank" href="http://i.uestc.edu.cn/ACovPepDB/browse.php?ACovPid=ACoVP'.$r2.'"><b>ACoVP'.$r2.' </b></a>
						&nbsp&nbsp';}
						
						if($r3!=""){
						echo '<a  target="_blank" href="http://i.uestc.edu.cn/ACovPepDB/browse.php?ACovPid=ACoVP'.$r3.'"><b>ACoVP'.$r3.' </b></a>
						&nbsp&nbsp';}
						
						if($r4!=""){
						echo '<a  target="_blank" href="http://i.uestc.edu.cn/ACovPepDB/browse.php?ACovPid=ACoVP'.$r4.'"><b>ACoVP'.$r4.' </b></a>
						&nbsp&nbsp';}
						
						if($r5!=""){
						echo '<a  target="_blank" href="http://i.uestc.edu.cn/ACovPepDB/browse.php?ACovPid=ACoVP'.$r5.'"><b>ACoVP'.$r5.' </b></a>';
						}

						echo '</td>';
						//echo '<td>'.$seq.'</td>';
						echo '</tr>';

						
						}

					}

					echo '</table>';
					if($row2[0]!=NULL)
					{
						
					
					echo '<br /><table id="center"> <tr bgcolor="#0196c1"><td colspan="2" class="td1"><font color="#FFFFF7">Target Domain information</font></td></tr>';
                                        echo '<tr><td width="20%">Target Domain Full Name:</td><td>'.$row2[2].'</td></tr>';
					echo '<tr><td width="20%">Target Type:</td><td>'.$row2[3].'</td></tr>';
					$none = "None";
					$seq_array = (explode(" ",$row2[5]));
					$seq_name = $seq_array[0];
					$seq_ID = $seq_array[1];

					
	                                

					
					echo '<tr><td width="20%">Target Synonyms:</td><td>'.$row2[6].'</td></tr>';


					$TargetSourceURL = explode(":",$row2[7])[1];
					$TargetSourceURL = substr($TargetSourceURL ,1);
					$TargetSource_array = (explode(":",$row2[7]));
					$TargetSource_name = $TargetSource_array[0];
					$TargetSource_ID = $TargetSource_array[1];
					
					if ($TargetSource_ID == NULL){

					echo '<tr><td width="20%">Target Source:</td></tr>';
					}
					else{

					echo '<tr><td width="20%">Target Source:</td><td align="left"><p>'.$TargetSource_name.' : <a target="_blank" href="https://www.uniprot.org/taxonomy/'.$TargetSourceURL.'">'.$TargetSource_ID.'</a></p></td></tr>';
					}				


					echo '<tr><td width="20%">Target Structure:</td><td>'.$row2[8].'</td></tr>';


                                         
					
                                         
					echo '</table>';
					
					

					
                                                                                 
					echo '</table>';
					
					}



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

-->
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
