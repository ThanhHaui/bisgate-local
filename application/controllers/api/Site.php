<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends MY_Controller {

	public function init(){
		header('Content-Type: application/json');
		$this->loadModel(array('Mconfigs', 'Msliders'));
		$config =  $this->Mconfigs->getListMap();
		$listSliders = $this->Msliders->getApiList(1);
		$listConfigs = array(
			'logoUrl' => base_url().IMAGE_PATH.$config['LOGO_IMAGE'],
			'companyName' => $config['COMPANY_NAME'],
			'siteName' => $config['SITE_NAME'],
			'description' => $config['META_DESC'],
			'phone' => $config['PHONE_NUMBER'],
			'email' => $config['EMAIL_CONTACT'],
			'address' => $config['ADDRESS'],
			'videoTitle' => $config['YOUTUBE_TITLE_HEADER'],
			'videoUrl' => $config['YOUTUBE_LINK_HEADER'],
			'videoDescription' => $config['YOUTUBE_TITLE_FOOTER'],
			'videoIcon' => base_url().IMAGE_PATH.$config['YOUTUBE_IMAGE_FOOTER'],
			'reviewTitle' => $config['REVIEW_TITLE'],
			'reivewDescription' => $config['REVIEW_DESCRIPTION'],
			'priceTitle' => $config['PRICE_TITLE'],
			'priceDescription' => $config['PRICE_DESCRIPTION'],
			'sizeTitle' => $config['INTRODUCE_TITLE_1'],
			'sizeDescription' => $config['INTRODUCE_INFO_1'],
			'evaluate' => $config['EVALUATE'],
			'evaluateDescription' => $config['EVALUATE_INFO'],
			'slogan' => $config['INTRODUCE_INFO_2'],
			'reviews' => $listSliders,
		);
		echo json_encode($listConfigs);
	}
}