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
