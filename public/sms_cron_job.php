<?php
$database="av_hospital";
$user="root";
$password="";
$conn = db2_connect($database, $user, $password);

if ($conn) {
  $stmt = db2_exec($conn, 'CALL multiResults()');

  print "Fetching first result set\n";
  while ($row = db2_fetch_array($stmt)) {
    var_dump($row);
  }

  print "\nFetching second result set\n";
  $res = db2_next_result($stmt);
  if ($res) {
    while ($row = db2_fetch_array($res)) {
      var_dump($row);
    }
  }

  print "\nFetching third result set\n";
  $res2 = db2_next_result($stmt);
  if ($res2) {
    while ($row = db2_fetch_array($res2)) {
      var_dump($row);
    }
  }

  db2_close($conn);
}
?>