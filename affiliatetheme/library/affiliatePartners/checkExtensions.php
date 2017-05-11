<?php
if (! in_array('curl', get_loaded_extensions())) {
    ?>
<tr>
	<td class="td-content" colspan="2"
		style="color: #a94442; background-color: #f2dede; border-color: #ebccd1; padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px">
		<p>
			Die PHP-Erweiterung cURL wird benötig, um Daten aus den externen
			Servern zu Laden.<br />Für detaillierte Angaben über cURL bitte die
			folgenden Seite besuchen: <a
				href="http://php.net/manual/de/book.curl.php" taget="_blank">PHP-cURL</a><br />
			Der Systemadministrator kann die notwendige Serverkonfiguration
			vornehmen.
		</p>
	</td>
</tr>
<?php
}
if (ini_get('allow_url_fopen') == false) {
    ?>
<tr>
	<td class="td-content" colspan="2"
		style="color: #a94442; background-color: #f2dede; border-color: #ebccd1; padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px">
		<p>Die Servereinstellung "allow_url_fopen" ist deaktiviert. Um Werte
			aus den externen Servern beziehen zu können, muss diese Funktion
			aktiviert sein.</p>
	</td>
</tr>
<?php
}
if (extension_loaded('soap') == false) {
    ?>
<tr>
	<td class="td-content" colspan="2"
		style="color: #a94442; background-color: #f2dede; border-color: #ebccd1; padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px">
		<p>
			Die PHP-Erweiterung SOAP wird benötigt, um die Schnittstellen des
			Affilatepartners aufrufen zu können.<br />Für detaillierte Angaben
			über SOAP bitte die folgende Seite besuchen: <a
				href="http://php.net/manual/en/book.soap.php" taget="_blank">PHP-SOAP</a><br />
			Der Systemadministrator kann die notwendige Serverkonfiguration
			vornehmen.
		</p>
	</td>
</tr>

<?php
}
?>
