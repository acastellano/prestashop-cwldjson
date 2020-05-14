<?php
/**
 * @copyright    Copyright (C) 2017 creamiweb.es. All rights reserved.
 * @author Andres Castellano Escobar <acastellano@creamiweb.es>
 * @version v1.0
 */
if (!defined('_PS_VERSION_'))
    exit;

class Cwldjson extends Module
{
    public function __construct()
    {
        $this->name = 'cwldjson';
        $this->tab = 'seo';
        $this->version = '1.1.2';
        $this->author = 'Andres Castellano https://www.linkedin.com/in/andrescastellano/';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => '1.6.99.99');
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Microformats LD+JSON');
        $this->description = $this->l('Create Organization and Product LD+JSON info formtat.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
    }

    public function install()
    {
        if (!parent::install() ||
            !$this->registerHook('header') ||
            !Configuration::updateValue('CW_LDJSON_PRODUCT_SHOW', '1') ||
            !Configuration::updateValue('CW_LDJSON_BUSINESS_SHOW', '1') ||
            !Configuration::updateValue('CW_LDJSON_BUSINESS_NAME', '') ||
            !Configuration::updateValue('CW_LDJSON_BUSINESS_DESCRIPTION', '') ||
            !Configuration::updateValue('CW_LDJSON_BUSINESS_CITY', '') ||
            !Configuration::updateValue('CW_LDJSON_BUSINESS_POSTALCODE', '') ||
            !Configuration::updateValue('CW_LDJSON_BUSINESS_REGION', '') ||
            !Configuration::updateValue('CW_LDJSON_BUSINESS_TELEPHONE', '') ||
            !Configuration::updateValue('CW_LDJSON_BUSINESS_URL', '') ||
            !Configuration::updateValue('CW_LDJSON_BUSINESS_LOGO', '') ||
            !Configuration::updateValue('CW_LDJSON_BUSINESS_PRICERANGE', '') ||
            !Configuration::updateValue('CW_LDJSON_BUSINESS_ADDRESS', '')
        ) {
            return false;
        }
        $this->_clearCache('cwldjson.tpl');
        $this->_clearCache('header.tpl');

        return true;
    }

    public function uninstall()
    {
        $this->_clearCache('cwldjson.tpl');
        $this->_clearCache('header.tpl');
        if (!parent::uninstall() ||
            !Configuration::deleteByName('CW_LDJSON_PRODUCT_SHOW') ||
            !Configuration::deleteByName('CW_LDJSON_BUSINESS_SHOW') ||
            !Configuration::deleteByName('CW_LDJSON_BUSINESS_NAME') ||
            !Configuration::deleteByName('CW_LDJSON_BUSINESS_DESCRIPTION') ||
            !Configuration::deleteByName('CW_LDJSON_BUSINESS_CITY') ||
            !Configuration::deleteByName('CW_LDJSON_BUSINESS_POSTALCODE') ||
            !Configuration::deleteByName('CW_LDJSON_BUSINESS_REGION') ||
            !Configuration::deleteByName('CW_LDJSON_BUSINESS_TELEPHONE') ||
            !Configuration::deleteByName('CW_LDJSON_BUSINESS_URL') ||
            !Configuration::deleteByName('CW_LDJSON_BUSINESS_LOGO') ||
            !Configuration::deleteByName('CW_LDJSON_BUSINESS_PRICERANGE') ||
            !Configuration::deleteByName('CW_LDJSON_BUSINESS_ADDRESS')
        )
            return false;

        return true;
    }

