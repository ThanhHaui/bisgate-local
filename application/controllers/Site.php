<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends MY_Controller {

	public function __construct(){
		parent::__construct();
        $this->loadModel(array('Mconfigs', 'Mmenuitems', 'Mproperties', 'Mcategories'));
	}

	private function commonDataSite($title = ''){
		$configSites =  $this->Mconfigs->getListMap();
		$data = array(
			'title' => $title . $configSites['COMPANY_NAME'],
			'configSites' => $configSites,
            'listMenuItems' => $this->Mmenuitems->getListByPosition(array(1, 2, 3, 4), true),
            'propertyCategoryRedirect' => base_url(),
		);
		return $data;
	}

    public function index(){
	    $this->loadModel(array('Msliders', 'Magents'));
	    $limitProperty = 6;
        $data = array(
            'isHome' => true,
            'listSliders' => $this->Msliders->getList(1),
            'configHomes' => $this->Mconfigs->getListMap(2),
            'listAgents' => $this->Magents->getBy(array('StatusId' => STATUS_ACTIVED)),
            'limitProperty' => $limitProperty,
            'countProperty' => $this->Mproperties->getCount(array('StatusId' => STATUS_ACTIVED)),
            'listProperties' => $this->Mproperties->search(array('StatusId' => STATUS_ACTIVED), $limitProperty),
            'listCateProperties' => $this->Mcategories->getListByItemType(3)
        );
        $data = array_merge($data, $this->commonDataSite('Home - '));
        $data['configSites']['pageUrl'] = base_url();
		$this->load->view('site/home', $data);
	}

	public function categoryProperty($categorySlug = '', $categoryId = 0, $page = 1){
		if($categoryId > 0) {
			$category = $this->Mcategories->get($categoryId);
			if($category && $category['StatusId'] == 2 && $category['ItemTypeId'] == 3) {
				if($category['CategorySlug'] == $categorySlug) {
					$data = array(
                        'isHome' => false,
						'categoryUrlPage' => base_url('category/' . $category['CategorySlug'] . '-c' . $categoryId . '-page-{$1}.html'),
						'pageTitle' => $category['CategoryName'],
                        'listCateProperties' => $this->Mcategories->getListByItemType(3)
					);
					$data = array_merge($data, $this->commonDataSite($category['CategoryName'].' - '));
					$data['propertyCategoryRedirect'] = empty($category['LinkRedirect']) ? base_url() : $category['LinkRedirect'];
					$data['configSites']['pageUrl'] = $this->Mconstants->getUrl($category['CategorySlug'], $categoryId, 1);
					if (!is_numeric($page)) $page = 1;
					if ($page <= 0) $page = 1;
					$searchData = array('StatusId' => STATUS_ACTIVED, 'CategoryId' => $categoryId);
					$propertyCount = $this->Mproperties->getCount($searchData);
					$pageCount = 1;
					$listProperties = array();
					if ($propertyCount > 0) {
						$perPage = 12;
						$pageCount = ceil($propertyCount / $perPage);
						if ($page > $pageCount) $page = $pageCount;
						$listProperties = $this->Mproperties->search($searchData, $perPage, $page);
					}
					$data['propertyCount'] = $propertyCount;
					$data['pageCurrent'] = $page;
					$data['pageCount'] = $pageCount;
					$data['listProperties'] = $listProperties;
                    $this->load->view('site/properties', $data);
				}
				else redirect(base_url('category/' . $category['CategorySlug'] . '-c' . $categoryId . '-page-' . $page . '.html'));
			}
			else redirect(base_url());
		}
        else redirect(base_url());
	}

    public function agentProperty($agentSlug = '', $agentId = 0, $page = 1){
        if($agentId > 0) {
            $this->load->model('Magents');
            $agent = $this->Magents->get($agentId);
            if($agent && $agent['StatusId'] == 2) {
                if($agent['AgentSlug'] == $agentSlug) {
                    $data = array(
                        'isHome' => false,
                        'categoryUrlPage' => base_url('agent/' . $agent['AgentSlug'] . '-c' . $agentId . '-page-{$1}.html'),
                        'pageTitle' => $agent['AgentName'],
                        'listCateProperties' => $this->Mcategories->getListByItemType(3)
                    );
                    $data = array_merge($data, $this->commonDataSite($agent['AgentName'].' - '));
                    $data['configSites']['pageUrl'] = $this->Mconstants->getUrl($agent['AgentSlug'], $agentId, 2);
                    if (!is_numeric($page)) $page = 1;
                    if ($page <= 0) $page = 1;
                    $searchData = array('StatusId' => STATUS_ACTIVED, 'AgentId' => $agentId);
                    $propertyCount = $this->Mproperties->getCount($searchData);
                    $pageCount = 1;
                    $listProperties = array();
                    if ($propertyCount > 0) {
                        $perPage = 12;
                        $pageCount = ceil($propertyCount / $perPage);
                        if ($page > $pageCount) $page = $pageCount;
                        $listProperties = $this->Mproperties->search($searchData, $perPage, $page);
                    }
                    $data['propertyCount'] = $propertyCount;
                    $data['pageCurrent'] = $page;
                    $data['pageCount'] = $pageCount;
                    $data['listProperties'] = $listProperties;
                    $this->load->view('site/properties', $data);
                }
                else redirect(base_url('agent/' . $agent['AgentSlug'] . '-c' . $agentId . '-page-' . $page . '.html'));
            }
            else redirect(base_url());
        }
        else redirect(base_url());
    }

	public function search(){
		$this->load->helper('security');
        $searchData = array(
            'StatusId' => STATUS_ACTIVED,
            'SearchText' => isset($_GET['s']) ? xss_clean(trim($_GET['s'])) : '',
            'CategoryId' => isset($_GET['property_type']) && $_GET['property_type'] > 0 ? $_GET['property_type'] : 0,
            'BedRoom' => isset($_GET['bedroom']) && $_GET['bedroom'] > 0 ? $_GET['bedroom'] : 0,
            'BathRoom' => isset($_GET['bathroom']) && $_GET['bathroom'] > 0 ? $_GET['bathroom'] : 0,
            'PriceMin' => isset($_GET['min_price']) && $_GET['min_price'] > 0 ? $_GET['min_price'] : 0,
            'PriceMax' => isset($_GET['max_price']) && $_GET['max_price'] > 0 ? $_GET['max_price'] : 0
        );
        $labels = array(
            'SearchText' => 's',
            'CategoryId' => 'property_type',
            'BedRoom' => 'bedroom',
            'BathRoom' => 'bathroom',
            'PriceMin' => 'min_price',
            'PriceMax' => 'max_price'
        );
        $categoryUrlPage = base_url('search.html?page={$1}');
        foreach($searchData as $label => $value){
            if($label != 'StatusId' && !empty($value)) $categoryUrlPage .= '&'.$labels[$label].'='.$value;
        }
		$data = array(
            'isHome' => false,
			'categoryUrlPage' => $categoryUrlPage,
			'pageTitle' => empty($q) ? 'Search property' : 'Search property "'.$q.'"',
            'listCateProperties' => $this->Mcategories->getListByItemType(3),
		);
		$data = array_merge($data, $this->commonDataSite('Search - '));
		$data['configSites']['pageUrl'] = $categoryUrlPage;
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		if (!is_numeric($page)) $page = 1;
		if ($page <= 0) $page = 1;
		$propertyCount = $this->Mproperties->getCount($searchData);
		$pageCount = 1;
		$listProperties = array();
		if ($propertyCount > 0) {
			$perPage = 12;
			$pageCount = ceil($propertyCount / $perPage);
			if($page > $pageCount) $page = $pageCount;
			$listProperties = $this->Mproperties->search($searchData, $perPage, $page);
		}
        $data['propertyCount'] = $propertyCount;
		$data['pageCurrent'] = $page;
		$data['pageCount'] = $pageCount;
        $data['listProperties'] = $listProperties;
        $this->load->view('site/properties', $data);
	}

    public function detailProperty($propertySlug = '', $propertyId = 0){
        if($propertyId > 0){
            $this->loadModel(array('Mitemmetadatas', 'Mcategoryitems', 'Magents', 'Mservices'));
            $property = $this->Mproperties->get($propertyId);
            if($property && $property['StatusId'] > 0){
                if($property['PropertySlug'] == $propertySlug){
                    $data = array(
                        'isHome' => false,
                        'scriptHeader' => array('css' => 'vendor/plugins/pnotify/pnotify.custom.min.css'),
                        'scriptFooter' => array('js' => array('vendor/plugins/pnotify/pnotify.custom.min.js', 'https://www.google.com/recaptcha/api.js', 'front/js/feedback.js')),
                        'property' => $property,
                        'propertyUrl' => $this->Mconstants->getUrl($propertySlug, $propertyId, 3),
                        'categoryNames' => array(),
                        'agent' => $property['AgentId'] > 0 ? $this->Magents->get($property['AgentId']) : false,
                        'serviceNames' => $this->Mservices->getListServiceName($propertyId),
                        'listCateProperties' => $this->Mcategories->getListByItemType(3),
                        'listProperties' => array()
                    );
                    $data = array_merge($data, $this->commonDataSite($property['PropertyName'].' - '));
                    $data['configSites']['pageUrl'] = $data['propertyUrl'];
                    $propertySeo = $this->Mitemmetadatas->getBy(array('ItemId' => $propertyId, 'ItemTypeId' => 3), true);
                    if(!empty($propertySeo['TitleSEO'])) $data['title'] = $propertySeo['TitleSEO'] . $data['configSites']['COMPANY_NAME'];
                    if(!empty($propertySeo['MetaDesc'])) $data['configSites']['META_DESC'] = $propertySeo['MetaDesc'];
                    $categoryIds = $this->Mcategoryitems->getListFieldValue(array('ItemId' => $propertyId, 'ItemTypeId' => 3), 'CategoryId');
                    if(!empty($categoryIds)){
                        $data['categoryNames'] = $this->Mcategories->getCategoryNames($categoryIds);
                        $data['listProperties'] = $this->Mproperties->search(array('StatusId' => STATUS_ACTIVED, 'CategoryIds' => implode(', ', $categoryIds)), 6);
                    }
                    $this->load->view('site/detail_property', $data);
                }
                else redirect(base_url('property/' . $property['PropertySlug'] . '-p' . $propertyId . '.html'));
            }
            else redirect(base_url());
        }
        else redirect(base_url());
    }

	public function categoryArticle($categorySlug = '', $categoryId = 0, $page = 1){
        if($categoryId > 0) {
            $category = $this->Mcategories->get($categoryId);
            if ($category && $category['StatusId'] == 2 && $category['ItemTypeId'] == 4) {
                if($category['CategorySlug'] == $categorySlug) {
                    $data = array(
                        'isHome' => false,
                        'categoryUrlPage' => base_url('news/' . $category['CategorySlug'] . '-c' . $categoryId . '-page-{$1}.html'),
                        'pageTitle' => $category['CategoryName']
                    );
                    $data = array_merge($data, $this->commonDataSite($category['CategoryName'].' - '));
                    $data['configSites']['pageUrl'] = $this->Mconstants->getUrl($category['CategorySlug'], $categoryId, 1);
                    if (!is_numeric($page)) $page = 1;
                    if ($page <= 0) $page = 1;
                    $searchData = array('ArticleStatusId' => STATUS_ACTIVED, 'ArticleTypeId' => 1, 'CategoryId' => $categoryId);
                    $this->load->model('Marticles');
                    $articlesCount = $this->Marticles->getCount($searchData);
                    $pageCount = 1;
                    $listArticles = array();
                    if ($articlesCount > 0) {
                        $perPage = 6;
                        $pageCount = ceil($articlesCount / $perPage);
                        if ($page > $pageCount) $page = $pageCount;
                        $listArticles = $this->Marticles->search($searchData, $perPage, $page);
                    }
                    $data['articlesCount'] = $articlesCount;
                    $data['pageCurrent'] = $page;
                    $data['pageCount'] = $pageCount;
                    $data['listArticles'] = $listArticles;
                    $this->load->view('site/articles', $data);
                }
                else redirect(base_url('news/' . $category['CategorySlug'] . '-c' . $categoryId . '-page-' . $page . '.html'));
            }
            else redirect(base_url());
        }
        else redirect(base_url());
    }

    public function detailArticle($articleSlug = '', $articleId = 0){
        if($articleId > 0){
            $this->loadModel(array('Marticles', 'Magents'));
            $article = $this->Marticles->get($articleId);
            if($article && $article['ArticleStatusId'] == STATUS_ACTIVED){
                if($article['ArticleSlug'] == $articleSlug) {
                    $data = array(
                        'article' => $article,
                        'articleUrl' => $this->Mconstants->getUrl($articleSlug, $article['ArticleId'], 4),
                        'listAgents' => $this->Magents->getBy(array('StatusId' => STATUS_ACTIVED))
                    );
                    $data = array_merge($data, $this->commonDataSite($article['ArticleTitle'] . ' - '));
                    $data['configSites']['pageUrl'] = $data['articleUrl'];
                    $this->load->view('site/detail_article', $data);
                }
                else redirect(base_url('article/' . $article['ArticleSlug'] . '-a' . $articleId . '.html'));
            }
            else redirect(base_url());
        }
        else redirect(base_url());
    }

    public function contact(){
        $this->load->model('Marticles');
        $data = array(
            'isHome' => false,
            'pageTitle' => 'Contact',
            'contactContent' => $this->Marticles->getFieldValue(array('ArticleSlug' => 'contact-us'), 'ArticleContent'),
            'scriptHeader' => array('css' => 'vendor/plugins/pnotify/pnotify.custom.min.css'),
            'scriptFooter' => array('js' => array('vendor/plugins/pnotify/pnotify.custom.min.js', 'https://www.google.com/recaptcha/api.js', 'front/js/feedback.js'))
        );
        $data = array_merge($data, $this->commonDataSite('Contact - '));
        $data['configSites']['pageUrl'] = base_url('contact.html');
        $this->load->view('site/contact', $data);
    }
}