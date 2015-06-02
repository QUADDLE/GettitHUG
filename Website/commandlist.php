<?php
  //Dieses Script gibt eine Commandliste in HTML aus
  include 'functions.php';
?>

<html>
  <head>
    <style>
      #maindiv {
        background: #CCC;
        border: 1px solid #666;
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 1.2em;
        color: #333;
        position: absolute;
        top: 30%;
        left: 30%;
        right: 30%;
        margin-top: -75px;
        margin-left: -100px;
        vertical-align: center;
      }
      table{
        border: 1px solid black;
        border-collapse: collapse;
        width: 100%;
      }
      td {
        padding-left: 20px;
        border: 1px solid black;
      }
    </style>
  </head>
  <body>
    <div id="maindiv">
      <table>
        <tr>
          <td>
            <b>Befehl</b>
          </td>
          <td>
            <b>Wirkung</b>
          </td>
        </tr>
      <?php
        mysql_verbindung();
        $abfrage = "SELECT * FROM befehle";
        $data = mysql_query($abfrage);
        while($row = mysql_fetch_object($data)) {
          echo "
          <tr>
          <td>
            $row->befehl
          </td>
          <td>
            $row->wirkung
          </td>
        </tr>
        ";
        }
      ?>
      </table>
    </div>
  </body>
</html>