<html>
	<head>
		<title>Beispiel zur Anwendung einer HTML-Injection mittels JavaScript</title>
		
		<script type="text/javascript">
			function validierte_zahlen(formular) {
			  formular.value=formular.value.replace(/\D/, '' );
			}
		</script>
		<style>
		pre {background-color:Grey; color:#ff0; font-family: Fixedsys,Courier,monospace; padding:10px;}
		</style>
	</head>
	<body>
		<p><h3>Das Formular zur Übergabe von Text Eingaben</h3>
		<form method="GET" action=" ">
			<input type="int" name="parameter" value="<?=urldecode($_GET['parameter']);?>" onkeyup="validierte_zahlen(this);" size="20" maxlength="6" />
			<input type="submit" value="Absenden" />
		</form>
		</p>
		<p><h3>Die Darstellung/Ausführung von unüberprüften Formularen</h3>
		
<?php
		if(isset($_GET['parameter'])){
		
			echo "<b>Die unüberprüfte Ausgabe, ohne Filter:</b><br /><pre>" . $_GET['parameter']."</pre>"; // Die belassene Ausgabe mittels PHP
		
			
			echo "<br /><br /><b>Filter 1 (nur Zahlen):</b><br />";
			$parameter = (INT)$_GET['parameter'];
			echo "<pre> ".$parameter." </pre>"; // Die Ausgabe mittels PHP, aber nur Zahlen zugelassen. Beispiel zur Eingabe des Alters
			
			
			echo "<br /><br /><b>Filter 2 (Kürzung auf die ersten 10 Ziffern):</b><br />";
			$parameter = substr($_GET['parameter'],0,10);
			echo "<pre> ".$parameter." </pre>"; // Die Ausgabe mittels PHP, aber nur eine gewisse Text-Länge. 
							// Beispiel zur Eingabe eines Textes, der eine gewisse Länge nicht überschreitet
			
			
			echo "<br /><br /><b>Filter 3 (nur ASCII):</b><br />";
			$filter = '0-9a-zA-Z'.preg_quote('_ -|)(:.,?'); // preg_quote() macht das ganze besonders sicher weil es der sanitiser für das replace ist
			$parameter = $_GET['parameter'];
			$parameter = preg_replace($filter, "", $parameter);
			echo "<pre> ".$parameter." </pre>"; // Die Ausgabe mittels PHP, aber nur gewisse ASCII Zeichen. Beispiel zur Eingabe eines Namens
			
			
			echo "<br /><br /><b>Filter 4 (Umwandlung von HTML Tags):</b><br />";
			$parameter = htmlentities($_GET['parameter']); // identisch zu htmlspecialchars()
			echo "<pre> ".$parameter." </pre>"; // Die Ausgabe mittels PHP, aber HTML Zeichen wie 
							// < > werden umgewandelt zu einer kodierten Zeichenkette 
		}
?>
		
		</p>

	</body>
</html>
