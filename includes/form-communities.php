<?php
  global $post;
  wp_nonce_field(basename(__FILE__), "moo_noncename");
  add_thickbox(); 
 
$feature_list = get_post_meta(get_the_ID(),"moo_community_feature",true);
$community_images = get_post_meta(get_the_ID(),"moo_community_imageids",true);
$image_id = get_post_meta(get_the_ID(), 'moo_community_logo', true );
$image_src = wp_get_attachment_url( $image_id );
$community_tagline = get_post_meta(get_the_ID(), "moo_community_tagline",true);
$community_logo = get_post_meta(get_the_ID(),'moo_community_logo',true); //saving the source url so its easy to access.
if ($community_logo == ""){
  $community_logo = "https://placehold.co/300";
}   

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
<style>
		#feature_repeater table, #feature_repeater table input{ width: 100%; }
		td.inner_tr > tr { display: table; width: 100%; }
		td.inner_td tr { display: table; width: 100%; }
</style>
<input type="hidden" name="postid" value="<?php echo get_the_ID();?>"/>
<div class="communities">   
  
 <div class="row mb-5">     
   
 <div class="col-6 card">
      <div class="card-header">
            <div class="navbar">
               <span class="navbar-brand">Communities Details</span>
                   
            </div>            
      </div>
   <div class="row">
    <div class="col-2 offset-1">
       
         <img id="community_logo" src="<?php echo $community_logo; ?>" class="card-img-top img-thumbnail" /><br/>
         <br/><label>Enter an URL or upload an image for the banner.</label>
         <input class="form-control" id="moo_community_logo" type="text" name="moo_community_logo" value="<?php echo $community_logo; ?>"/>                      
         <br/>
         <input  class="form-control" type="hidden" name="community_image_id" id="community_image_id" value="<?php echo $image_id; ?>"/>
       
         <div class="row">
             <a id="set-community-logo" class="btn-small btn-primary col-6 btn"><?php echo (get_post_meta(get_the_ID(),'moo_community_logo',true)=="") ? 'upload logo' : 'replace logo';?> </a>
            
         </div> 
   </div>
    <div class="col-5">
        <label>Community Tagline</label>
        <br/>
        <input type="text" class="form-control" name="moo_community_tagline" value="<?php echo $community_tagline; ?>"/>
        <div class="row">
            <div class="col-6">
                <p>
            
                <label for="moo_community_address">Community Address</label>
                <br />
                <input class="form-control" type="text" name="moo_community_address" id="moo_community_address" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'moo_community_address', true)); ?>">
                <br/>
                <label for="moo_community_address">Community Region (ie. Newmarket, Ontario).</label>
                <br />
                <input class="form-control" type="text" name="moo_community_region" id="moo_community_region" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'moo_community_region', true)); ?>">
            
                </p>
            </div>
  
            <div class="col-6">
                <label for="moo_community_lat">Phone</label>
                <br />
                <input class="form-control" type="text" name="moo_community_phone" id="moo_community_phone" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'moo_community_phone', true ) ); ?>">
                <label for="moo_community_long">Person/Contact/Agent Name (if applicable):</label>
                <br />
                <input class="form-control" type="text" name="moo_community_contact" id="moo_community_contact" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'moo_community_contact', true ) ); ?>">

            </div>
        <label>Community Blurb (middle section).</label>
        <br/>
        <textarea class="form-control" rows="5" name="moo_community_blurb"><?php echo esc_attr( get_post_meta( get_the_ID(), 'moo_community_blurb', true ) ); ?></textarea>
        </div>
    </div>
    <div class="col-4">
    <div id="features_repeater">
      <label>Features List</label>
      <br/>
      <table>
        <tbody>
          <tr class="wc-repeater">
            <td data-repeater-list="feature-group" class="inner_td">
              <?php if(!empty($feature_list)) { ?>
                  <?php foreach($feature_list as $group) { 
                    ?>
                    <table data-repeater-item>
                      <tr>
                        <td class="inner-outer-repeater">
                          <table>
                            <tr>
                                 <td><input class="form-control" type="text" name="moo_feature" value="<?php echo $group['moo_feature']; ?>" placeholder="Feature" /></td>	
                                 <td><input data-repeater-delete class="button"  type="button" value="-" /></td>
                            </tr>
                          </table>
                        </td>
                                        </tr>
                    </table>
                  <?php } ?>
                <?php } else { ?>
                  <table data-repeater-item>
                    <tr>
                      <td class="inner-outer-repeater">
                        <table>
                          <tr>
                            <td><input class="form-control" type="text" name="moo_feature" value="" placeholder="Feature" /></td>	
                            <td><input data-repeater-delete class="button"  type="button" value="-" /></td>
                          </tr>
                        </table>
                      </td>
                                    </tr>
                  </table>
						<?php } ?>
					</td>
					<td><input data-repeater-create class="button"  type="button" value="+"/></td>
				</tr>
			</tbody>
		</table>
    </div>
