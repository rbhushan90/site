<?php
/**
* Front Controller Plugin
 *
* @uses       Zend_Controller_Plugin_Abstract
* @category   Oibs
* @package    Oibs_Controller
* @subpackage Plugins
*/
class Oibs_Controller_Plugin_Language extends Zend_Controller_Plugin_Abstract
{
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		//$config = Zend_Registry::get('config');

		// Get languages
		$locale = Zend_Registry::get('Zend_Locale');//new Zend_Locale();
		//$options = array('scan' => Zend_Translate::LOCALE_FILENAME, 'disableNotices' => true);
		//$cache = Zend_Registry::get('cache');
		//Zend_Translate::setCache($cache);

        /*
        $config = Zend_Registry::get('config');
        $languagefiles = $config->language->files;
        //var_dump($languagefiles);
        //$languagefilesEn = $config->language->files->en->toArray();
        //var_dump($languagefilesEn);
        $translate = new Zend_Translate('csv', APPLICATION_PATH . '/languages/index_en.csv', 'en');

        $langArr = $languagefiles->toArray();
        foreach($langArr as $lang => $files)
        {
            foreach ($files as $file)
            {
                $translate->addTranslation(APPLICATION_PATH . '/languages/' . $file, $lang);
            }
        }
            */

		//$params = $this->getRequest()->getParams();

		//$language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

        /*
          if(isset($params['language']))
          {
              $language = $params['language'];
          }

          if($language == false)
          {
              $language = $translate->isAvailable($locale->getLanguage) ? $locale->getLanguage() : $config->language->default;
          }

          if(!$translate->isAvailable($language))
          {
              $language = 'en';
              //throw new Zend_Controller_Action_Exception('This page does not exist', 404);
          }
          */
		//else
		//{
			//$locale->setLocale($language);
			//$translate->setLocale($locale);
			//Zend_Form::setDefaultTranslator($translate);

            //var_dump($translate->getLocale());
        //var_dump(Zend_Translate::LOCALE_FILENAME);

			//setcookie('lang', $locale->getLanguage(), null, '/');

			Zend_Registry::set('Zend_Locale', $locale);
			//Zend_Registry::set('Zend_Translate', $translate);
			//Zend_Registry::set('Available_Translations', $translate->getList());
		//}
	}

    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
	    /** @var $language string */
	    $language  = $this->getRequest()->getParam('language', '_default');
	    $session   = new \Zend_Session_Namespace();
	    $locale    = new Zend_Locale();
	    /** @var $translate \Zend_Translate_Adapter */
	    $translate = null;

        if (Zend_Registry::isRegistered('Zend_Translate')) {
            $translate = Zend_Registry::get('Zend_Translate');
	    } else {
            $config = Zend_Registry::get('config');
            $languagefiles = $config->language->files;
            //$languagefilesEn = $config->language->files->en->toArray();
            $translate = new Zend_Translate('csv', APPLICATION_PATH . '/languages/index_en.csv', 'en');

            $langArr = $languagefiles->toArray();
            foreach($langArr as $lang => $files) {
                foreach ($files as $file) {
                    $translate->addTranslation(APPLICATION_PATH . '/languages/' . $file, $lang);
                }
            }
        }

	    if ($language === '_default' || !$translate->isAvailable($language)) {
		    $language = isset($session->language) ? $session->language : $locale->getLanguage();
	    }

	    $session->language = $language;
        $locale->setLocale($language);
        $translate->setLocale($locale);
        Zend_Form::setDefaultTranslator($translate);

        Zend_Registry::set('Zend_Locale', $locale);
        Zend_Registry::set('Zend_Translate', $translate);
        Zend_Registry::set('Available_Translations', $translate->getList());
    }
}
?>
