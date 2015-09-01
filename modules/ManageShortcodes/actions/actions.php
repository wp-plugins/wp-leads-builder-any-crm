<?php
/******************************
 * filename:    modules/wpsugarShortcode/actions/actions.php
 * description:
 */

class ManageShortcodesActions extends SkinnyActions {

	public function __construct()
	{
	}

  /**
   * The actions index method
   * @param array $request
   * @return array
   */
	public function executeIndex($request)
	{
		// return an array of name value pairs to send data to the template
		$data = array();
		return $data;
	}
	
	public function executeView($request)
	{
		// return an array of name value pairs to send data to the template
		$data = array();
		return $data;
	}

	public function getUsersListHtml()
	{
	
	}


	public function executeManageFields($request)
	{

		$data = array();

		foreach( $request as $key => $REQUESTS )
		{
			foreach( $REQUESTS as $REQUESTS_KEY => $REQUESTS_VALUE )
			{
				$data['REQUEST'][$REQUESTS_KEY] = $REQUESTS_VALUE;
			}
		}

		$data['HelperObj'] = new WPCapture_includes_helper;
		$data['module'] = $data["HelperObj"]->Module;
		$data['moduleslug'] = $data['HelperObj']->ModuleSlug;
		$data['activatedplugin'] = $data["HelperObj"]->ActivatedPlugin;
		$data['activatedpluginlabel'] = $data["HelperObj"]->ActivatedPluginLabel;

		$data['plugin_url']= WP_CONST_ULTIMATE_CRM_CPT_DIRECTORY;
		$data['onAction'] = 'onCreate';
		$data['siteurl'] = site_url();

		if(isset($data['REQUEST']['formtype']))
		{
			$data['formtype'] = $data['REQUEST']['formtype'];
		}
		else
		{
			$data['formtype'] = "post";
		}

		if(isset($data['REQUEST']['EditShortCode']) && ( $data['REQUEST']['EditShortCode'] == "yes" ) )
		{
			$data['option'] = $data['options'] = "smack_{$data['activatedplugin']}_lead_{$data['formtype']}_field_settings"; // final output sample 'smack_wptigerfree_lead_post_field_settings //'smack_wp_vtiger_fields_shortcodes';
		}
		else
		{
			$data['option'] = $data['options'] = "smack_{$data['activatedplugin']}_{$data['moduleslug']}_fields-tmp"; // final output sample 'smack_wptigerpro_vtiger_fields-tmp' //'smack_wp_vtiger_lead_fields-tmp';
		}


		if(isset($data['REQUEST']['EditShortCode']) && ( $data['REQUEST']['EditShortCode'] == "yes" ) )//&& $_REQUEST['EditShortCode']=='' && is_null($_REQUEST['EditShortCode']))
		{
			$data['onAction'] = 'onEditShortCode';
		}
		else
		{
			$data['onAction'] = 'onCreate';
		}


if (isset ($_POST['formtype'])) {
		$SaveFields = new SaveFields();
		$formFields = $SaveFields->saveFormFields( $data['option'] , $data['onAction'] , $data['REQUEST']['EditShortCode'] , $data , $data['formtype'] );



	if( isset($formFields['display']) )
		{
			echo $formFields['display'];
		}
	}
                return $data;
	}


}
class SaveFields
{
function saveFormFields( $options , $onAction , $editShortCodes ,  $request , $formtype = "post" )
{

	$HelperObj = new WPCapture_includes_helper();
	$module = $HelperObj->Module;
	$moduleslug = $HelperObj->ModuleSlug;
	$activatedplugin = $HelperObj->ActivatedPlugin;
	$activatedpluginlabel = $HelperObj->ActivatedPluginLabel;

	$save_field_config = array();



if( isset($request['REQUEST']['bulkaction']))
{
$action = $request['REQUEST']['bulkaction'];
$SaveFields = new SaveFields();
switch($action)
{
case 'enable_field':
	$SaveFields->enableField( $request );
	break;

case 'disable_field':
	$SaveFields->disableField($request);
	break;


case 'update_order':
	$SaveFields->updateOrder($request);
	break;
}
	
} 


	



/*	$config_fields = get_option( "smack_{$activatedplugin}_lead_{$formtype}_field_settings" );

	if( !is_array( $config_fields ) )
	{
		$config_fields = get_option("smack_{$activatedplugin}_{$moduleslug}_fields-tmp");	
	}

	foreach( $config_fields as $shortcode_attributes => $fields )
	{
		if($shortcode_attributes == "fields")
		{
			foreach( $fields as $key => $field )
			{
				$save_field_config["fields"][$key] = $field;
				if( !isset($field['mandatory']) || $field['mandatory'] != 2 )
				{
					if(isset($_POST['select'.$key]))
					{
						$save_field_config['fields'][$key]['publish'] = 1;
					}
					else
					{
						$save_field_config['fields'][$key]['publish'] = 0;
					}
				}
				else
				{
					$save_field_config['fields'][$key]['publish'] = 1;
				}
			}
		}
		else
		{
			$save_field_config[$shortcode_attributes] = $fields;
		}
	}
*/

/*	$extra_fields = array( "enableurlredirection" , "redirecturl" , "errormessage" , "successmessage");

	foreach( $extra_fields as $extra_field )
	{
		if(isset( $_POST[$extra_field]))
		{
			$save_field_config[$extra_field] = $_POST[$extra_field];
		}
		else
		{
			unset($save_field_config[$extra_field]);
		}
	}

	for( $i = 0; $i < $_REQUEST['no_of_rows']; $i++ )
	{
		$REQUEST_DATA[$i] = $_REQUEST['position'.$i];
	}

	asort($REQUEST_DATA);

	$i = 0;
	foreach( $REQUEST_DATA as $key => $value )
	{
		$Ordered_field_config['fields'][$i] = $save_field_config['fields'][$key];
		$i++;
	}

	$save_field_config['fields'] = $Ordered_field_config['fields']; 

	update_option("smack_{$activatedplugin}_lead_{$formtype}_field_settings", $save_field_config);
	update_option("smack_{$activatedplugin}_{$moduleslug}_fields-tmp" , $save_field_config);
*/

	

	$data['display'] = "<p class='display_success'> Field Settings Saved </p>";
	return $data;
}



public function enableField($data)
{


$config_fields = get_option( "smack_{$data['activatedplugin']}_lead_{$data['REQUEST']['formtype']}_field_settings" );


	if( !is_array( $config_fields['fields'] ) )
	{
		$config_fields = get_option("smack_{$data['activatedplugin']}_{$data['moduleslug']}_fields-tmp");

	}
	foreach( $config_fields as $shortcode_attributes => $fields )
	{
		if($shortcode_attributes == "fields")
		{
			foreach( $fields as $key => $field )
			{
				$save_field_config["fields"][$key] = $field;
				if( !isset($field['mandatory']) || $field['mandatory'] != 2 )
				{
					if(isset($_POST['select'.$key]))
					{
						$save_field_config['fields'][$key]['publish'] = 1;
					}
					
				}
				else
				{
					$save_field_config['fields'][$key]['publish'] = 1;
				}
			}
		}
		else
		{
			$save_field_config[$shortcode_attributes] = $fields;
		}
	}

update_option("smack_{$data['activatedplugin']}_lead_{$data['REQUEST']['formtype']}_field_settings", $save_field_config);
	update_option("smack_{$data['activatedplugin']}_{$data['moduleslug']}_fields-tmp" , $save_field_config);
}

public function disableField($data)
{

$config_fields = get_option( "smack_{$data['activatedplugin']}_lead_{$data['REQUEST']['formtype']}_field_settings" );

	if( !is_array( $config_fields ) )
	{
		$config_fields = get_option("smack_{$data['activatedplugin']}_{$data['moduleslug']}_fields-tmp");	
	}


	foreach( $config_fields as $shortcode_attributes => $fields )
	{
		if($shortcode_attributes == "fields")
		{
			foreach( $fields as $key => $field )
			{
				$save_field_config["fields"][$key] = $field;
				if( !isset($field['mandatory']) || $field['mandatory'] != 2 )
				{
					if(isset($data['REQUEST']['select'.$key]))
					{

						$save_field_config['fields'][$key]['publish'] = 0;
					}
					
				}
				else
				{

					$save_field_config['fields'][$key]['publish'] = 1;
				}
			}
		}
		else
		{
			$save_field_config[$shortcode_attributes] = $fields;
		}
	}
update_option("smack_{$data['activatedplugin']}_lead_{$data['REQUEST']['formtype']}_field_settings", $save_field_config);
	update_option("smack_{$data['activatedplugin']}_{$data['moduleslug']}_fields-tmp" , $save_field_config);
}


public function updateOrder($data)
{

$config_fields = get_option( "smack_{$data['activatedplugin']}_lead_{$data['REQUEST']['formtype']}_field_settings" );

	if( !is_array( $config_fields ) )
	{
		$config_fields = get_option("smack_{$data['activatedplugin']}_{$data['moduleslug']}_fields-tmp");	
	}


	foreach( $config_fields as $shortcode_attributes => $fields )
        {
                if($shortcode_attributes == "fields")
                {
                        foreach( $fields as $key => $field )
                        {
                                $save_field_config["fields"][$key] = $field;
			}
		}
	}

$extra_fields = array( "enableurlredirection" , "redirecturl" , "errormessage" , "successmessage");


	foreach( $extra_fields as $extra_field )
	{

		if(isset( $_POST[$extra_field]))
		{
			$save_field_config[$extra_field] = $_POST[$extra_field];

		} 
		else
		{
			unset($save_field_config[$extra_field]);
		}
	}

	for( $i = 0; $i < $data['REQUEST']['no_of_rows']; $i++ )
	{
		$REQUEST_DATA[$i] = $data['REQUEST']['position'.$i];
	}

	asort($REQUEST_DATA);
	$i = 0;
	foreach( $REQUEST_DATA as $key => $value )
	{
		$Ordered_field_config['fields'][$i] = $save_field_config['fields'][$key];
		$i++;
	}

	$save_field_config['fields'] = $Ordered_field_config['fields']; 
	update_option("smack_{$data['activatedplugin']}_lead_{$data['REQUEST']['formtype']}_field_settings", $save_field_config);
	update_option("smack_{$data['activatedplugin']}_{$data['moduleslug']}_fields-tmp" , $save_field_config);
}

}



class CallManageShortcodesCrmObj extends ManageShortcodesActions
{
	private static $_instance = null;
	public static function getInstance()
	{
		if( !is_object(self::$_instance) )  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
			self::$_instance = new CallManageShortcodesCrmObj();
		return self::$_instance;
	}
}// CallSugarShortcodeCrmObj Class Ends
