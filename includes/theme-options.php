<?php
function themeoptions_admin_menu()
{
	//Add link sidebar
	add_theme_page('Configurações do tema', 'Opções do tema', 'edit_theme_options', 'opcoes-do-tema', 'themeoptions_page');
}
if (isset($_POST['update_themeoptions']) && $_POST['update_themeoptions'] == 'true') {
	themeoptions_update();
}
function themeoptions_page()
{
	$consilio_options = get_option('consilio_options');
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox'); ?>
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/includes/css/set.css">
	<div class="container">
		<h2 class="title">Configurações do tema</h2>
		<ul class="tab-wrapper">
			<li class="item is-active">Básico</li>
			<li class="item">SEO</li>
			<li class="item">Imagens</li>
			<li class="item">Customizações</li>
			<li class="item">Códigos externos</li>
			<li class="line"></li>
		</ul>
		<form method="post" action="">
			<input type="hidden" name="update_themeoptions" value="true">
			<ul class="content-wrapper">
				<li class="content-item">
					<h3 class="form-header">Configurações básicas</h3>
					<div class="form-item">
						<p class="form-item-title">URL do front-end：</p>
						<div class="form-item-content">
							<input type="text" class="input-inner" name="domain" id="domain" value="<?php echo $consilio_options['domain']; ?>">
							<span><sup>Deve conter o protocolo (http/https).</sup></span>
						</div>
					</div>
					<div class="form-item">
						<p class="form-item-title">Manutenção：</p>
						<div class="form-item-content flex-row">
							<label for="maintenance-on">Ativada</label>
							<input type="radio" id="maintenance-on" name="maintenance" value="1" <?php if ((bool) $consilio_options['maintenance']) {
																																											echo 'checked';
																																										} ?>>
							<label for="maintenance-off">Desativada</label>
							<input type="radio" id="maintenance-off" name="maintenance" value="0" <?php
																																										if ((bool) !$consilio_options['maintenance'] || !$consilio_options['maintenance']) {
																																											echo 'checked';
																																										}
																																										?>>
						</div>
					</div>

					<div class="form-item">
						<p class="form-item-title">Copryright rodapé：</p>
						<div class="form-item-content">
							<textarea class="input-inner" name="footer-copyright" rows="5" cols="100"><?php echo $consilio_options['footer_copyright']; ?></textarea>
						</div>
					</div>

					<div class="form-item no-border">
						<p class="form-item-title">Box no rodapé：</p>
						<div class="form-item-content">
							<textarea class="input-inner" name="footer-box" rows="7" cols="100"><?php echo $consilio_options['footer_box']; ?></textarea>
						</div>
					</div>

					<h3 class="form-header">Informações</h3>
					<div class="form-item">
						<p class="form-item-title">Telefone：</p>
						<div class="form-item-content">
							<input type="text" class="input-inner" name="phone" id="phone" value="<?php echo $consilio_options['phone']; ?>">
						</div>
					</div>
					<div class="form-item">
						<p class="form-item-title">WhatsApp:</p>
						<div class="form-item-content">
							<input type="text" class="input-inner" name="whatsapp" id="whatsapp" value="<?php echo $consilio_options['whatsapp']; ?>">
						</div>
					</div>
					<div class="form-item">
						<p class="form-item-title">E-mail:</p>
						<div class="form-item-content">
							<input type="text" class="input-inner" name="email" id="email" value="<?php echo $consilio_options['email']; ?>">
						</div>
					</div>
					<div class="form-item no-border">
						<p class="form-item-title">Endereço:</p>
						<div class="form-item-content">
							<input type="text" class="input-inner" name="address" id="address" value="<?php echo $consilio_options['address']; ?>">
						</div>
					</div>
					<h3 class="form-header">Redes sociais</h3>
					<div class="form-item">
						<p class="form-item-title">Facebook: </p>
						<div class="form-item-content">
							<input type="text" class="input-inner" name="facebook" id="facebook" value="<?php echo $consilio_options['facebook']; ?>">
						</div>
					</div>
					<div class="form-item">
						<p class="form-item-title">Instagram:</p>
						<div class="form-item-content">
							<input type="text" class="input-inner" name="instagram" id="instagram" value="<?php echo $consilio_options['instagram']; ?>">
						</div>
					</div>
					<div class="form-item">
						<p class="form-item-title">Linkedin:</p>
						<div class="form-item-content">
							<input type="text" class="input-inner" name="linkedin" id="linkedin" value="<?php echo $consilio_options['linkedin']; ?>">
						</div>
					</div>
					<div class="form-item">
						<p class="form-item-title">Youtube:</p>
						<div class="form-item-content">
							<input type="text" class="input-inner" name="youtube" id="youtube" value="<?php echo $consilio_options['youtube']; ?>">
						</div>
					</div>
					<div class="form-item no-border">
						<p class="form-item-title">Twitter:</p>
						<div class="form-item-content">
							<input type="text" class="input-inner" name="twitter" id="twitter" value="<?php echo $consilio_options['twitter']; ?>">
						</div>
					</div>
				</li>
				<!-- SEO -->
				<li class="content-item">
					<div class="form-item">
						<p class="form-item-title">Palavras-chaves：</p>
						<div class="form-item-content">
							<textarea class="input-inner" name="keywords" rows="3" cols="100"><?php echo $consilio_options['keywords'] ?></textarea>
						</div>
					</div>

					<div class="form-item">
						<p class="form-item-title">Descrição：</p>
						<div class="form-item-content">
							<textarea class="input-inner" name="description" rows="8" cols="100"><?php echo $consilio_options['description'] ?></textarea>
						</div>
					</div>
				</li>
				<!-- SEO -->
				<!-- Images -->
				<li class="content-item">
					<div class="form-item">
						<p class="form-item-title">Favicon: </p>
						<div class="form-item-content">
							<div class="form-input-group">
								<input type="text" class="input-inner" name="favicon" value="<?php echo $consilio_options['favicon']; ?>">
								<input type="button" name="img-upload" value="Selecionar" class="choose-image">
							</div>
							<span>Ícone para navegador 32x32</span>
							<p>
								<img src="<?php echo $consilio_options['favicon']; ?>" class="preview-img">
							</p>
						</div>
					</div>

					<div class="form-item">
						<p class="form-item-title">Logo do site：</p>
						<div class="form-item-content">
							<div class="form-input-group">
								<input type="text" class="input-inner" name="logo" id="logo" value="<?php echo $consilio_options['logo']; ?>">
								<input type="button" name="img-upload" value="Selecionar" class="choose-image">
							</div>
							<p>
								<img src="<?php echo $consilio_options['logo']; ?>" class="preview-img">
							</p>
						</div>
					</div>

					<div class="form-item-group">
						<div class="form-item">
							<p class="form-item-title">Logo do login：</p>
							<div class="form-item-content">
								<div class="form-input-group">
									<input type="text" class="input-inner" name="login-logo" value="<?php echo $consilio_options['login_logo']; ?>">
									<input type="button" name="img-upload" value="Selecionar" class="choose-image">
								</div>
								<p>
									<img src="<?php echo $consilio_options['login_logo']; ?>" class="preview-img">
								</p>
							</div>
						</div>
						<div class="form-item">
							<p class="form-item-title">Largura：</p>
							<div class="form-item-content">
								<input type="text" class="input-inner" name="width-login-logo" id="width-login-logo" value="<?php echo $consilio_options['width_login_logo']; ?>">
								<span><sup>Deve conter a unidade (px/rem/em)</sup></span>
							</div>
						</div>
						<div class="form-item">
							<p class="form-item-title">Altura: </p>
							<div class="form-item-content">
								<input type="text" class="input-inner" name="height-login-logo" id="domain" value="<?php echo $consilio_options['height_login_logo']; ?>">
								<span><sup>Deve conter a unidade (px/rem/em)</sup></span>
							</div>
						</div>
					</div>


					<div class="form-item">
						<p class="form-item-title">Imagem padrão：</p>
						<div class="form-item-content">
							<div class="form-input-group">
								<input type="text" class="input-inner" name="thumbnail-img" id="thumbnail-img" value="<?php echo $consilio_options['thumbnail']; ?>">
								<input type="button" name="img-upload" value="Selecionar" class="choose-image">
							</div>
							<p>
								<img src="<?php echo $consilio_options['thumbnail']; ?>" class="preview-img">
							</p>
						</div>
					</div>
				</li>

				<!-- Custom -->
				<li class="content-item">
					<div class="form-item">
						<p class="form-item-title">CSS do login:</p>
						<div class="form-item-content">
							<textarea class="input-inner" name="login-css" rows="12" cols="100"><?php echo $consilio_options['login_css']; ?></textarea>
						</div>
					</div>
					<div class="form-item">
						<p class="form-item-title">CSS Global:</p>
						<div class="form-item-content">
							<textarea class="input-inner" name="global-css" rows="12" cols="100"><?php echo $consilio_options['global_css']; ?></textarea>
						</div>
					</div>
				</li>
				<!-- Codes ext -->
				<li class="content-item">
					<div class="form-item">
						<p class="form-item-title">Google Analytics:</p>
						<div class="form-item-content">
							<textarea class="input-inner" name="google-analytics" rows="8" cols="100"><?php echo $consilio_options['google_analytics']; ?></textarea>
						</div>
					</div>
					<div class="form-item">
						<p class="form-item-title">Google Tag Manager:</p>
						<div class="form-item-content">
							<textarea class="input-inner" name="google-tag-manager" rows="8" cols="100"><?php echo $consilio_options['google_tag_manager']; ?></textarea>
						</div>
					</div>
					<div class="form-item">
						<p class="form-item-title">Outros scripts:</p>
						<div class="form-item-content">
							<textarea class="input-inner" name="others-scripts" rows="8" cols="100"><?php echo $consilio_options['others_scripts']; ?></textarea>
						</div>
					</div>
				</li>
			</ul>
			<div class="btn-wrap">
				<input type="submit" class="btn-submit" name="btn-admin-options" value="Salvar">
			</div>
		</form>
	</div>
	<script src="<?php bloginfo('template_url'); ?>/includes/js/set.js"></script>
<?php
}
function themeoptions_update()
{
	$options                   = array(
		'update_themeoptions'    => 'true',
		//Basic
		'domain'                 => $_POST['domain'],
		'maintenance'            => $_POST['maintenance'],
		'footer_copyright'       => $_POST['footer-copyright'],
		'footer_box'      		   => $_POST['footer-box'],
		//--info
		'phone'                 => $_POST['phone'],
		'whatsapp'             	=> $_POST['whatsapp'],
		'email'       				 	=> $_POST['email'],
		'address'      		   		=> $_POST['address'],
		//--socials
		'facebook'              => $_POST['facebook'],
		'instagram'							=> $_POST['instagram'],
		'linkedin'       				=> $_POST['linkedin'],
		'youtube'      		   		=> $_POST['youtube'],
		'twitter'      		   		=> $_POST['twitter'],
		//SEO
		'keywords'               => $_POST['keywords'],
		'description'            => $_POST['description'],
		//Images
		'favicon'                => $_POST['favicon'],
		'login_logo'             => $_POST['login-logo'],
		'width_login_logo'       => $_POST['width-login-logo'],
		'height_login_logo'      => $_POST['height-login-logo'],
		'logo'                   => $_POST['logo'],
		'thumbnail'              => $_POST['thumbnail-img'],
		//Custom
		'login_css'              => $_POST['login-css'],
		'global_css'             => $_POST['global-css'],
		//Codes
		'google_analytics'       => $_POST['google-analytics'],
		'google_tag_manager'     => $_POST['google-tag-manager'],
		'others_scripts'     		=> $_POST['others-scripts'],
	);
	update_option('consilio_options', stripslashes_deep($options));
}
add_action('admin_menu', 'themeoptions_admin_menu');
?>