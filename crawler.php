<?php

$URL      = $argv[1];
$choice   = $argv[2];
$username = "tyler.franzen@undcsmysql";
$database = "tyler_franzen";
$password = "tyler8629";
$host     = "undcsmysql.mysql.database.azure.com";
$conn     = new mysqli( $host,  $username, $password, $database );

if ( $conn->connect_error )
  die( 'Could not connect: ' . $conn->connect_error );

    ############ HERE IS THE TITLE ################
    system("rm page.txt /home/tyler.franzen/public_html/cgi-bin/2A525");
    system("touch page.txt /home/tyler.franzen/public_html/cgi-bin/2A5251");
    system("chmod 777 page.txt /home/tyler.franzen/public_html/cgi-bin/2A525");
    $cmd = "lynx -dump -source -nolist \"" . $URL . "\" > page.txt";
    system($cmd);

    $title = "title";
    $x = "\"<";
    $y = ">\"";
    $z = "$x$title$y";
    system("rm title.txt /home/tyler.franzen/public_html/cgi-bin/2A525");
    system("touch title.txt /home/tyler.franzen/public_html/cgi-bin/2A525");
    system("chmod 777 title.txt /home/tyler.franzen/public_html/cgi-bin/2A525");
    $cmd = "grep -i $z page.txt > title.txt";
    system($cmd);
    $myfile = fopen("title.txt", "r") or die("Unable to open file!");
    $temp = fgets($myfile);
    fclose($myfile);

    $z = "<title>";
    $pos = stripos($temp, $z);
    $pos = $pos + 7;
    $a = "\"</";
    $b = ">\"";
    $c = "$a$title$b";
    $c = "</title>";
    $length = stripos($temp, $c, $pos);
    $length = $length - $pos;
    $clean_title = substr($temp, $pos, $length);



    ######## HERE IS THE KEYWORD START #############
    $desc = "meta name=\\\"keywords\\\" content=\\\"\"";
    $x = "\"<";
    $z = "$x$desc";
    system("rm keyword.txt /home/tyler.franzen/public_html/cgi-bin/2A525");
    system("touch keyword.txt /home/tyler.franzen/public_html/cgi-bin/2A525");
    system("chmod 777 keyword.txt /home/tyler.franzen/public_html/cgi-bin/2A525");
    $cmd = "grep -i $z page.txt > keyword.txt";
    system($cmd);

    $myfile = fopen("keyword.txt", "r") or die("Unable to open file!");
    $temp = fgets($myfile);
    fclose($myfile);

    $desc = "meta name=\"Keywords\" content=\"";
    $x = "\"<";
    $z = "$x$desc";
    $z = "<meta name=\"Keywords\" content=";
    $pos = stripos($temp, $z);
    $pos = $pos + 31;
    $z = "\">";
    $length = stripos($temp, $z, $pos);
    $length = $length - $pos;
    $clean_keywords = substr($temp, $pos, $length);


    ######## HERE IS THE DESCRIPTION START #############
    $desc = "meta name=\\\"Description\\\" content=\"";
    $x = "\"<";
    $z = "$x$desc";
    system("rm description.txt /home/tyler.franzen/public_html/cgi-bin/2A525");
    system("touch description.txt /home/tyler.franzen/public_html/cgi-bin/2A525");
    system("chmod 777 description.txt /home/tyler.franzen/public_html/cgi-bin/2A525");
    $cmd = "grep -i $z page.txt > description.txt";
    system($cmd);

    $myfile = fopen("description.txt", "r") or die("Unable to open file!");
    $temp = fgets($myfile);
    fclose($myfile);

    $desc = "meta name=\"Description\" content=\"";
    $x = "\"<";
    $z = "$x$desc";
    $z = "<meta name=\"Description\" content=";
    $pos = stripos($temp, $z);
    $pos = $pos + 34;
    $z = "\">";
    $length = stripos($temp, $z, $pos);
    $length = $length - $pos;
    $clean_description = substr($temp, $pos, $length);


$max = 1000;
$array = array();
word_end($max, $array);
$wordend = (array_count_values($array));
print_r ($wordend);

echo "URL CRAWLED: \n";
echo $URL;
echo "\n\n";

# Dump the source code to the file result.txt.
$cmd = "lynx -dump -listonly '" . $URL . "' | grep '" . $URL . "' > result.txt";
system( "chmod 777 result.txt " );
system( $cmd );
system( "chmod 755 result.txt " );

echo "\n\n";
echo $cmd;
echo "\n\n";

# Find the url/title/desc/keyword.
$file    = file_get_contents( "result.txt" );
$title   = file_get_contents( "title.txt" );
$desc    = file_get_contents( "description.txt" );
$keyword = file_get_contents( "keyword.txt" );



##### HERE IS THE START OF THE TEST ######