</div>
                </div>
  </div>
</div>
  <div class="row">
    <div class="section-images">
        <div class="row">
           
            <div class="card">
              <div class="card-header">
                <div class="navbar">
                      <span class="navbar-brand">Communities 'Take a Look' Images</span>
                      <ul class="nav nav-pills card-header-pills justify-content-end">
                      <li class="nav-item">
                        <a id="add-feature-image" class="nav-link active" href="#">Add Images</a>
                      </li>
                      </ul>   
                </div>            
            </div>
        <!-- take a look section : featured images -->
        <div class="row card-body mb-5" id="feature-images">
            
        <?php 
        
           foreach ($community_images as $x) {
             echo '<div class="col-6">' . wp_get_attachment_image($x, array('700', '600'), "", array( "class" => "img-responsive", "data-id" => $x ) );  
             echo '<input type="hidden" name="feature_imageid[]" value="' . $x . '"/>';
             echo '<button class="remove-image btn btn-primary btn-small" id="' . $x . '"><span class="fa-solid fa-minus-circle"></span></button></div>';
          }
        
        ?><div class="col-6"><img src="https://placehold.co/600x300"/></div>
        </div>
       
    </div>
    </div>

</div>
<div class="row mt-5">
  <div class="card">
    <div class="card-header">
     <span class="navbar-brand">title goes here</span>
        </div>
    <div class="card-body">
      <div class="row">
        <div class="col-5 offset-1">
                <div class="card">
                  <div class="card-header">
                      <div class="navbar">
                        <span>Site Plans</span>
                        <ul class="nav nav-pills card-header-pills justify-content-end">
                          <li><a data-type="site-plan" id="upload-siteplan" class="upload-pdf nav-link active">Upload Site Plan</a></li>
                        </ul>
                    </div>
                  </div>   
                  <div class="card-body">
                    <label>Site plan list:</label>
                </div>
            </div>
        </div>
        <div class="col-5">
                <div class="card">
                  <div class="card-header">
                      <div class="navbar">
                        <span>Floor Plans</span>
                        <ul class="nav nav-pills card-header-pills justify-content-end">
                          <li><a data-type="floor-plan" id="upload-floorplan" class="upload-pdf nav-link active">Upload Floor Plan</a></li>
                        </ul>
                    </div>
                  </div>   
                  <div class="card-body">
                    <label>list:</label>
                </div>
            </div>
        </div>
      </div>

      <div class="row">
        <div class="col-5 offset-1">
                <div class="card">
                  <div class="card-header">
                      <div class="navbar">
                        <span>Features</span>
                        <ul class="nav nav-pills card-header-pills justify-content-end">
                          <li><a class="nav-link active">Add Feature</a></li>
                        </ul>
                    </div>
                  </div>   
                  <div class="card-body">
                  
                </div>
            </div>
        </div>
        <div class="col-5">
                <div class="card">
                  <div class="card-header">
                      <div class="navbar">
                        <span>Amenities Map</span>
                        <ul class="nav nav-pills card-header-pills justify-content-end">
                          <li><a class="nav-link active">Upload amenities Map</a></li>
                        </ul>
                    </div>
                  </div>   
                  <div class="card-body">
                    
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>
</div>
<script type="text/javascript">
		jQuery(document).ready(function ($) {
			jQuery('.wc-repeater').repeater(
			{
				repeaters: [{
					selector: '.inner-repeater'
				}]
			});
  
      jQuery('.remove-image').on("click",function(e){
        
          $active_id = $(this).attr("id");
          $('img[data-id="'+$active_id+'"]').parent().remove();
          $('input[value="'+$active_id+'"]').remove();
      });
		});

        
/*** PLAIN JAVASCRIPT */

