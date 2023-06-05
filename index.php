<?php

# Remove leading and trailing spacing.
$URL     = trim( $_POST["URL"] );

# For security, remove some Unix metacharacters.
$meta    = array( ";", ">", ">>", "<", "*", "?", "&", "|" );
$URL     = str_replace( $meta, "", $URL );

if ( $_POST['act'] == "Clear system" ) {
  header( "Content-type: text/plain" );
  system( "/usr/bin/php  clear.php"  );
}

elseif ( $_POST['act'] == "Crawl web pages" ) {
  header( "Content-type: text/plain" );
  system( "/usr/bin/php  crawler.php  $URL $choice" );
}

elseif ( $_POST["act"] == "List web pages" ) {
  header( "Content-type: text/plain" );
  system( "/usr/bin/php  list.php  $PAGE" );
}

elseif ( $_POST["act"] == "Submit choice" ) {
  header( "Content-type: text/plain" );

  $username = "tyler.franzen@undcsmysql";
  $database = "tyler_franzen";
  $password = "tyler8629";
  $host     = "undcsmysql.mysql.database.azure.com";
  $conn     = new mysqli( $host,  $username, $password, $database );

  $kw_array = (explode(" ", $_POST['KEYWORD']));
  $length = count($kw_array);

    if ($kw_array[0] == "")
    {
        echo ("<h2>Keywords not found or entered.</h2><br>");
    }
    else 
    {
        if ($conn->connect_error)
        {
            die('Could not connect: '. $conn->connect_error);
        }

        /* read all the matching records for the given keywords for the chosen fields */
        for ($x = 0; $x < $length; $x++)
        {
            $count = 1;

            if ($_POST['choice'] == "Title")
            {
                $query = "SELECT url2, title FROM url WHERE title LIKE '%" . $kw_array[$x] . "%'";
            }
            elseif ($_POST['choice'] == "Keywords") 
            {
                $query = "SELECT url2, keywords FROM url WHERE keywords LIKE '%" . $kw_array[$x] . "%'";
            }
            elseif ($_POST['choice'] == "Description") 
            {
                $query = "SELECT url2, description FROM url WHERE description LIKE '%" . $kw_array[$x] . "%'";
            }
            elseif ($_POST['choice'] == "All") 
            {
                $query = "SELECT url2, title, keywords, description FROM url WHERE description LIKE '%" . $kw_array[$x] . "%' OR title LIKE '%" . $kw_array[$x] . "%' OR keywords LIKE '%" . $kw_array[$x] . "%'";
            }
            else 
            {
                echo ("Error");
            }

            $result = $conn->query($query);
            if ($result->num_rows > 0)
            {
                while ($row = $result->fetch_assoc())
                {
		    echo "NUMBER " . $count . ": ";
                    echo ($row[url2] . $row[title] . $row[keywords] . $row[description]);
                    $count++;
                }
            }
        }
        echo "</table>";
        $conn->close();
    }
}

elseif ( $_POST["act"] == "Index" ) {
    header( "Content-type: text/html" );

    $username = "tyler.franzen@undcsmysql";
    $database = "tyler_franzen";
    $password = "tyler8629";
    $host     = "undcsmysql.mysql.database.azure.com";
    $conn     = new mysqli( $host,  $username, $password, $database );


    if ($conn->connect_error)
    {
        die('Could not connect: '. $conn->connect_error);
    }

    echo "<table style='font-family:arial; font-size:24px'>
    <tr>
        <th>Keyword</th>
        <th>count</th>
        <th>URL</th>
        <th>Title</th>
    </tr>";

    $query = "SELECT t.urlID, u.url, u.title FROM t_index t, url u";  

    $result = $conn->query($query);

    if ($result->num_rows > 0)
    {
        while ($row = $result->fetch_assoc())
        {
             echo ("$row['word']");
	     // TO ADD MORE WHEN IT COMES THROUGH
        }
    }

    echo "</table>";
    $conn->close();
}

elseif ( $_POST["act"] == "Help" ) {
  header( "Content-type: text/html" );
  $file = fopen( "Help.html", "r" ) or
    exit( "Unable to open file!" );
  while ( !feof( $file ) )
    echo  fgets( $file );
  fclose( $file );
}

else {
  header( "Content-type: text/html" );
  echo( "<html><body>" );
  echo( "<h3>No such option: " . $_POST["act"] . "</h3>" );
  echo( "</body></html>" );
}

?>
