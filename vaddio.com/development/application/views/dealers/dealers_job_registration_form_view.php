<div class='header big-blue-header dealers-header'>
	<a href="<?= base_url() ?>dealers" class="dealers-icon"><span>Dealers</span></a>
	<h1>Job Registration Form</h1>
</div>

<h2>Please complete all items prior to submitting this form to Vaddio</h2>


<? echo form_open(); ?>

<?php
/* this section is all PHP so that white spaces are eliminated. White space causes unintended wrapping */

echo form_fieldset('Dealer',array('id' => 'dealer_info', 'class' => 'dealer_info'));
	
	echo "<div class='form-block form-block-dealer_name required'>";
	echo form_label("Dealer Name:", 'dealer_name');
	echo form_input('dealer_name', set_value('dealer_name'), 'id="dealer_name"');
	echo form_error('dealer_name');
	echo "</div>";
	
	echo "<div class='form-block form-block-dealer_contact_name form-block-1of2'>";
	echo form_label("Dealer Contact Name:", 'dealer_contact_name');
	echo form_input('dealer_contact_name', set_value('dealer_contact_name'), 'id="dealer_contact_name"');
	echo form_error('dealer_contact_name');
	echo "</div>";
	
	echo "<div class='form-block form-block-vaddio_account_nbr form-block-2of2'>";
	echo form_label("Vaddio Account #:", 'vaddio_account_nbr');
	echo form_input('vaddio_account_nbr', set_value('vaddio_account_nbr'), 'id="vaddio_account_nbr"');
	echo form_error('vaddio_account_nbr');
	echo "</div>";
	
	echo "<div class='form-block form-block-phone form-block-1of2'>";
	echo form_label("Phone #:", 'user_state');
	echo form_input('phone', set_value('phone'), 'id="phone"');
	echo form_error('phone');
	echo "</div>";
	
	echo "<div class='form-block form-block-fax form-block-2of2'>";
	echo form_label("Fax:", 'fax');
	echo form_input('fax', set_value('fax'), 'id="fax"');
	echo form_error('fax');
	echo "</div>";
	
	echo "<div class='form-block form-block-dealer_location form-block-1of2'>";
	echo form_label("Dealer Location:", 'user_state');
	echo form_input('dealer_location', set_value('dealer_location'), 'id="dealer_location"');
	echo form_error('dealer_location');
	echo "</div>";
	
	echo "<div class='form-block form-block-date_of_registration form-block-2of2'>";
	echo form_label("Registration Date:", 'date_of_registration');
	echo form_input('date_of_registration', set_value('date_of_registration'), 'id="date_of_registration"');
	echo form_error('date_of_registration');
	echo "</div>";
	
	echo "<div class='form-block form-block-dealer_email required'>";
	echo form_label("Dealer Email:", 'dealer_email');
	echo form_input('dealer_email', set_value('dealer_email'), 'id="dealer_email"');
	echo form_error('dealer_email');
	echo "</div>";

echo form_fieldset_close(); 






echo form_fieldset('End User',array('id' => 'enduser_info', 'class' => 'enduser_info'));
	
	echo "<div class='form-block form-block-end_user_company_name'>";
	echo form_label("End User Company Name:", 'end_user_company_name');
	echo form_input('end_user_company_name', set_value('end_user_company_name'), 'id="end_user_company_name"');
	echo form_error('end_user_company_name');
	echo "</div>";
	
	echo "<div class='form-block form-block-end_user_address'>";
	echo form_label("End User Address:", 'end_user_address');
	echo form_input('end_user_address', set_value('end_user_address'), 'id="end_user_address"');
	echo form_error('end_user_address');
	echo "</div>";
	
	
	echo "<div class='form-block form-block-end_user_city_state_zip'>";
	echo form_label("End User City, State, Zip:", 'end_user_city_state_zip');
	echo form_input('end_user_city_state_zip', set_value('end_user_city_state_zip'), 'id="end_user_city_state_zip"');
	echo form_error('end_user_city_state_zip');
	echo "</div>";
	
	echo "<div class='form-block form-block-end_user_contact_name form-block-1of2'>";
	echo form_label("End User Contact Name:", 'end_user_contact_name');
	echo form_input('end_user_contact_name', set_value('end_user_contact_name'), 'id="end_user_contact_name"');
	echo form_error('end_user_contact_name');
	echo "</div>";
	
	echo "<div class='form-block form-block-end_user_phone form-block-2of2'>";
	echo form_label("Phone #:", 'end_user_phone');
	echo form_input('end_user_phone', set_value('end_user_phone'), 'id="end_user_phone"'); 
	echo form_error('end_user_phone');
	echo "</div>";
	
	echo "<div class='form-block form-block-end_user_title_position form-block-1of2'>";
	echo form_label("Title/Position:", 'end_user_title_position');
	echo form_input('end_user_title_position', set_value('end_user_title_position'), 'id="end_user_title_position"');
	echo form_error('end_user_title_position');
	echo "</div>";
	
	echo "<div class='form-block form-block-end_user_email form-block-2of2'>";
	echo form_label("End User Email:", 'end_user_email');
	echo form_input('end_user_email', set_value('end_user_email'), 'id="end_user_email"'); 
	echo form_error('end_user_email');
	echo "</div>";

echo form_fieldset_close(); 


echo "<div class='form-block form-block-model_number_and_quantity'>";
echo form_label("Model Number and Quantity:", 'model_number_and_quantity');
echo form_textarea('model_number_and_quantity', set_value('model_number_and_quantity'), 'id="model_number_and_quantity"');
echo form_error('model_number_and_quantity');
echo "</div>";



echo "<div class='form-block form-block-estimated_purchase_date form-block-1of2'>";
echo form_label("Estimated Purchase Date:", 'estimated_purchase_date');
echo form_input('estimated_purchase_date', set_value('estimated_purchase_date'), 'id="estimated_purchase_date"');
echo form_error('estimated_purchase_date');
echo "</div>";

echo "<div class='form-block form-block-estimated_delivery_date form-block-2of2'>";
echo form_label("Estimated Delivery Date:", 'estimated_delivery_date');
echo form_input('estimated_delivery_date', set_value('estimated_delivery_date'), 'id="estimated_delivery_date"'); 
echo form_error('estimated_delivery_date');
echo "</div>";



echo "<div class='form-block form-block-comments'>";
echo form_label("Comments:", 'comments');
echo form_textarea('comments', set_value('comments'), 'id="comments"');
echo form_error('comments');
echo "</div>";









echo "<div class='form-block form-block-submit'>";
echo form_submit('submit','Submit',"class='orange-button rounded-corner-button'");
echo "</div>";

echo form_close(); 
