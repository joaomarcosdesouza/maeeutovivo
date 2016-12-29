		<?php	
	
		//	$stars_color = get_post_meta( get_the_ID(), 'ct_color', true);	
		
			$stars_color = get_post_meta( get_the_ID(), 'ct_mb_stars_color', true);			
			if ( $stars_color == '' ) $stars_color = '#DD0C0C';
										
			$overall_score = get_post_meta($post->ID, 'ct_mb_over_score', true);			

			
			if ( $overall_score == '' ) $score = 'zero';
			
			switch( $overall_score ) {
				case 0:
					$score = 'zero';
					break;
				case 0.5:
					$score = 'zero_half';
					break;
				case 1:
					$score = 'one';
					break;
				case 1.5:
					$score = 'one_half';
					break;
				case 2:
					$score = 'two';
					break;
				case 2.5:
					$score = 'two_half';
					break;
				case 3:
					$score = 'three';
					break;
				case 3.5:
					$score = 'three_half';
					break;
				case 4:
					$score = 'four';
					break;
				case 4.5:
					$score = 'four_half';
					break;
				case 5:
					$score = 'five';
					break;
					
			}		

			echo '<div class="ct-rating ' . $score . '" title="'.__('Review Post','color-theme-framework').'" style="background-color:'. $stars_color . '"></div>';