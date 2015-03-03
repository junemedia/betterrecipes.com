 							<span class="ACThead2"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></span>
						   <p class="byline"><?php the_time('F j, Y'); ?> at <?php the_time() ?>, by <?php the_author_posts_link(); ?></p>
						   
						   <div id="addthis">						       
							   <!-- ADDTHIS BUTTON BEGIN  -->
								<script type="text/javascript">
										var addthis_config = {
												username: "",
												ui_cobrand: "<b>BetterRecipes.com</b>"
												}
										var addthis_share = 
										{ 
												templates: {
																			 twitter: 'check out {{url}} (from @BetterRecipes)',
																	 }
										}
								</script>
									<?php echo "
											<div 	class=\"addthis_toolbox addthis_default_style\" 
														addthis:url=\"".get_permalink()."\" 
														addthis:title=\"".htmlspecialchars(get_the_title($id))."\">"; 
									?>
										
														<a class="addthis_button_email"></a>

														<span class="addthis_separator">|</span>

														<a class="addthis_button_facebook"></a>
														<a class="addthis_button_twitter"></a>
                            <a class="addthis_button_stumbleupon"></a>

														<span class="addthis_separator">|</span>

														<a class="addthis_button_expanded" title="More Choices">More</a>
												</div>
												
							  
							   <!-- ADDTHIS BUTTON END -->
							</div>
							
							<div class="clearall"></div>
							

