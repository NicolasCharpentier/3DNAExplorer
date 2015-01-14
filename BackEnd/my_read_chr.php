<?php

function 		co_mysql()
{
	$co = mysql_connect("localhost:/Applications/MAMP/tmp/mysql/mysql.sock", "root", "root"); // Pour MAC
	//$co = mysql_connect("localhost", "root", ""); // Pour Windows
	if (!$co)
		echo "Erreur : ". mysql_error(). "\n";
	else
		echo "Connexion mysql : OK!\n";
	$select_db = mysql_select_db("bioptimize", $co);
	if (!$select_db)
		echo "Erreur : ". mysql_error(). "\n";
	else
		echo "Connexion database : OK!\n";
	return ($co);
}
function 		disco_mysql($co)
{
	if (mysql_close($co))
		echo "Déconnexion reussite !\n";
	else
		echo "Erreur : ". mysql_error();
}

function 		insert_db()
{
	ini_set('memory_limit', '-1');
	$matches = array();
	$my_locus = array();
	$j = 0;
	$k = 0;

	echo "Loading ...";
	$tmp_exec_beging = microtime(true);
	$locus = file_get_contents("hs_alt_HuRef_chr5.gbk");
	preg_match_all("/ORIGIN *\n *[\d]([\s\w]+)\/\//", $locus, $matches);
	$my_locus = str_replace(" ", "", $matches[1]);
	$my_locus = preg_replace('`[0-9]`', '', $my_locus);
	
	for ($i = 0; $i < count($my_locus); $i++)
	{
		$my_locus[$i] = explode("\n", $my_locus[$i]);
	}
	$nb_locus = count($my_locus) - 1;
	echo "\nNombre de locus : " . $nb_locus . "\n";
	echo "Nombre de base du locus 1: " .(count($my_locus[0]) - 1). "\n";
	echo "Nombre de base du locus 2: " .(count($my_locus[1]) - 1). "\n";

	for ($i = 0; $i < $nb_locus; $i++)
	{
		for ($j = 0; $j < count($my_locus[$i]); $j++)
		{
			$req = mysql_query("INSERT INTO seq_locus (id_locus, base) VALUES ('". $i ."', '". $my_locus[$i][$j] ."')");
			/*if (!$req)
				echo "Erreur : ". mysql_error();
			else
				echo "OK !\n";*/
		}
	}

	$tmp_exec_end = microtime(true);
	$result_time = $tmp_exec_end - $tmp_exec_beging;
	echo "Temps d'execution : " .$result_time. "\n";
}

function 		main()
{
	$co = co_mysql();
	insert_db();
	disco_mysql($co);
}

main();

?>