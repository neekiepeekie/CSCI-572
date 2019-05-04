<?php
// make sure browsers see this page as utf-8 encoded HTML
header('Content-Type: text/html; charset=utf-8');
$limit = 10;
$query = isset($_REQUEST['q']) ? $_REQUEST['q'] : false;
$results = false;
if ($query)
{
if( isset($_REQUEST['sort']))
$myalgo =  $_REQUEST['sort'] ;
else
$myalgo = "Lucene";
  // The Apache Solr Client library should be on the include path
  // which is usually most easily accomplished by placing in the
  // same directory as this script ( . or current directory is a Lucene
  // php include path entry in the php.ini)
  require_once('solr-php-client/Apache/Solr/Service.php');
  // create a new solr service instance - host, port, and webapp
  // path (all Lucenes in this example)
  $solr = new Apache_Solr_Service('localhost', 8983, '/solr/myexample');
  // if magic quotes is enabled then stripslashes will be needed
  if (get_magic_quotes_gpc() == 1)
  {
    $query = stripslashes($query);
  }
  // in production code you'll always want to use a try /catch for any
  // possible exceptions emitted  by searching (i.e. connection
  // problems or a query parsing error)
  try
  {
  if($myalgo != "Lucene"){
$sortParam=array('sort' => 'pageRankFile desc');
    }
    else{
   $sortParam =array('sort' => '');
}
    $results = $solr->search($query, 0, $limit, $sortParam);
  }
  catch (Exception $e)
  {
    // in production you'd probably log or email this error to an admin
    // and then show a special message to the user but for this example
    // we're going to show the full exception
    die("<html><head><title>SEARCH EXCEPTION</title><body><pre>{$e->__toString()}</pre></body></html>");
  }
}
?>
<html>
  <head>
    <title>Neekita Assignment 4</title>
  </head>
  <body>
    <form  accept-charset="utf-8" method="get" >
      <label for="q">Search:</label>
      <input id="q" name="q" type="text" value="<?php echo htmlspecialchars($query, ENT_QUOTES, 'utf-8'); ?>"/>
      <input type="submit" value="Submit"/>
<br/>
<br/>
    <input type="radio" name="sort" value="pagerank" <?php if(isset($_REQUEST['sort']) && $myalgo == "pagerank") { echo 'checked="checked"';} ?>>Page Rank
    <input type="radio" name="sort" value="Lucene" <?php if(isset($_REQUEST['sort']) && $myalgo == "Lucene") { echo 'checked="checked"';} ?>>Lucene
    </form>
<?php
$sheetData =  array_map('str_getcsv', file('URLtoHTML_reuters_news.csv'));
if ($results)
{
  $total = (int) $results->response->numFound;
  $start = min(1, $total);
  $end = min($limit, $total);
  
echo "  <div>Results $start -  $end of $total :</div> <ol>";
foreach ($results->response->docs as $doc)
  {  
    $curid = $doc->id;
    $curtitle = $doc->title;
   $curdesc = $doc->description;
   if($curtitle=="") 
    
       $curtitle="N/A";

if($curtitle==null)
    $curtitle="N/A";
	if($curdesc=="")
$curdesc="N/A";

 if($curdesc==null)

       $curdesc="N/A";
   
   
   $newid = $curid;
   $curid = str_replace("/home/neekitas/Desktop/solr-7.7.0/data/reutersnews","",$curid);
   foreach($sheetData as $newrow)
   {
  
      $url = $newrow[1];

   }
   
    echo " <table> <li>   
	Title: <a href='$url' target='_blank'>$curtitle</a> </br>
	URL: <a href='$url' target='_blank'>$url</a> </br>
	Description: $curdesc</br>
	ID: $newid </br>
	</li>";
  
}
  echo "</ol></table>";
  
}
?>

  </body>
</html>
