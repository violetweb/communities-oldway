<?php
/**
 * Admin area settings and hooks.
 *
 * @package Moo_Communities
 * @subpackage  Moo_Communities
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists('register_communities_post_type') ) {

	add_action( 'init', 'register_communities_post_type', 0 );

	function register_communities_post_type() {
            $labels = array(
                'name'                  => _x( 'Communities', 'Post Type General Name', 'moomore'),
                'singular_name'         => _x( 'Communities', 'Post Type Singular Name','moomore' ),
                'menu_name'             => __( 'Communities' ),
                'name_admin_bar'        => __( 'Communities' ),
                'archives'              => __( 'Community Archives' ),
                'attributes'            => __( 'Community Attributes' ),
                'parent_item_colon'     => __( 'Parent Community:' ),
                'all_items'             => __( 'Communities' ),
                'add_new_item'          => __( 'Add New Community' ),
                'add_new'               => __( 'Add New Community' ),
                'new_item'              => __( 'New Community' ),
                'edit_item'             => __( 'Edit Community' ),
                'update_item'           => __( 'Update Community' ),
                'view_item'             => __( 'View Community' ),
                'view_items'            => __( 'View Community' ),
                'search_items'          => __( 'Search Community' ),
                'not_found'             => __( 'Community Not found'),
                'not_found_in_trash'    => __( 'Community Not found in Trash' ),
                'featured_image'        => __( 'Featured Community Image' ),
                'set_featured_image'    => __( 'Set featured Community image' ),
                'remove_featured_image' => __( 'Remove featured Community image' ),
                'use_featured_image'    => __( 'Use as featured Community image' ),
                'insert_into_item'      => __( 'Insert into Community' ),
                'uploaded_to_this_item' => __( 'Uploaded to this Community' ),
                'items_list'            => __( 'Community list' ),
                'items_list_navigation' => __( 'Community list navigation' ),
                'filter_items_list'     => __( 'Filter Community list' ),
        );

    $args = array(
        'label'               => __( 'Communities', 'moomore' ),
        'description'         => __( 'Communities', 'moomore' ),
            'labels'                => $labels,
            'show_in_rest'			=> true,	
            'taxonomies'            => array( 'communities-category' ),
			'supports'              => array( 'title', 'editor','thumbnail','custom-fields' ),		
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 10,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => true,	
            'show_in_menu' 			=> 'moocommunities'		
    
        );

	register_post_type( 'communities', $args );
}

	
	function register_communities_taxonomies() {

		
		register_taxonomy( 'communities-category', 'communities', array(
				'label'        => 'Communities Categories',
				'labels'       => array(
					'menu_name' => __( 'Communities Categories', 'moomore' )
				),
				'rewrite'      => array(
					'slug' => 'communities-category'
				),
				'hierarchical' => true,
				'show_admin_column'	=> true,
				'show_in_rest' => true,
				'show_in_menu'	=> 'communities-category'
				
			) );

	
	}

	function register_communities_meta_boxes() {
		//add_meta_box( $id, $title, $callback, string|array|WP_Screen $screen = null, string $context = 'advanced', string $priority = 'default', array $callback_args = null )
		add_meta_box( 
			'communities_meta_box', 
			__( 'Communities Information', 'moomoore' ), 
			'page_communities_callback', 
			'communities');
	}

	function page_communities_callback( $post ) {	
		include MOO_COM_PLUGIN_DIR . 'includes/form-communities.php';
	}

	function save_communities_meta( $post_id) {
		
	
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		if (isset($_POST['moo_noncename']) && wp_verify_nonce($_POST['moo_noncename'], 'wpdocs-my-nonce')){
			return $post_id;
		}

		if (isset($_POST["post_type"])){
			if ( 'communities' == $_POST['post_type'] ) { 
				if ( !current_user_can( 'edit_page', $post_id )) { 
					return $post_id; 
					
				}
			}
		}

		$fields = [        
			'moo_community_address',
			'moo_community_phone',
			'moo_community_contact',		
			'moo_community_region', 
			'moo_community_blurb',
			'moo_community_tagline',
			'moo_community_logo'        
		];	
		

		foreach ( $fields as $field ) {		
			if ( array_key_exists( $field, $_POST ) ) {				
				update_post_meta( $post_id, $field, sanitize_text_field( $_POST[$field] ) );									
			}
		}

		if (isset($_POST["feature_imageid"])) {  		
			update_post_meta($post_id,'moo_community_imageids',$_POST["feature_imageid"]);
		}else {
		   update_post_meta($post_id,'moo_community_imageids','');
		}
		if (isset($_POST["feature-group"])) {            
			update_post_meta($post_id,'moo_community_feature',$_POST["feature-group"]);
		}
		if (isset($_POST["floor-plans"])) {            
			update_post_meta($post_id,'moo_community_floorplans',$_POST["floor-plans"]);
		}
		if (isset($_POST["site-plans"])) {            
			update_post_meta($post_id,'moo_community_siteplans',$_POST["site-plans"]);
		}
			
	}


	function add_content_for_communities_category_image(string $content, string $column_name, int $term_id):void {
	
		if($column_name != 'communities_category_image'){
			return; 
		}

		$image = '<image width="50" src="' . get_term_meta($term_id, 'communities_category_image', true) . '"/>';  
		
		if(!$image){
			return; 
		}
		
		echo $image;
	}

	

	function get_communities_logo(int $term_id){
		if (!empty($term_id)) {
			return '<image width="50" src="' . get_term_meta($term_id, 'communities_category_logo', true) . '"/>';  
		}
	}


	function get_community_term_image($term_id)
	{
		return get_option('communities_category_image' . $term_id);
	}

	function save_communities_category($term_id)
	{
		if (isset($_POST['communities_category_image'])) {
			update_term_meta($term_id, 'communities_category_image', $_POST['communities_category_image']);
		}

	}


	function taxonomy_edit_communities_custom_field($term) {		
		$image = get_term_meta($term->term_id, 'communities_category_image', true); ?>
		<tr class="form-field term-image-wrap">
			<th scope="row"><label for="communities_category_image"><?php _e( 'Image' ); ?></label></th>
			<td>
				<p><a href="#" class="moo_upload_image_button btn btn-secondary"><?php _e('Upload Image'); ?></a></p><br/>
				<input type="text" name="communities_category_image" id="communities_category_image" value="<?php echo $image; ?>"/>
			</td>
		</tr>
		<script>

	jQuery(document).ready(function($) {

	$('body').on('click', '.moo_upload_image_button', function(e){   
		e.preventDefault();

		const button = $(this);
		const imageId = $("#communities_category_image").val();

	const moo_uploader = wp.media({
			title: 'Custom image',
			button: {
				text: 'Use this image'
			},
			multiple: false
		}).on('select', function() {
			var attachment = moo_uploader.state().get('selection').first().toJSON();
			$("#communities_category_image").val(attachment.url);
		})
		.open();

		// already selected images
	moo_uploader.on( 'open', function() {

		if( imageId ) {
			const selection = customUploader.state().get( 'selection' )
			attachment = wp.media.attachment( imageId );
			attachment.fetch();
			selection.add( attachment ? [attachment] : [] );
		}
		
	});
	});

	});
	</script>
<?php
  }
  
