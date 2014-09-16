<?php
$link = mysqli_connect("172.30.0.179", "root", "password", "dbtest");

/* Vérification de la connexion */
if (mysqli_connect_errno()) {
    printf("Échec de la connexion : %s\n", mysqli_connect_error());
    exit();
}

/* Retourne le nom de la base de données courante */
if ($result = mysqli_query($link, "SELECT DATABASE()")) {
    $row = mysqli_fetch_row($result);
    printf("La base de données courante est %s.\n", $row[0]);
    mysqli_free_result($result);
}

/* Change la base de données en "world" */
mysqli_select_db($link, "dbtest");

$result = mysqli_query($link,"SELECT * FROM ps_playedsqlscripts");


echo "<h1>Contenu de 'ps_playedsqlscripts'</h1>";
echo "<table border='1'>;

<tr>
<th>id</th>
<th>name</th>
<th>ts</th>
</tr>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['id'] . "</td>";
echo "<td>" . $row['name'] . "</td>";
echo "<td>" . $row['ts'] . "</td>";
echo "</tr>";
}

echo "</table>";

$result = mysqli_query($link,"SELECT * FROM data_table_1");


echo "<h1>Contenu de 'data_table_1'</h1>";
echo "<table border='1'>;
<p>
<tr>
<th>id</th>
<th>name</th>
<th>value</th>
</tr>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['id'] . "</td>";
echo "<td>" . $row['name'] . "</td>";
echo "<td>" . $row['value'] . "</td>";
echo "</tr>";
}
echo "</table>";

mysqli_close($link);
?>
