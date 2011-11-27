<?php 
/**
 * 
 * @author mimiz.fr
 *
 */
class CreditsPagesPlugin
{
	private $_pluginsDir = null;
	private $_page;
	private $_pageID = "credits-page";
	/**
	 * Plugin Constructor
	 */
	public function __construct()
	{
		$this->_pluginsDir = basename(dirname(__FILE__));
		add_action('init', array(&$this,'initTextDomain') );
		add_action('admin_menu', array(&$this,'addMenuPage') );
		//add_action( 'admin_init', array(&$this, 'defineOptions') );
		
		
	}
	/**
	 * Initialize language Text Domain
	 */
	public function initTextDomain()
	{
		load_plugin_textdomain( 'credits-page',null, $this->_pluginsDir .'/lang');
	}
	
	/**
	 * Add menu in page panel
	 */
	public function addMenuPage()
	{
		$this->_page = add_pages_page(__('Credits Page', 'credits-page'), __('Credits Page', 'credits-page'), 
											'edit_pages', 'credits-page', 
											array(&$this,'addPage') );
	}
	
	
	public function getPage()
	{
		global $wpdb;
		$page_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type='page'", $this->_pageID ));
		return $page_id;
	}
	/**
	 * Show page options content
	 */
	public function addPage()
	{
		$plugins = get_plugins();
		$id = $this->getPage();
		if(isset($_POST['plugins']))
		{
			
			if($id === null)
			{
				
				$result = wp_insert_post( array('post_title' => $_POST['credits-page-pagetitle'], 'post_name' => 'credits-page',
										'post_type' => 'page', 'post_content' => $this->createContent($_POST['checked'])) );
			}else{
				//Je mets à jour
				$page = get_post($id);
				$content = $page->post_content;
				$contentNew = preg_replace('(<!-- Page Credits -->.*<!-- /Page Credits -->)', $this->createContent($_POST['checked']), $content);
				$result = wp_update_post(array('ID'=>$id,'post_title' => $_POST['credits-page-pagetitle'], 'post_content' => $contentNew) );
			}
			
			if( !($result instanceof WP_Error ) )
			{
				if(get_option('credits-page-plugins'))
				{
					update_option('credits-page-plugins', join(';;',$_POST['checked']));
				}else{
					add_option('credits-page-plugins', join(';;',$_POST['checked']));
				}
			}
		}
		if($id >0){
			$titre = get_post($id)->post_title;
		}else{
			$titre = '';
		}
		$pluginsSaved = array();
		$options = get_option('credits-page-plugins');
		if($options != "")
		{
			$pluginsSaved = explode(';;', $options);
		}
		
		include(dirname(__FILE__).'/form.php');
	}
	/**
	 * Create content with datas posted 
	 * @param mixed $postdatas
	 */
	public function createContent($postdatas)
	{
		$buff = '<!-- Page Credits -->';
		if(!is_array($postdatas)){
			$buff .= $postdatas;
		}else{
			$buff .= '<div class="credits-page-plugins">';
			foreach($postdatas as $plugin)
			{
				$pl = get_plugin_data(WP_PLUGIN_DIR .'/'. $plugin);
				$buff .= '<div class="credits-page-plugin">';
				$buff .= '<div class="credits-page-plugin-name"><a href="'.$pl['PluginURI'].'" target="_blank">'.$pl['Name'].' '.$pl['Version'].'</a></div>';
				$buff .= '<div class="credits-page-plugin-description">'.$pl['Description'].'</div>';
				$buff .= '</div>';
			}
			$buff .= '</div>';
		}
		$buff .= '<!-- /Page Credits -->';
		return $buff;
	}
	
//	public function defineOptions()
//	{
//		register_setting( 'credits-page', 'credits-page-plugins');
//	}
	
}

?>