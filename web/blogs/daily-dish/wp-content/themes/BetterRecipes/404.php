<?php get_header(); ?>
		
				<div id="maincolumn">
					<div id="maincontentwell">


						<div id="content">
						<?php include('breadcrumb.php'); ?>
  						<div class="post">
  						<h2>Error 404 - Not Found</h2>
  						
							 <p><strong>That page does not exist or has been moved.</strong>
							 <br/> Please make sure you have the right URL.</p>
							 <p>If you still can't find what you're looking for, try using the search form below.</p>

							 <div id="searchform">
								<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
								 <input type="text" value="<?php the_search_query(); ?>" name="s" id="s" value="Search" onFocus="this.value=''" />
								 <input type="submit" id="searchsubmit" value="Search" />
								</form>
							 </div>   
							
						  </div><!-- end post -->
						</div><!-- end content -->
						
					<div class="clearall"> </div>	
					</div><!-- end maincontentwell -->
					

				</div><!-- end maincolumn -->
				
				
<?php get_sidebar('left'); ?> 
<?php get_sidebar('right'); ?>
<?php get_footer(); ?>
