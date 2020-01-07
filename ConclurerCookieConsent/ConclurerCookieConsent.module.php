<?php

/**
 * ProcessWire  Textformatter
 * Copyright (c) 2017 by Conclurer GmbH / Tomas Kostadinov
 *
 * Looks for Emails and automatically obfuscates them.
 *
 *
 * ProcessWire 3.x
 * Copyright (C) 2018 by Tomas Kostadinov / Conclurer GmbH
 * Licensed under MIT
 *
 * http://conclurer.com
 * http://tomaskostadinov.com
 *
 *
 *
 */

class ConclurerCookieConsent extends WireData implements Module, ConfigurableModule {

	public function __construct() {
		parent::__construct();
		$this->set('config', '"palette": {
    "popup": {
      "background": "#041436",
      "text": "#000000"
    },
    "button": {
      "background": "transparent",
      "text": "#ffffff",
      "border": "#ffffff"
    }
  },
  "position": "bottom-right",
  "content": {
    "message": "This website uses cookies to ensure you get the best experience on our website.",
    "dismiss": "Got it!",
    "link": "Learn more",
    "href": "https://google.com"
  }');
	}
	/**
	 * Module configuration screen
	 *
	 */
	public function getModuleConfigInputfields(array $data) {
		$inputfields = new InputfieldWrapper();
		$f = wire('modules')->get('InputfieldMarkup');
		$f->attr('value', '&lt;?= $modules->getModule("ConclurerCookieConsent")->render();?&gt;');
		$f->label = "Consent Code";
		$f->description = "Add this code to your layout file to add the cookie consent popup.";
		$inputfields->add($f);
		$f = wire('modules')->get('InputfieldMarkup');
		$f->label = "Configuration";
		$f->attr('value', 'Configure consent popup <a href=\'https://cookieconsent.osano.com/download/\' target=\'_blank\'>here</a> and paste the json code inside below');
		$inputfields->add($f);
		$f = wire('modules')->get('InputfieldTextarea');
		$f->attr('rows', "20");
		$f->value = $this->get('config');
		$f->name = 'config';
		$f->label = 'JSON Configuration code';
		$inputfields->add($f);

		return $inputfields;
	}

	public function render() {
		$file = new ProcessWire\TemplateFile(dirname(__FILE__) . '/templates/consent.inc.php');
		$file->config = $this->get('config');
		wire()->urls->set('css', 'site/modules/ConclurerCookieConsent/templates');
		$file->url = wire()->urls->get('httpCss');
		return $file->render();
	}

}