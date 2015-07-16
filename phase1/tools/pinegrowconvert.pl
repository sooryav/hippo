if (@ARGV != 2)
{
  die("Usage: perl pinegrowconvert.pl <inputfile> <outputfile>");
  
}


$in_file = $ARGV[@ARGV - 2];
open INFILE, "<", $in_file or die("Cannot open file");

$out_file = $ARGV[@ARGV - 1];
open OUTFILE, ">", $out_file or die("Cannot open file");


my @tags = ("meta", "input", "br", "link", "img");

#$lineCount = 0;
my $previousTag = "";


while(my $line = <INFILE>) {

  chomp($line);
  if ($line =~ m/DOCTYPE html>/) {
    #ignore line containing this tag
    next;
  }
  
  $line =~ s/method\=\"POST\"/method\=\"post\"/g;
  
  $line =~ s/method\=\"GET\"/method\=\"get\"/g;

  if(($line =~ m/(^\s*)(<)(.*)/) && ($previousTag ne "")) {
    # if the line contains open tag, it is important if there is a previous tag
    print OUTFILE "</$previousTag>\n";
    $previousTag = "";
  }
  elsif (($line =~ m/(<)(.*)/) && ($previousTag ne "")) {
    die("ERROR: found < without closing the $previousTag with no space at the beginning\n");
  }

  my $foundOneTag = 0;
  foreach my $tag (@tags)
  {
    if ($line =~ m/(.*)(<$tag)(.*)(>)(.*)/) {
        
      $foundOneTag = 1;
      
      if ($previousTag ne "")
      {
        die ("ERROR: Recursive missing tags not supported\n");
      }
    
      # Check if the line contains the closing tag
      # This condition is not perfect if closing tag comes before open tag.
      # However, hhbm will catch if we generate incorrect file
      if (($line =~ m/(.*)(<$tag)(.*)(\/>)(.*)/) || ($line =~ m/(.*)(<\/$tag>)(.*)/)) {
        # Nothing to fix, the syntax is correct
        # Line is printed below
        print OUTFILE $line;
        print OUTFILE "\n";
      }
      elsif (($line =~ m/(.*)(<$tag)(.*?)(<)(.*)/)) { 
        # Found a case of ...<br></p> where the closing tag needs to be inserted in between
        print OUTFILE $1 . $2 . $3 . "</$tag>" . $5 . $6 . "\n";
      } else {
        # Closing tag is missing, but 
        # Keep this line in buffer because end tag 
        $previousTag = $tag;
        print OUTFILE $line;
      }
      
    }
    elsif ($line =~ m/(.*)(<$tag)(.*)/) {
      # ERROR, closing > missing, not supported by tool
      die("Closing > missing for tag, not supported by the tool");
    }
  }
  
  
  if ($foundOneTag == 0)
  {
    # The line didn't match any pattern
    if ($previousTag ne "") {
      # its possible that closing tag needs to be added much later
      print OUTFILE "\n";
      print OUTFILE $line;
    }
    else {
      print OUTFILE $line;
      print OUTFILE "\n";
    }
  }
  
}
      

if ($previousTag ne "")
{
  print OUTFILE "</$previousTag>\n";
}

close INFILE;
close OUTFILE;