    public function getContent()
    {
        $this->html = '';

        if (Tools::isSubmit('submit' . $this->name)) {
            Configuration::updateValue('CW_LDJSON_PRODUCT_SHOW', Tools::getValue('CW_LDJSON_PRODUCT_SHOW'));
            Configuration::updateValue('CW_LDJSON_BUSINESS_SHOW', Tools::getValue('CW_LDJSON_BUSINESS_SHOW'));
            Configuration::updateValue('CW_LDJSON_BUSINESS_NAME', Tools::getValue('CW_LDJSON_BUSINESS_NAME'));
            Configuration::updateValue('CW_LDJSON_BUSINESS_DESCRIPTION', Tools::getValue('CW_LDJSON_BUSINESS_DESCRIPTION'));
            Configuration::updateValue('CW_LDJSON_BUSINESS_CITY', Tools::getValue('CW_LDJSON_BUSINESS_CITY'));
            Configuration::updateValue('CW_LDJSON_BUSINESS_POSTALCODE', Tools::getValue('CW_LDJSON_BUSINESS_POSTALCODE'));
            Configuration::updateValue('CW_LDJSON_BUSINESS_REGION', Tools::getValue('CW_LDJSON_BUSINESS_REGION'));
            Configuration::updateValue('CW_LDJSON_BUSINESS_TELEPHONE', Tools::getValue('CW_LDJSON_BUSINESS_TELEPHONE'));
            Configuration::updateValue('CW_LDJSON_BUSINESS_URL', Tools::getValue('CW_LDJSON_BUSINESS_URL'));
            Configuration::updateValue('CW_LDJSON_BUSINESS_LOGO', Tools::getValue('CW_LDJSON_BUSINESS_LOGO'));
            Configuration::updateValue('CW_LDJSON_BUSINESS_PRICERANGE', Tools::getValue('CW_LDJSON_BUSINESS_PRICERANGE'));
            Configuration::updateValue('CW_LDJSON_BUSINESS_ADDRESS', Tools::getValue('CW_LDJSON_BUSINESS_ADDRESS'));
            $this->_clearCache('cwldjson.tpl');
            $this->_clearCache('header.tpl');
            $this->html .= $this->displayConfirmation($this->l('Settings updated successfully'));

        }

        return $this->html . $this->renderForm();
    }

