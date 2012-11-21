<?php
/**
* Register token search values with Post Author Box
*/
function pabx_add_search_values( $tokens ) {

	if ( ! function_exists( 'coauthors' ) )
		return $tokens;

	$tokens[] = '%coauthors%';
	$tokens[] = '%coauthors_posts_links%';
	$tokens[] = '%coauthors_firstnames%';
	return $tokens;
}
add_filter( 'pab_search_values', 'pabx_add_search_values' );

/**
* Set replacement values for specific tokens with Post Author Box
*/
function pabx_add_replace_values( $tokens ) {
	global $coauthors_plus;
	
	if ( ! function_exists( 'coauthors' ) )
		return $tokens;

	$coauthor = array_shift( get_coauthors() );

	// Co-Authors Plus specific tokens
	$tokens['%coauthors%'] = coauthors( null, null, null, null, false );
	$tokens['%coauthors_posts_links%'] = coauthors_posts_links( null, null, null, null, false );
	$tokens['%coauthors_firstnames%'] = coauthors_firstnames( null, null, null, null, false );
	// Modify the %avatar% token to maybe use the coauthor
	$tokens['%avatar%'] = get_avatar( $coauthor->user_email );
	return $tokens;
}
add_filter( 'pab_replace_values', 'pabx_add_replace_values' );