		<?php 
			global $listingpro_options;
			$type = 'listing';
			$term_id = '';
			$taxName = '';
			$termID = '';
			$term_ID = '';
			$termName = '';
			$sterm = '';	
			$sloc = '';	
			$termName = '';	
			$locName = '';	
			$catterm = '';	
			$parent = '';	
			$loc_ID = '';
			global $paged;
			$taxTaxDisplay = true;

			
			if( !isset($_GET['s'])){
				$queried_object = get_queried_object();
				$term_id = $queried_object->term_id;
				$taxName = $queried_object->taxonomy;
				if(!empty($term_id)){
					$termID = get_term_by('id', $term_id, $taxName);
					$termName = $termID->name;
					$parent = $termID->parent;
					$term_ID = $termID->term_id;
					if(is_tax('location')){
						$loc_ID = $termID->term_id;
					}
					
				}
			}elseif(isset($_GET['lp_s_cat']) || isset($_GET['lp_s_tag']) || isset($_GET['lp_s_loc'])){
				
				if(isset($_GET['lp_s_cat']) && !empty($_GET['lp_s_cat'])){
					$sterm = $_GET['lp_s_cat'];
					$term_ID = $_GET['lp_s_cat'];
					$termo = get_term_by('id', $sterm, 'listing-category');
					$termName = esc_html__('Results For','listingpro').' <span class="font-bold term-name">'.$termo->name.'</span>';
					$parent = $termo->parent;
				}	
				if(isset($_GET['lp_s_cat']) && empty($_GET['lp_s_cat']) && isset($_GET['lp_s_tag']) && !empty($_GET['lp_s_tag'])){
					$sterm = $_GET['lp_s_tag'];
					$termo = get_term_by('id', $sterm, 'list-tags');
					$termName = esc_html__('Results For','listingpro').' <span class="font-bold">'.$termo->name.'</span>';
				}
				/* if(isset($_GET['lp_s_loc']) && !empty($_GET['lp_s_loc'])){
					$sloc = $_GET['lp_s_loc'];
					$termo = get_term_by('id', $sloc, 'location');
					$locName = 'In <span class="font-bold">'.$termo->name.'</span>';
				} */
				if(isset($_GET['lp_s_loc']) && !empty($_GET['lp_s_loc'])){
					$sloc = $_GET['lp_s_loc'];
					$loc_ID = $_GET['lp_s_loc'];
					if(is_numeric($sloc)){
						$sloc = $sloc;
						$termo = get_term_by('id', $sloc, 'location');
						$locName = esc_html__('In ','listingpro').$termo->name;
					}
					else{
						$checkTerm = listingpro_term_exist($sloc,'location');
						if(!empty($checkTerm)){
							$locTerm = get_term_by('name', $sloc, 'location');
							$locName = 'In <span class="font-bold">'.$locTerm->name.'</span>';
						}
						else{
							$locName = 'In <span class="font-bold">'.$sloc.'</span>';
						}
					}
					
				}
			}
			$listing_style ='1';
			$listingView ='grid_view';
			$GridClass='';
			$ListClass='';
			$listing_style = $listingpro_options['listing_style'];
			if(isset($_GET['list-style']) && !empty($_GET['list-style'])){
				$listing_style = $_GET['list-style'];
			}
			$listingView = $listingpro_options['listing_views'];
			if($listingView == 'grid_view'){
				$GridClass= 'active';
			}elseif($listingView == 'list_view'){
				$ListClass= 'active';
			}
		?>
			<div class="row listing-style-<?php echo $listing_style; ?>">
				<div class="col-md-12 search-row margin-top-subtract-35">
					<form autocomplete="off" class="clearfix" method="post" enctype="multipart/form-data" id="searchform">
						<div class="filter-top-section pos-relative row">							
							<div class="lp-title col-md-10 col-sm-10">
								<?php if(is_search()){ ?>
								<h3><?php echo $termName; ?> <span class="font-bold"><?php echo esc_html__( ' Listings', 'listingpro' );?></span> <?php echo $locName; ?></h3>
								<?php }else{ ?>
								<h3><?php echo esc_html__( 'Results For ', 'listingpro' );?> <span class="font-bold term-name"><?php echo $termName; ?></span><span class="font-bold"><?php echo esc_html__( ' Listings', 'listingpro' );?></span> </h3>
								<?php } ?>
							</div>
							<div class="pull-right margin-right-0 col-md-2 col-sm-2 clearfix">
								<div class="listing-view-layout">
									<ul>
										<li><a class="grid <?php echo $GridClass; ?>" href="#"><i class="fa fa-th-large"></i></a></li>
										<li><a class="list <?php echo $ListClass; ?>" href="#"><i class="fa fa-list-ul"></i></a></li>
									</ul>
								</div>
							</div>
						</div>
						<?php
							$searchfilter = $listingpro_options['enable_search_filter'];
							if(!empty($searchfilter) && $searchfilter=='1'){
						?>
						<div class="form-inline lp-filter-inner">
							<a id="see_filter"><?php echo esc_html__( 'See Filters', 'listingpro' );?></a>
							<div class="more-filter" id="more_filters">
								<?php
									$priceOPT = $listingpro_options['enable_price_search_filter'];
									if(!empty($priceOPT) && $priceOPT=='1'){
										$lp_priceSymbol = $listingpro_options['listing_pricerange_symbol'];
										$lp_priceSymbol2 = $lp_priceSymbol.$lp_priceSymbol;
										$lp_priceSymbol3 = $lp_priceSymbol2.$lp_priceSymbol;
										$lp_priceSymbol4 = $lp_priceSymbol3.$lp_priceSymbol;
								?>
									<div class="form-group">
										<div class="currency-signs search-filter-attr">
											<ul>
												<li class="simptip-position-top simptip-movable" data-tooltip="<?php echo esc_html__( 'Inexpensive', 'listingpro' );?>" id="one"><a href="#" data-price="inexpensive"><?php echo $lp_priceSymbol; ?></a></li>
												<li class="simptip-position-top simptip-movable" data-tooltip="<?php echo esc_html__( 'Moderate', 'listingpro' );?>" id="two"><a href="#" data-price="moderate"><?php echo $lp_priceSymbol2; ?></a></li>
												<li class="simptip-position-top simptip-movable" data-tooltip="<?php echo esc_html__( 'Pricey', 'listingpro' );?>" id="three"><a href="#" data-price="pricey"><?php echo $lp_priceSymbol3; ?></a></li>
												<li class="simptip-position-top simptip-movable" data-tooltip="<?php echo esc_html__( 'Ultra High End', 'listingpro' );?>" id="four"><a href="#" data-price="ultra_high_end"><?php echo $lp_priceSymbol4; ?></a></li>
											</ul>
										</div>
									</div>
								<?php } ?>
								<?php
									$openTimeOPT = $listingpro_options['enable_opentime_search_filter'];
									if(!empty($openTimeOPT) && $openTimeOPT=='1'){
								?>
									<div class="search-filters form-group">
										<ul>
											<li id="listing_openTime"><a href="#" data-value="close"><i class="fa fa-clock-o"></i><?php echo esc_html__( 'Open Now', 'listingpro' );?></a></li>
										</ul>
									</div>
								<?php } ?>
								<?php
									$highRatOPT = $listingpro_options['enable_high_rated_search_filter'];
									$highRewOPT = $listingpro_options['enable_most_reviewed_search_filter'];
									if( (!empty($highRatOPT) && $highRatOPT=='1')||(!empty($highRewOPT) && $highRewOPT=='1') ){
								?>
									<div class="search-filters form-group">
										<ul class="search-filter-attr">
										
											<?php if($highRatOPT=='1'){ ?>
												<li id="listingRate"><a href="#" data-value='listing_rate'><i class="fa fa-star-o"></i><?php echo esc_html__( 'Highest Rated', 'listingpro' );?></a></li>
											<?php } ?>
											
											<?php if($highRewOPT=='1'){ ?>
												<li id="listingReviewed"><a href="#" data-value='listing_reviewed'><i class="fa fa-file-text-o"></i><?php echo esc_html__( 'Most Reviewed', 'listingpro' );?></a></li>
											<?php } ?>
											
										</ul>
									</div>
								<?php } ?>
								
								<?php
									$catsOPT = $listingpro_options['enable_cats_search_filter'];
									if(!empty($catsOPT) && $catsOPT=='1'){
								?>
									<div class="form-group pull-right margin-right-0">
										<div class="input-group border-dropdown">
											<div class="input-group-addon lp-border"><i class="fa fa-list"></i></div>
											<select class="comboboxCategory chosen-select2 tag-select-four" name="searchcategory" id="searchcategory">
												<option value=""><?php echo esc_html__( 'All Categories', 'listingpro' );?></option>
												<?php 
													$args = array(
													'post_type' => 'listing',
													'order' => 'ASC',
													'hide_empty' => false,
													'parent' => 0,
													);
													
													$locations = get_terms( 'listing-category',$args);
													foreach($locations as $location) {
														if($term_ID == $location->term_id){
															$selected = 'selected';
														}else{
															$selected = '';
														}
														echo '<option '.$selected.' value="'.$location->term_id.'">'.$location->name.'</option>';
														$sub = get_term_children( $location->term_id, 'listing-category' );
														foreach ( $sub as $subID ) {
															if($term_ID == $subID){
																$selected = 'selected';
															}else{
																$selected = '';
															}
															$term = get_term_by( 'id', $subID, 'listing-category' );
															echo '<option '.$selected.' class="sub_cat" value="'.$term->term_id.'">-&nbsp;&nbsp;'.$term->name.'</option>';
														}
													}		
												?>	
											</select>
										</div>
									</div>
								<?php } ?>
							</div>			
							<a href="#" class="open-map-view"><i class="fa fa-map-o"></i></a>
						</div>
						<?php } ?>
						<input type="hidden" name="lp_search_loc" id="lp_search_loc" value="<?php echo $loc_ID; ?>" />
						<?php if($taxTaxDisplay == true){ ?>
							
							<?php 
								
								$count = 1;
								$featureName;
								$features = listingpro_get_term_meta($term_ID,'lp_category_tags');
								if(empty($features)){
									$features = listingpro_get_term_meta($parent,'lp_category_tags');
								}
								if(!empty($features)){ ?>
									<div class="form-inline lp-features-filter tags-area" style="opacity: 1;">
										<div class="form-group">
											<div class="input-group margin-right-0">
												
												<ul>
													<?php
													foreach($features as $feature){
														$terms = get_term_by('id', $feature, 'features');
														if(!empty($terms)){
															echo '<li>';
																echo '<div class="pad-bottom-10 checkbox ">';
																	echo '<input type="checkbox" name="searchtags[]'.$count.'" id="check_'.$count.'" class="searchtags" value="'.$terms->term_id.'">';
																	echo '<label for="'.$terms->term_id.'">'.$terms->name.'</label>';
																echo '</div>';
															echo '</li>';
															$count++;	
														}
													}
													?>
												</ul>	
											</div>
										</div>
									</div>
								<?php
								}
								?>
						
						<?php } ?>
						<input type="submit" style="display:none;">
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="LPtagsContainer "></div>
				</div>
			</div>

<?php


echo "<pre>";
print_r: ($terms);
echo "</pre>";

?>
