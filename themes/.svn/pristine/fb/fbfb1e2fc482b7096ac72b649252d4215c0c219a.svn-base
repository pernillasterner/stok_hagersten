				<div class="share pie">
					<strong>Tipsa om denna sida</strong>
					<p>Sociala nätverk:</p>
					<div id="fb-root"></div>
					<script>(function(d, s, id) {
					  var js, fjs = d.getElementsByTagName(s)[0];
					  if (d.getElementById(id)) return;
					  js = d.createElement(s); js.id = id;
					  js.src = "//connect.facebook.net/sv_SE/all.js#xfbml=1&appId=214516935307175";
					  fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));</script>

					<div class="fb-like" data-send="true" data-layout="button_count" data-width="550" data-show-faces="false"></div>

					<div class="clear"></div>
					
					<a href="https://twitter.com/share" class="twitter-share-button" data-via="rhedman" data-lang="sv" data-count="none">Tweeta</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		
					<g:plus action="share"></g:plus>

					<script type="text/javascript">
					window.___gcfg = {
					    lang: 'sv',
					    annotation: 'none'
					};

					(function() {
					    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
					    po.src = 'https://apis.google.com/js/plusone.js';
					    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
					})();
					</script>

					
					
					<div class="clear"></div>
					
					<p class="share-e-mail">Via e-post:</p>
					<a href="#" class="share-e-mail">E-post</a>
					<div class="clear"></div>
					<div id="recommend" class="recommend"">
		
					<form action="<?php bloginfo('template_url'); ?>/form/recommend.php" method="post" id="RecommendForm">
					    <input type="hidden" class="inputHidden" value="<?php the_title();?>" name="pageTitle">
					    <input type="hidden" class="inputHidden" value="<?php the_permalink();?>" name="pageUrl">
						<dl>
						    <dt>Tipsa en vän</dt>
						    <dd>
							    <label for="fromName">Ditt namn</label>
							    <div class="input"><input type="text" id="fromName" value="" name="fromName"></div>
						    </dd>

						    <dd>
							    <label for="fromEmail">Ditt e-postadress</label>
							    <div class="input"><input type="text" id="fromEmail" value="" name="fromEmail"></div>
						    </dd>
						    <dd>
							    <label for="toEmail">Mottagarens e-postadress</label>
							    <div class="input"><input type="text" id="toEmail" value="" name="toEmail"></div>
						    </dd>

						    <dd>
							    <label for="moreInfo">Meddelande</label>
							    <div class="input"><input type="text" id="moreInfo" value="" name="moreInfo"></div>
						    </dd>
						</dl>
						<input type="submit" title="Skicka" class="submit" id="recommendSubmit" value="Skicka">
					</form>
					
					<script>
						$('.recommend form').submit(function(){
							var formData = $('.recommend form').serialize();
							$.post("<?php bloginfo('template_url'); ?>/form/recommend.php", $(".recommend form").serialize(),
							   function(data) {
							   
							   	$('.recommend form').slideUp('slow', function() {
								$(".recommend").html('<p class="msg" style="float:left; display:none;">' + data + '</p>');
								$(".msg").fadeIn('fast');

									});
							   });
							return false
						});
						</script>
						<div class="clear"></div>
					</div>

				</div>