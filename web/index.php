<html>
  <head>
    <meta charset="UTF-8"/>
    <title>Факти за България</title>
  </head>
  <body>
    <div align="center">
      <h1>Факти за България</h1>
      <img src="bulgaria-map.png" />
      <table>
        <tr>
          <td>Площ</td>
          <td></td>
          <td>110 993.6 кв.км.</td>
        </tr>
        <tr>
          <td>Население</td>
          <td></td>
          <td>7 101 859</td>
        </tr>
        <tr>
          <td>Столица</td>
          <td></td>
          <td>София</td>
        </tr>
      </table>
      <br />
      <h1>Големи градове</h1>
      <table>
<?php
   require_once ('config.php');

   try {
      $connection = new mysqli($host, $user, $password, $database);
      $query = $connection->query("SELECT city_name, population FROM cities ORDER BY population DESC");

      if (empty($query)) {
         echo "<tr><td>Няма данни.</td></tr>\n";
      } else {
         while ($row = $query->fetch_assoc()) {
            print "<tr><td>{$row['city_name']}</td><td align=\"right\">{$row['population']}</td></tr>\n";
         }
      }
   }
   catch (Exception $e) {
      print "<tr><td><div align='center'>\n";
      print "Няма връзка към базата. Опитайте отново. <a href=\"#\" onclick=\"document.getElementById('error').style = 'display: block;';\">Детайли</a><br/>\n";
      print "<span id='error' style='display: none;'><small><i>".$e->getMessage()." <a href=\"#\" onclick=\"document.getElementById('error').style = 'display: none;';\">Скрий</a></i></small></span>\n";
      print "</div></td></tr>\n";
   }
?>
      </table>
    </div>
  </body>
</html>
