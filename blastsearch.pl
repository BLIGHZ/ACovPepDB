#!/usr/bin/perl -w
use strict;
use CGI qw/:standard/;
use File::Copy;

my $BlastHead ="ACovPBlast: Powered by BLASTP 2.2.31+ and the ACovPepDB.\r\nDatabase file: acovpepdb.fa, version 1.0, with 214 sequences and 6,482 total letters.\r\n\r\n\r\n\r\nResult lines begin:\r\n\r\n\r\n";


#########################
# Main Programme Start
#########################

	if (not param) {
		make_query_page();
	}
	else {
		make_result_page();
	}


#########################
# Subrutines start
#########################

sub make_query_page{

	####----advanced search parameter

	my $evalue = textfield({'name'=>'evalue','size'=>7,'maxlength'=>5, 'value'=>10,
		'title'=>'Expected number of chance matches in a random model. By default 10.'
		});
	my $max_results = textfield({'name'=>'max_length','size'=>7,'maxlength'=>3, 'value'=>300,
		'title'=>'Maximum number of aligned sequences to display. By default 300.' 		
		});
	my $blastp_short = checkbox_group({'name'=>'short_default', 
		'values'=>'Optimized parameters for short peptide (<15 residues)',
		'title'=>'Word size 2, no SEG, PAM30, gap open 9, gap extension 1, evalue 20000!',
		onchange=>"ShortChecked();"
		});

	####----default search parameter
	my $user_seq = textarea({'name'=>'mimotope','cols'=>'48','rows'=>'8',
		'title'=>'Input or paste your peptides here in FASTA or raw sequence format!'
		});
	my $user_upload = filefield({'id'=>'upload_button','name'=>'upload_file','size'=>20,
		'title'=>'Select and upload your peptide sequence file in FASTA or raw sequence format!'
		});

	my $example_button = button({'name'=>'', 'value'=>'Example',
		'title'=>'Click the button to load the example data!',
		onclick=>"ExampleMimoBlast();"});
	my $submit_button = submit({'id'=>'submit_button','name'=>'submit','value'=>'BLAST',
		'title'=>'Click the button will start the blast!'
		});
	my $reset_button = reset({'name'=>'reset','value'=>'Reset',
		'title'=>'Click the button will clear all your inputs!'
		});

	####----query table
	my $MainPanel= table(
            Tr([
                th(['Enter a set of peptide sequences in the text area below:']),
                td([$user_seq]),
                td(['<b>Or upload a sequence file: </b>'.$user_upload]),
                td(['&nbsp;']),
				th(['Expect value: '.$evalue.'&nbsp;&nbsp;&nbsp;&nbsp;Max results: '.$max_results]),
                th([$blastp_short]),
                td(['&nbsp;']),
				td([$example_button.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$reset_button.
					'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$submit_button]),
            ]),
		);
		
	my $query = div({'id'=>'content'},p({'class'=>'p3'},'BLAST-Search page assists users in performing BLAST search against the peptides stored in ACovPepDB. User can submit their peptides with desired BLAST options for performing similarity search. This tool will returns the BLAST output containing list of peptides similar to the query peptide. For more information see HELP page. '), div({'id'=>'nb'}, $MainPanel));
		
	####-----query page

	my $start_form = start_multipart_form;
####    Modified by Bifang He on Dec 10, 2015
####    my $end_form = endform;
	my $end_form = end_form;
	my $query_content = $start_form.$query.$end_form;

	####----make query page

	make_basic_page($query_content);
}

sub make_result_page{
	my $result_table;
	
	my ($report) = url_param('File');
	if ($report) {
		my $what;
		my $where = $tmp_dir."/$report";

		open REPORT,$where or die(make_error_page($!));
		while (defined(my $line = <REPORT>)) {$what.= $line;}
		$result_table= div({'id'=>'content'},pre($what));
	}

	else{
		####----get user input or upload mimotopes
		my $seq = param('mimotope');
		if ($seq =~/</){
	    $seq = ""; #check input. Figure out xss problem.// added by Bifang He on May 5, 2015
	    }
		my $load_file = upload('upload_file');

		####----check user input, get unique seqs
		my $seqs = check_user_input($seq,$load_file);
	
		####----save_mimotopes to local PC
		my ($mimotop_tmp,$run_time)= save_mimotopes(@$seqs);
	
		####----run blastp to get the result
		my ($result_file_name) = run_blastp($mimotop_tmp,$run_time);
	
		####----parse the result file to get information
		my $final_result = parse_result($result_file_name,$seqs,$run_time);

		####----create the result table
		my $downfile = substr($result_file_name, 34);
		my $downlink = a({'-href'=>"../temp/$downfile.gz",'Title'=>'Download full blast result file','target'=>'_blank'},img({'src'=>'../image/image/download.gif','align'=>'absmiddle','hspace'=>'8'}));
		my $thead = th(['Your Query Peptide','Similar Peptide in ACovPepDB','Blast Report'.$downlink]);

		$result_table = div({'id'=>'content'},p({'class'=>'p3'},'The ACovPBlast results are summarized in the table below. Move your mouse over the hyperlinked peptide sequences one by one, you can view aligment in pairs on the fly through the pop-up browser windows. You can also read the report file for each query sequence or download all the report in a compressed archive by click the corresponding links or icons.'), table(Tr($thead), @$final_result));
	}

	make_basic_page($result_table);
}

sub make_basic_page{	

	my($content) = @_;

	####----create the basic page

		print header(-charset => 'UTF-8');

 
print div({'id'=>'wrap'},
			 div({'id'=>'header'},
				
				div(img({'src' => "../images/LOGO.png"}),
			    	div({'id'=>'headermenu'},
					div({'class'=>'headermenu'}, 

							
								div({'class'=>'headerm'},

								ul(
									li(a({'href'=>'../index.html'},'HOME')),
			                    				li(a({'href'=>'../browse.php'},'BROWSE')),
									li(a({'href'=>'../search.php',},'SEARCH')),
				                			li(a({'id'=>'current','style'=>'color:black', 'href'=>'../cgi-bin/blastsearch.pl'},'ACovPBlast')),
									li(a({'href'=>'../download.html'},'DOWNLOAD')),
                                   					li(a({'href'=>'../feedback.php'},'FEEDBACK')),
                   							li(a({'href'=>'../help.html'},'HELP'))
								),
								),
							
						
						
					),
				),
				),
			),
		);
		
		
		
		




		

	####----make_basic_ page end
}

sub make_error_page{
	####----say errors
		my($error)=@_;
		my $message = p({'class'=>'p3'},'<b>ERROR: </b>'.$error,br,br);
		my $error_image = p({'align'=>'center'},img({'src'=>"../image/image/error.png"}));
		my $result_error = div({'id'=>'content'}, $message, $error_image);
	
	####----create error page
		
		make_basic_page($result_error);

	####----make_error_page end
}

sub check_user_input{

	my ($SeqsData,$UserSideFile) = @_;
	my $RawSeq;

	if ( ($SeqsData eq '') and ($UserSideFile eq '') ){
		make_error_page("<b>sequence input error!</b> No sequence is input, or no sequence file is uploaded. Please enter or paste peptides into the text area in FASTA or raw sequence format. Alternatively, upload a file in FASTA or raw sequence format.");
	}

	if ( ($SeqsData ne '') and ($UserSideFile ne '') ){
		make_error_page("<b>sequence input error!</b> Sequence overloaded! You can either enter a set of peptide sequences into the text area or upload a file in FASTA or raw sequence format. Do not submit sequences through the text area and the file box simultaneously.");
	}

	if ( ($SeqsData ne '') and ($UserSideFile eq '') ){
		my @lines = split /^/, $SeqsData;
		$RawSeq = checkFileFormat( (\@lines) );
	}

	if ( $UserSideFile ne '' and ($SeqsData eq '') ){
		my $ServerSideFile = tmpFileName($UserSideFile);
		open(fhSEQ,$ServerSideFile);
		my @lines = <fhSEQ>;
		$RawSeq = checkFileFormat( (\@lines) );
	}

	return unique(@$RawSeq);
}

sub checkFileFormat{
	my($lines) = @_;
	my $RawSeq;

	foreach my $line(@$lines){
		# skip fasta annotation line
		if ($line =~ /^\>/){
			next;
		}
		# skip blank line
		elsif ($line =~/^\s*$/) {
			next;
		}
		else{
			my $RawSeqLine = uc(trim($line)); 
			if ($RawSeqLine =~ /[^ACDEFGHIKLMNPQRSTVWY]/){
				make_error_page("<b>unsupported file format or residue abbreviation!</b> Pay attention to <b>$line!</b>. At present, the ACovPBlast tool only supports sequence in FASTA or raw format. Besides, only the standard IUPAC one-letter codes for the amino acids ( <i> i.e.</i> A, C, D, E, F, G, H, I, K, L, M, N, P, Q, R, S, T, V, W, Y) are supported.");} 

			if (length($RawSeqLine) < 3 or length($RawSeqLine) > 40){
				make_error_page("<b>unsupported sequence length!</b> Pay attention to <b>$line!</b>. The ACovPBlast tool accepts peptide sequence at least with 3 residues and no longer than 40 residues, as all peptides in the ACovPepDB is 3-40 residues long.");}

			push @$RawSeq, $RawSeqLine;
		}
	}
	return $RawSeq;
}


sub run_blastp{
	####----get the mimotope array from make_result_page subrutine
	
		my ($query_seq,$run_time) = @_;
	
	####----parameters for advanced search

		my $e_value = param('evalue');
		my $max_result = param('max_length');
		my $short_blastp = param('short_default');
	
	####----blastp direction
	
		my $blast_dir = "/usr/local/bin";
		my $blastp_dir = "$blast_dir/blastp";
	
	####----outfile name
		

	
	####----the database name
		


	####----create blastp function

		my $blastp = "$blastp_dir -query $query_seq -db $db_name -out $out_file_name";

	####----check the advanced search parameter value
		
		if ($short_blastp) {
			$blastp .= ' -task blastp-short -word_size 2 -seg no -evalue 20000 -matrix PAM30 -gapopen 9 -gapextend 1'; 
		}
		else{
			$blastp .= ' -task blastp -word_size 3 -seg yes -matrix BLOSUM62 -gapopen 11 -gapextend 1';
			if ($e_value) {
				$blastp .= ' -evalue '.$e_value;
			}
			else {
				$blastp .= ' -evalue 10';
			}
		}
		if ($max_result) {
			$blastp .= ' -max_target_seqs '.$max_result;
		}
		else {
			$blastp .= ' -max_target_seqs 300';
		}
		
	
	####----run blastp

		my $system_check = system($blastp);

	####----check if the output file exists

		if (-e $out_file_name) {
			my $downfile = $out_file_name.".gz";
			`gzip -c9 $out_file_name > $downfile`;
			return ($out_file_name);
		}
		else {
			make_error_page('<b>blast error!</b> Blast report file does not exist. Please tell us the problem through the <a href="mailto:hj\@uestc.edu.cn" >Feedback</a> link on the bottomn of the website. We will solve it as soon as possible. Thank you very much!');
		}

	####----run_blastp end
}

sub parse_result{
	####----blast output file name and query sequences and timestamp as input
	my ($file_name,$mimotopes,$run_time) = @_;
	
	####----@final_result for saving all query sequences; @mimo_result for saving each query sequence
	my (@final_result,@mimo_result);
	
	####----open the output file 
	open RESULT,$file_name or die(make_error_page($!));

	####----$count for each result file name 
	####----$open_result is a switch for opennig one file to print result into it 
	####----$print_on is a switch for print or not
	####----$turn is a switch for beginning a new @mimo_result
	my $count = 1;
	my $open_result = 0;
	my $print_on = 0; 
	my $turn = 0;
	my $numberasd = 0;
	####----parse the output file
	while (defined(my $line = <RESULT>)) {

		####----each query sequence begin with a 'Query='
		if ($line =~ /^Query=/) {
			$print_on = 1;
			$open_result = 1;
		}
		my $result_name = "Report ".$count;
		my $local_result_name = "ACovPBlastResult".$run_time.'.part'.$count;
			open ONE,">$tmp_dir/$local_result_name" or die(make_error_page($!)) if $open_result;
			if ($open_result == 1) {
				print ONE $BlastHead; #print the report head
				$open_result = 0;
			}
			if ($print_on == 1) {
				print ONE $line;
			}

			####----each query sequence end with 'Effective search space used:'
			if ($line =~ /^Effective search space used:/) {
				$print_on = 0;
				$turn = 1;
				close ONE;
				$count++;
			}

			####----get the MimoID
			if ( $line =~ /^> (BiopanningDataSet ID: \d+; Peptide \d+-?\d?: \w+)/ ) {
				$line = $1;
				#print "$1";#$1 mean: hello world !
				my $line2 = ~ /^> (BiopanningDataSet ID: \d+; Peptide \d+-?\d?: \w+)/;
				my $similar;
				if ($mimo_result[-1]) {
					my $num = 0;
					while ($num <= $#mimo_result) {
						if ($line eq $mimo_result[$num]) {
							$similar = 0;
							last;
						}
						else {
							$similar = 1;
						}
						$num++;
					}
					if ($similar == 1) {
						push (@mimo_result,$line);
					}
				}
				else {
				

				
				

				push @mimo_result,$line;

				
				}
			}

			####----get the information from @mimo_result and value it as ''
			if ($print_on == 0 and $open_result == 0 and $turn == 1 ) {
				my $result_file = a({'-href'=>"./blastsearch.pl?File=$local_result_name",'Title'=>'View it','target'=>'_blank'},$result_name."&nbsp;&nbsp;". img({'src'=>'../image/image/viewer.gif', 'align'=>'absmiddle'}));

				####----if no subject is found ,the MimoID will be 'No hits found'
				if (!$mimo_result[-1]) {
					push @mimo_result,td("No hits found!");
					my $return_result = Tr(td(shift(@$mimotopes)),$mimo_result[-1],td($result_file));
					push @final_result,$return_result;
				}
				else {
					my $j = 0;
					while ($j <= $#mimo_result) {
						if ($mimo_result[$j] =~ /BiopanningDataSet ID: (\d+); Peptide \d+-?\d?: (\w+)/ ) {
							my $acovpid = "AcoVP" . $1;
							$mimo_result[$j] = td($2." in ACovPepDB: ". a({'href'=>"http://i.uestc.edu.cn/ACovPepDB/browse.php?ACovPid=$acovpid",'Title'=>'Visit it','target'=>'_blank'},$acovpid));
						}
						$j++;
					}
					my $rowspan = scalar(@mimo_result);
					my $return_result = Tr(td({'rowspan'=>"$rowspan"},shift(@$mimotopes)),shift(@mimo_result),td({'rowspan'=>"$rowspan"},$result_file),Tr([@mimo_result]));
					push @final_result,$return_result;
				}	
				@mimo_result = qw//;
				$turn = 0;
			}
			
		}
		#$numberasd = 0;
		#while ($numberasd  <= $#mimo_result) {
		#	print "\$1 mean: $1";#$1 mean: hello world !
		#		if ($mimo_result[$numberasd] =~ /BiopanningDataSet ID: (\d+); Peptide \d+-?\d?: (\w+)/ ) {
		#			my $acovpid = "AcoVP" . $1;
		#			$mimo_result[$numberasd] = td("asd");
		#		}
		#		$numberasd ++;}
	####----close the output filehandle and return the @final_result

		close RESULT;
		return \@final_result;

	####----parse_result end
}

#Delete redundant sequence added by Jian Huang 2011-8-15
sub unique {
    my @RawSeq = @_;
	my $filtered;
	my %seen = ();

	foreach my $line(@RawSeq) {
		next if $seen {$line}++;
		push @$filtered,$line;
	}
	return $filtered;
}

sub save_mimotopes{
	####----parameter: @sequences pass the checking
	my (@seqs) = @_;
	
	####----make tempfile unique
	srand(time);
	my $run_time =time.int rand(1000);
			
	####----the local direction for saving the mimotope file 

	open FILE,">$tmp_mimotopes" or make_error_page($!);

	foreach my $seq (@seqs) {
		print FILE ">"."\n";
		print FILE $seq."\n";
	}
	close FILE;
	
	return ($tmp_mimotopes,$run_time);
}

sub trim {
    my @out = @_;
    for (@out) {
        s/^\s+//g;          # trim left
		s/\s+//g;			# trim middle
        s/\s+$//g;          # trim right
    }
    return @out == 1 
              ? $out[0]		# only one to return
              : @out;		# or many
}