$handle = fopen("result.txt", "r");
/*if ($handle) {
    while (($line = fgets($handle)) !== false) {
	echo "HERE IS THE START OF THE LINE: \n";
	echo $line;
	echo "\nFINISHED\n";
	$cmd = "lynx -dump -source -nolist . $line .  > index.txt";
	//$cmd = "lynx -dump $line > index.txt";
    	system( "chmod 777 test.txt " );
    	system( $cmd );
	echo $cmd;
    	system( "chmod 755 test.txt " );
    }

    fclose($handle);
}*/









### HERE IS THE END OF THE TEST ########




$query = "SELECT count(1) FROM url";
$result = $conn->query($query);
$row = $result->fetch_assoc();

$open = fopen('result.txt','r');

while (!feof($open)) {
        $getTextLine = fgets($open);
        $explodeLine = explode(",",$getTextLine);

        list($urls) = $explodeLine;

        $sql = "insert into url (urlID,url2,title,keywords,description) values ('urlID','$urls','$title','$keyword','$desc')";
        $conn->query($sql);


	// POTENTIAL TO BE $urls NOT SURE YET
        /*$query = "SELECT url2 FROM url WHERE url = '$urls'";
	$result = $conn->query($query);
	*/
	$query = "SELECT url2 FROM url";
	$result = $conn->query($query);
	//echo ("Here: " . $query . "\n");

        if ($result->num_rows > 0) {
	    $row = $result->fetch_assoc();
            $urlID = $row['url2'];
	    index_page($urls, $max, $wordend, $urlID, $conn, $clean_title, $clean_keywords, $clean_description);
        }

       //index_page($urls, $max, $wordend, urlID, $conn, $clean_title, $clean_keywords, $clean_description);
} 
fclose($open);



function index_page($urls, $max, $wordend, $urlID, $conn, $clean_title, $clean_keywords, $clean_description) {
    $indexArray = array();


    //echo "THIS IS A TEST TO SEE WHERE IT FAILS";

    system("rm test.txt /home/tyler.franzen/public_html/cgi-bin/2A525");
    system("touch test.txt /home/tyler.franzen/public_html/cgi-bin/2A525");
    system("chmod 777 test.txt /home/tyler.franzen/public_html/cgi-bin/2A525");
    $cmd = "lynx -dump -nolist $urls > test.txt";
    system( "chmod 777 test.txt " );
    system( $cmd );
    system( "chmod 755 test.txt " );

    echo "\n\n HERE IS WEHERE IT SSTARTS \n";
    echo "AND WHERE IT ENDS \n\n";

    $file    = file_get_contents( "test.txt" );

    echo $file;
    echo "ALS O ENDS";

    //system( $cmd );
    //echo $cmd;

    $myfile = fopen('test.txt', 'r');

    while (!feof($myfile))
    {
        $line = fgets($myfile);
        $chars = array( ";", ">", "<", "=", ":", "*", "|", ",", "+", "(", ")", "[", "]", "&", "$", ".", "-", "'", "?", "/", "\"", "#", "{", "}", "!", "_", "%", "@", "~");
        $line = str_replace($chars, " ", $line);
        $line = stripslashes($line);
        echo ("line: " . $line . "\n");

        $array = explode(" ", $line);
        echo ("temp_cnt: " . count($array) . "\n");
        print_r($array);

        for ($x = 0; $x < count($array); $x++)
        {
	    echo ("word: " . $array[$x] . "\n");
            if ($array[$x] != "")
            {
                array_push($indexArray, $array[$x]);
		echo "MADE IT HEREEEEEEE";
            }
        }       
    }
    $word_array = array_count_values($indexArray);
   
    //echo "\n";
    echo "THIS IS A TEST RIGHT HERE TO SEE LOOPS";
    echo "\n";
    $result = array_diff_ukey($word_array,$wordend,"switch");
    echo ("stopwords: " . count($wordend) . " words: " . count($word_array) . " result: " . count($result) . "\n");


    foreach($result as $key => $key_count)
    {
        if (stripos($clean_title, $key) != FALSE)
        {
            $key_count++;
            echo ("Title Key: " . $key . " new count: " . $key_count . "<br>");
        }

        $query = "INSERT INTO inverted_index (urlID, count, word) VALUES (" . $urlID . ", " . $key_count . ", \"" . $key . "\")";
	$conn->query($query)
    }

    fclose($myfile);
}


$conn->close( );


function word_end (&$max, &$array) {
    $myfile = fopen("words.txt", "r") or die("Unable to open file words.txt.");
    $count = 0;

    while (!feof($myfile) && ($count < $max)) {
        $array[$count] = trim(fgets($myfile));
        $count++;
    }

    if ($count < $max) {
        $max = $count;
    }

    echo ("Stopword: " . $array[1]);
    fclose($myfile);
}

function switch($first,$second) {
    if ($first===$second) {
        return 0;
    }
    return ($first>$second)?1:-1;
}

?>
