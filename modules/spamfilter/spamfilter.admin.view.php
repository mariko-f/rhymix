<?php
/* Copyright (C) NAVER <http://www.navercorp.com> */
/**
 * @class  spamfilterAdminView
 * @author NAVER (developers@xpressengine.com)
 * @brief The admin view class of the spamfilter module
 */
class spamfilterAdminView extends spamfilter
{
	/**
	 * @brief Initialization
	 */
	function init()
	{
		// Set template path
		$this->setTemplatePath($this->module_path.'tpl');
	}

	/**
	 * @brief Output the list of banned IPs
	 */
	function dispSpamfilterAdminDeniedIPList()
	{
		// Get sort index
		$sort_index = Context::get('sort_index');
		if (!in_array($sort_index, array('regdate', 'latest_hit', 'hit')))
		{
			$sort_index = 'regdate';
		}

		// Get the list of denied IP addresses and words
		$oSpamFilterModel = getModel('spamfilter');
		$ip_list = $oSpamFilterModel->getDeniedIPList($sort_index);
		Context::set('ip_list', $ip_list);

		$security = new Security();
		$security->encodeHTML('ip_list..');

		// Set a template file
		$this->setTemplateFile('denied_ip_list');

	}

	/**
	 * @brief Output the list of banned words
	 */
	function dispSpamfilterAdminDeniedWordList()
	{
		// Get sort index
		$sort_index = Context::get('sort_index');
		if (!in_array($sort_index, array('regdate', 'latest_hit', 'hit')))
		{
			$sort_index = 'hit';
		}

		// Get the list of denied IP addresses and words
		$oSpamFilterModel = getModel('spamfilter');
		$word_list = $oSpamFilterModel->getDeniedWordList($sort_index);
		Context::set('word_list', $word_list);

		$security = new Security();
		$security->encodeHTML('word_list..word');

		// Set a template file
		$this->setTemplateFile('denied_word_list');
	}

	/**
	 * @brief Configure auto block
	 */
	function dispSpamfilterAdminConfigBlock()
	{
		$config = ModuleModel::getModuleConfig('spamfilter');
		Context::set('config', $config);

		$this->setTemplateFile('config_block');
	}

	/**
	 * @brief Configure CAPTCHA
	 */
	function dispSpamfilterAdminConfigCaptcha()
	{
		$config = ModuleModel::getModuleConfig('spamfilter');
		Context::set('config', $config);

		$this->setTemplateFile('config_captcha');
	}
}
/* End of file spamfilter.admin.view.php */
/* Location: ./modules/spamfilter/spamfilter.admin.view.php */
