
	<form method="get" class="s-form" id="searchform" action="<?php echo esc_url( home_url( ) ); ?>">
		<?php /*
		<select>
			<option>-- Sök efter --</option>
			<option>Utbildningar</option>
			<option>Seminarier</option>
			<option>Artiklar</option>
			<option>Sidor</option>
		</select>

		 */?>
		<div>
			<input type="text" class="field search-input" name="s" id="s" placeholder="<?php if (strlen(get_search_query() != " ")) {print(get_search_query());} else {esc_attr_e( 'Sök', 'Svenska Kyrkan Hägersten' );} ?>" value="Sök på hagersten.org" title="Sök på hagersten.org"/>
			<input title="Sök nu" type="submit" class="submit" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Sök', 'Svenska Kyrkan Hägersten' ); ?>" />
		</div>
	</form>
