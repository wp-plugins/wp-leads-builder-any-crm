<?php
/******************************
 * Filename	: includes/WPCapture_includes_helper.php
 * Description	: Check
 * Author 	: check
 * Owner  	: smackcoders.com
 * Date   	: Mar11,2014
 */

class WPCapture_includes_helper {

	public $capturedId=0;
	public $ActivatedPlugin;
	public $ActivatedPluginLabel;
	public $Action;
	public $Module;
	public $ModuleSlug;
/*
	public function __construct( $module = "" , $action = "" )
	{
		global $IncludedPlugins;
		$ContactFormPluginsObj = new ContactFormPlugins();
		$this->ActivatedPlugin = $ContactFormPluginsObj->getActivePlugin();
		$this->ActivatedPluginLabel = $IncludedPlugins[$this->ActivatedPlugin];
		$this->Action = $action;
		$this->Module = $module;

		$this->ModuleSlug = rtrim( strtolower($this->Module) , "s");
	}

*/
	public function __construct()
	{
		global $IncludedPlugins;
		$ContactFormPluginsObj = new ContactFormPlugins();
		$this->ActivatedPlugin = $ContactFormPluginsObj->getActivePlugin();
		$this->ActivatedPluginLabel = $IncludedPlugins[$this->ActivatedPlugin];
		if(isset( $_REQUEST['action'] ))
		{
			$this->Action = $_REQUEST['action'];
		}
		else
		{
			$this->Action = "";
		}
		if(isset($_REQUEST['module']))
		{
			$this->Module = $_REQUEST['module'];
		}
		else
		{
			$this->Module = "";
		}

		$this->ModuleSlug = rtrim( strtolower($this->Module) , "s");
	}

	public function activate(){

		//	$_SESSION['SELECTED_TAB_VALUE'] = 'SettingsTab';
			//$csvfreesettings = array();
			//$csvfreesettings['post'] = 'post';
			//$csvfreesettings['custompost'] = 'custompost';
		//	$csvfreesettings['page'] = 'page';
		//	$csvfreesettings['comments'] = 'comments';
		//	$csvfreesettings['users'] = 'users';
		//	$csvfreesettings['rcustompost'] = 'nonercustompost';
		//	$csvfreesettings['rseooption'] = 'nonerseooption';
		//	update_option('wpcsvfreesettings', $csvfreesettings);

                global $IncludedPlugins , $DefaultActivePlugin ;
                $index = 0;
                $i = 0;
                foreach($IncludedPlugins as $key => $value)
                {
                        if($DefaultActivePlugin == $key)
                        {
                                update_option('ActivatedPlugin' , $DefaultActivePlugin);
                                $index = 1;
                        }
                        if( $i == 0 )
                        {
                                $firstplugin = $key;
                        }

                        $i++;
                }

                if($index == 0)
                {
                        update_option( 'ActivatedPlugin' , $firstplugin );
                }
	}

	public function deactivate(){

	//	delete_option('wpcsvfreesettings');
//VTiger deactivation code
		global $IncludedPlugins;

		foreach( $IncludedPlugins as $key => $value )
		{
			delete_option( "smack_{$key}_lead_post_field_settings" );
			delete_option( "smack_{$key}_lead_widget_field_settings" );

			delete_option( "smack_{$key}_lead_fields-tmp" );
			delete_option( "wp_{$key}_settings" );
		}
	}
	
	public static function output_fd_page()
	{
		require_once(WP_CONST_ULTIMATE_CRM_CPT_DIRECTORY.'config/settings.php');
		require_once(WP_CONST_ULTIMATE_CRM_CPT_DIRECTORY.'lib/skinnymvc/controller/SkinnyController.php');	

		if (!isset($_REQUEST['__module']))
                {
			if (!isset($_REQUEST['__module'])) {
				wp_redirect(get_admin_url() . 'admin.php?page=' . WP_CONST_ULTIMATE_CRM_CPT_SLUG . '/index.php&__module=Settings&__action=view');
			}
                }

		$c = new SkinnyControllerCommonCrmFree;
                $c->main();
	}



	public function renderMenu()
	{
		include(plugin_dir_path(__FILE__) . '../templates/menu.php');
//		$this->renderContent();		
	}


	public function renderContent()
	{

		if($this->Action == "Settings" || $this->Action=="")
		{
			if($this->Action=="")
			{
				$this->Action = "Settings";
			}
			$action = $this->ActivatedPlugin.$this->Action;
                        $module = $this->Module;
		}
		else
		{
			$action = $this->Action;
			$module = $this->Module;
		}

		include(plugin_dir_path(__FILE__) . '../modules/'.$action.'/actions/actions.php');
		include(plugin_dir_path(__FILE__) . '../modules/'.$action.'/templates/view.php');

	}
}

class CallWPCaptureObj extends WPCapture_includes_helper
{
	private static $_instance = null;
	public static function getInstance()
	{
		if( !is_object(self::$_instance) )  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
			self::$_instance = new WPCapture_includes_helper();
		return self::$_instance;
	}
}// CallWPCaptureObj Class Ends
?>
