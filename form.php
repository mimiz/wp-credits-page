<div class="wrap">
	<?php screen_icon(); ?>
	<h2><?php echo __( 'Credits Page', 'credits-page' );?></h2>
	<form action="" method="POST">
		<?php wp_nonce_field('update-options'); ?>
		<h2><?php _e('Options ', 'credits-page');?></h2>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php echo __('Page title', 'credits-page' ); ?></th>
				<td><input type="text" name="credits-page-pagetitle" value="<?php echo $titre; ?>" /></td>
			</tr>
		</table>
		<h2><?php _e('Check plugin to show', 'credits-page');?></h2>
		<table cellspacing="0" id="all-plugins-table" class="widefat">
			<thead>
				<tr>
					<th class="manage-column check-column" scope="col"><input type="checkbox" /></th>
					<th class="manage-column" scope="col"><?php echo __('Name', 'credits-page'); ?></th>
					<th class="manage-column" scope="col"><?php echo __('Description', 'credits-page'); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th class="manage-column check-column" scope="col"><input type="checkbox" /></th>
					<th class="manage-column" scope="col"><?php echo __('Name', 'credits-page'); ?></th>
					<th class="manage-column" scope="col"><?php echo __('Description', 'credits-page'); ?></th>
				</tr>
			</tfoot>
			<tbody class="plugins">
			<?php foreach ($plugins as $pluginName => $pluginDatas){?>
				<?php if(is_plugin_active($pluginName)) {?>
				<tr class="active">
				<?php }else{ ?>
				<tr class="inactive">
				<?php }?>
					<td class="check-column" scope="row" ><input type="checkbox" <?php if(in_array($pluginName, $pluginsSaved)) { echo 'checked="checked"';} ?> value="<?php echo $pluginName;?>" name="checked[]" /></td>
					<td class="plugin-title">
						<strong>
							<a href="<?php echo $pluginDatas['PluginURI']; ?>" target="_blank">
								<?php echo $pluginDatas['Name']; ?>
							</a>
						</strong>
					</td>
					<td class="desc"><?php echo $pluginDatas['Description']; ?></td>
				</tr>
			<?php }?>
			</tbody>
		</table>
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes', 'credits-page') ?>" name="plugins" />
		</p>
	</form>
</div>