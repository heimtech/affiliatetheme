<tr>
<td class="td-content">
<label for="<?php echo $partnerImageImportType; ?>">Art der Speicherung vom Produktbilder</label>
</td>
<td class="td-content">
<?php
$imageImportType = get_option($partnerImageImportType);
?>
		<select 
			name="<?php echo $partnerImageImportType; ?>" 
			id="<?php echo $partnerImageImportType; ?>" 
			class="widefat">
			<option <?php if ($imageImportType === 'download') : ?>selected="selected"<?php endif; ?> value="download">Bilder vom Partner abrufen und lokale Kopie anlegen</option>
			<option <?php if ($imageImportType === 'url_only') : ?>selected="selected"<?php endif; ?> value="url_only">Nur die Bildadressen speichern
			</option>
		</select>
	</td>
</tr>