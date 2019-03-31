<div class="form-field">
		<label for="cuisine_image">Cuisine Image</label>
		<input type="button" class="button" name="_add_cuisine_image" id="_add_cuisine_image"  value="Upload Image" />
        <input type="hidden" name="cuisine_image" id="cuisine_image" class="cuisine-image" value="<?php ?>">
		
	</div>
    <div id="cuisine-image-container" style="height=150px; width=150px;">
        <img src="<?php echo esc_url($term_url); ?>" alt="">
    </div>
    