var customUploaderA;
var upload_floorplan = document.getElementById('upload-floorplan');

upload_floorplan.addEventListener("click",function(e){

    e.preventDefault();

    if (customUploaderA) {
      customUploaderA.open();
      return;
    }

    customUploaderA = wp.media({
         title: 'Flooplans', // modal window title
         button: {
           text: 'Upload PDF' // button label text
         },
         multiple: true
    });

    customUploaderA.on( 'select', function() { // it also has "open" and "close" events        
        
        var attachments = customUploaderA.state().get('selection');                
        attachments.each(function(attachment) {           
          //attachment.attributes.url
            let pdfid = document.createElement('input');            
            pdfid.setAttribute('type', 'hidden');
            pdfid.setAttribute('name',"floor-plans[]");
            pdfid.setAttribute('value', attachment.attributes.url);
        });
        
    });

    customUploaderA.open();

});



var customUploaderS;
var upload_siteplan = document.getElementById('upload-siteplan');

upload_siteplan.addEventListener("click",function(e){

    e.preventDefault();

    if (customUploaderS) {
      customUploaderS.open();
      return;
    }

    customUploaderS = wp.media({
         title: 'Site plans', // modal window title
         button: {
           text: 'Upload PDF' // button label text
         },
         multiple: true
    });

    customUploaderS.on( 'select', function() { // it also has "open" and "close" events        
        
        var attachments = customUploaderS.state().get('selection');                
        attachments.each(function(attachment) {           
          //attachment.attributes.url
            let pdfid = document.createElement('input');            
            pdfid.setAttribute('type', 'hidden');
            pdfid.setAttribute('name',"site-plans[]");
            pdfid.setAttribute('value', attachment.attributes.url);
        });
        
    });

    customUploaderS.open();

});





var customUploaderB;
var community_logo = document.getElementById('set-community-logo');

community_logo.addEventListener("click",function(e){

    e.preventDefault();

    if (customUploaderB) {
      customUploaderB.open();
      return;
    }

    customUploaderB = wp.media({
         title: 'Community Logo', // modal window title
         button: {
           text: 'Upload Logo' // button label text
         },
         multiple: true
    });

    customUploaderB.on( 'select', function() { // it also has "open" and "close" events        
           
        const attachment = customUploaderB.state().get( 'selection' ).first().toJSON();    
       
         if (attachment.url){          
           jQuery("#community_logo").attr("src",attachment.url);
           jQuery("#moo_community_logo").val(attachment.url);
           jQuery("#community_image_id").val(attachment.id);
         }
    });

    customUploaderB.open();

});



var customUploaderC;
var feature_image = document.getElementById('add-feature-image');

feature_image.addEventListener("click",function(e){

    e.preventDefault();

    if (customUploaderC) {
      customUploaderC.open();
      return;
    }

    customUploaderC = wp.media({
         title: 'Take-a-Look Images', // modal window title
         button: {
           text: 'Upload Image' // button label text
         },
         multiple: true
    });

    customUploaderC.on( 'select', function() { // it also has "open" and "close" events        
         //const attachment = customUploaderC.state().get( 'selection' ).first().toJSON();    
        //const attachments = customUploaderC.state().get( 'selection' ).first().toJSON();  
        var attachments = customUploaderC.state().get('selection');                
        attachments.each(function(attachment) {           
            let img = document.createElement('img');
            let btn = document.createElement('button');
           // btn.setAttribute('name',"btn-del");
           // btn.setAttribute('data-id',attachment.attributes.id);
           // btn.setAttribute("class","btn btn-small");
           // btn.innerHTML = "<icon class='fa-solid fa-trash'></i>";        
            let imgid = document.createElement('input');            
            imgid.setAttribute('type', 'hidden');
            imgid.setAttribute('name',"feature_imageid[]");
            imgid.setAttribute('value', attachment.attributes.id); // save the id.
            img.src = attachment.attributes.url;
            let newDiv = document.createElement("div"); 
            newDiv.classList.add("col-6");
            newDiv.appendChild(img); 
            newDiv.appendChild(btn);
            newDiv.appendChild(imgid);   
            newDiv.setAttribute("data-id",attachment.attributes.id);        
            document.getElementById('feature-images').appendChild(newDiv);            
        });     
    });

    customUploaderC.open();

});
</script>
