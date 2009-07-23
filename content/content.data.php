<?php

	require_once(TOOLKIT . '/class.administrationpage.php');
	require_once(TOOLKIT . '/class.entrymanager.php');
	
	class ContentExtensionPopulate_EntryData extends AdministrationPage {
		protected $_driver = null;
		
		public function __construct(&$parent){
			parent::__construct($parent);
			
			$this->_driver = $this->_Parent->ExtensionManager->create('populate_entry');
		}
		
		public function __viewIndex() {
			header('content-type: text/javascript');
			
			$sm = new SectionManager($this->_Parent);
			$section_id = $sm->fetchIDFromHandle($_GET['section']);
			$section = $sm->fetch($section_id);
			$em = new EntryManager($this->_Parent);
			$entry_id = $_GET['entry'];
			$e = $em->fetch($entry_id);
			$fields = array();
			$data = $e[0]->getData();
			
			foreach ($section->fetchFieldsSchema() as $field) {
				// Set field names and take strange date field name into account
				$field['element_name'] = ($field['type'] == 'date') ? 'fields[' . $field['element_name'] . ']' . $field['element_name'] : 'fields[' . $field['element_name'] . ']';
				
				// Populate field elements with value, depending on field type
				switch ($field['type']) {
					case 'author':
						$fields[$field['element_name']] = $data[$field['id']]['author_id'];
						break;
					case 'upload':
						$fields[$field['element_name']] = $data[$field['id']]['file'];
						break;
					case 'selectbox_link':
						$fields[$field['element_name']] = $data[$field['id']]['relation_id'];
						break;
					case 'input':
					case 'textarea':
					case 'taglist':
					case 'select':
					case 'checkbox':
					case 'date':
					case 'order_entries':
						$fields[$field['element_name']] = $data[$field['id']]['value'];
						break;
					default:
						if(!empty($data[$field['id']]['value'])) {
							$fields[$field['element_name']] = $data[$field['id']]['value'];
						}
						else {
							// Fall back on first array element
							// Add field type to switch for accurate specification
							$fields[$field['element_name']] = $data[$field['id']][0];
						}
						break;
				}
			}
			
			echo 'jQuery(document).ready(function() { jQuery(\'form\').populate('. json_encode($fields) . ")});\n";
			exit;
			
		}
	}
	
?>