<?php
	
	class Extension_Populate_Entry extends Extension {
	/*-------------------------------------------------------------------------
		Extension definition
	-------------------------------------------------------------------------*/
		
		public static $params = null;
		
		public function about() {
			return array(
				'name'			=> 'Populate Entry',
				'version'		=> '1.0.2',
				'release-date'	=> '2009-01-21',
				'author'		=> array(
					'name'			=> 'Carsten de Vries',
					'website'		=> 'http://www.vrieswerk.nl',
					'email'			=> 'carsten@vrieswerk.nl'
				),
				'description'	=> 'Choose an existing entry and with its existing values create a new entry.'
			);
		}
		
		public function getSubscribedDelegates() {
			return array(
				array(
					'page'		=> '/backend/',
					'delegate'	=> 'InitaliseAdminPageHead',
					'callback'	=> 'initaliseAdminPageHead'
				)
			);
		}
		
	/*-------------------------------------------------------------------------
		Delegates:
	-------------------------------------------------------------------------*/
		
		public function initaliseAdminPageHead($context) {
			$page = $context['parent']->Page;
			
			// Include populate entry functionality only in content publish pages
			if ($page instanceof contentPublish) {
				$page->addScriptToHead(URL . '/extensions/populate_entry/assets/populate_entry.js', 92390001);
			}
			
			// Include population data only in content creation or content edit pages
			if ($page instanceof contentPublish and ($page->_context['page'] == 'new' or $page->_context['page'] == 'edit') and $_GET['from-entry']) {
				$page->addScriptToHead(URL . '/extensions/populate_entry/assets/jquery.populate.js', 92390002);
				$page->addScriptToHead(URL . '/symphony/extension/populate_entry/data/?section=' . $page->_context['section_handle'] . '&entry=' . $_GET['from-entry'], 92390003);
			}

		}
	}
	
?>