    public function renderForm()
    {
        // Get default language
        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Display Business Microformat'),
                        'name' => 'CW_LDJSON_BUSINESS_SHOW',
                        'desc' => $this->l('Enable or Disable Business Microformat on block'),
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Display Product Microformat'),
                        'name' => 'CW_LDJSON_PRODUCT_SHOW',
                        'desc' => $this->l('Enable or Disable Product Microformat on block'),
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Business Name'),
                        'name' => 'CW_LDJSON_BUSINESS_NAME',
                        'class' => 'fixed-width-lg',
                        'desc' => $this->l('Set the Business Name.'),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Business Description'),
                        'name' => 'CW_LDJSON_BUSINESS_DESCRIPTION',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Set the Business short description.'),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('City Name'),
                        'name' => 'CW_LDJSON_BUSINESS_CITY',
                        'class' => 'fixed-width-lg',
                        'desc' => $this->l('Set the City Name.'),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Postal Code'),
                        'name' => 'CW_LDJSON_BUSINESS_POSTALCODE',
                        'class' => 'fixed-width-md',
                        'desc' => $this->l('Set the Postal Code.'),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Business Region'),
                        'name' => 'CW_LDJSON_BUSINESS_REGION',
                        'class' => 'fixed-width-xs',
                        'desc' => $this->l('Set the Business Region: ES, EN, PT...'),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Business Phone'),
                        'name' => 'CW_LDJSON_BUSINESS_TELEPHONE',
                        'class' => 'fixed-width-md',
                        'desc' => $this->l('Set the Business Phone.'),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Price Range'),
                        'name' => 'CW_LDJSON_BUSINESS_PRICERANGE',
                        'class' => 'fixed-width-lg',
                        'desc' => $this->l('Set the Price range of the shop. (Example: from 0,00 to 59,00)'),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('URL'),
                        'name' => 'CW_LDJSON_BUSINESS_URL',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Set the Shop URL.'),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Business Logo'),
                        'name' => 'CW_LDJSON_BUSINESS_LOGO',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Set the Business Logo, paste URL to the image.'),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Business Address'),
                        'name' => 'CW_LDJSON_BUSINESS_ADDRESS',
                        'class' => 'fixed-width-xxl',
                        'desc' => $this->l('Set the Business Street Address.'),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            ),
        );

        $helper = new HelperForm();
        // Module, token and currentIndex
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;

        // Language
        $helper->default_form_language = $default_lang;
        $helper->allow_employee_form_lang = $default_lang;

        $helper->title = $this->displayName;
        $helper->show_toolbar = true;
        $helper->toolbar_scroll = true;
        $helper->table = $this->table;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submit' . $this->name;
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );
        $helper->toolbar_btn = array(
            'save' =>
                array(
                    'desc' => $this->l('Save'),
                    'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&save' . $this->name .
                        '&token=' . Tools::getAdminTokenLite('AdminModules'),
                ),
            'back' => array(
                'href' => AdminController::$currentIndex . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list')
            )
        );

        return $helper->generateForm(array($fields_form));
    }

    public function getConfigFieldsValues()
    {
        return array(
            'CW_LDJSON_PRODUCT_SHOW' => Tools::getValue('CW_LDJSON_PRODUCT_SHOW', Configuration::get('CW_LDJSON_PRODUCT_SHOW')),
            'CW_LDJSON_BUSINESS_SHOW' => Tools::getValue('CW_LDJSON_BUSINESS_SHOW', Configuration::get('CW_LDJSON_BUSINESS_SHOW')),
            'CW_LDJSON_BUSINESS_NAME' => Tools::getValue('CW_LDJSON_BUSINESS_NAME', Configuration::get('CW_LDJSON_BUSINESS_NAME')),
            'CW_LDJSON_BUSINESS_DESCRIPTION' => Tools::getValue('CW_LDJSON_BUSINESS_DESCRIPTION', Configuration::get('CW_LDJSON_BUSINESS_DESCRIPTION')),
            'CW_LDJSON_BUSINESS_CITY' => Tools::getValue('CW_LDJSON_BUSINESS_CITY', Configuration::get('CW_LDJSON_BUSINESS_CITY')),
            'CW_LDJSON_BUSINESS_POSTALCODE' => Tools::getValue('CW_LDJSON_BUSINESS_POSTALCODE', Configuration::get('CW_LDJSON_BUSINESS_POSTALCODE')),
            'CW_LDJSON_BUSINESS_REGION' => Tools::getValue('CW_LDJSON_BUSINESS_REGION', Configuration::get('CW_LDJSON_BUSINESS_REGION')),
            'CW_LDJSON_BUSINESS_TELEPHONE' => Tools::getValue('CW_LDJSON_BUSINESS_TELEPHONE', Configuration::get('CW_LDJSON_BUSINESS_TELEPHONE')),
            'CW_LDJSON_BUSINESS_URL' => Tools::getValue('CW_LDJSON_BUSINESS_URL', Configuration::get('CW_LDJSON_BUSINESS_URL')),
            'CW_LDJSON_BUSINESS_LOGO' => Tools::getValue('CW_LDJSON_BUSINESS_LOGO', Configuration::get('CW_LDJSON_BUSINESS_LOGO')),
            'CW_LDJSON_BUSINESS_PRICERANGE' => Tools::getValue('CW_LDJSON_BUSINESS_PRICERANGE', Configuration::get('CW_LDJSON_BUSINESS_PRICERANGE')),
            'CW_LDJSON_BUSINESS_ADDRESS' => Tools::getValue('CW_LDJSON_BUSINESS_ADDRESS', Configuration::get('CW_LDJSON_BUSINESS_ADDRESS')),
        );
    }

    public function hookDisplayHeader()
    {
     $phpself = $this->context->controller->php_self;
        $jsonVars = $this->getConfigFieldsValues();
        $idProduct = (int)(Tools::getValue('id_product'));
        if ($idProduct > 0) {
            $product = new Product((int)($idProduct), true, $this->context->language->id, $this->context->shop->id);
            $currency = Currency::getDefaultCurrency();
            $category = '';
            if (isset($product->id_category_default) AND $product->id_category_default > 1)
                $category = New Category((int)($product->id_category_default), $this->context->language->id, $this->context->shop->id);
            //$productVars = array('name'=>$product->name, 'image'=>$this->context->link->getImageLink($product->link_rewrite, $product->getCover($idProduct), 'social_ads'));
            $coverid = $product->getCover($idProduct);
            $jsonVars['currency_iso'] = $currency->iso_code;
            $jsonVars['cat_name'] = $category->name;
            $this->smarty->assign('productVars', $product);
            $this->smarty->assign('coverid', $coverid);
            $this->smarty->assign('phpself', $phpself);
        }
        $this->smarty->assign('jsonVars', $jsonVars);


        $html = $this->display(__FILE__, 'header.tpl');
        return $html;
    }
}

?>