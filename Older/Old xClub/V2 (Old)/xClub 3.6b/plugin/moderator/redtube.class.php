<?php
class RedVibe {	
	public function getAllRed($page) {		
		$feedURL = 'http://api.redtube.com/?data=redtube.Videos.searchVideos&output=json&thumbsize=big&page='.$page;
		$content = $this->getDataFromUrl($feedURL);
		$content = json_decode($content,true);
			
		$videosList = $content['videos'];
		return $videosList;
	}
	
	
		public function getAllCats() {
		
		
		$filename = "redtube/cats.json";
		if (file_exists($filename)) {
			$feedURL = admin_url().$filename;	
			} else {
		$webURL = 'http://api.redtube.com/?data=redtube.Categories.getCategoriesList&output=json';
		$data = $this->getDataFromUrl($webURL);
		if (!file_put_contents($filename, $data)) {
			return false;
		}
		$feedURL = admin_url().$filename;	
		}
		$content = $this->getDataFromUrl($feedURL);
		$content = json_decode($content,true);			
		return $content;
	}
	
	public function getAllStars() {
	$filename = "redtube/stars.json";
		if (file_exists($filename)) {
			$feedURL = admin_url().$filename;	
			} else {
		$webURL = 'http://api.redtube.com/?data=redtube.Stars.getStarList&output=json';
		$data = $this->getDataFromUrl($webURL);
		if (!file_put_contents($filename, $data)) {
			return false;
		}
		$feedURL = admin_url().$filename;	
		}
		$content = $this->getDataFromUrl($feedURL);
		$content = json_decode($content,true);			
		
		return $content;
	}
	
	public function getAllTags() {		
		$filename = "redtube/tags.json";
		if (file_exists($filename)) {
			$feedURL = admin_url().$filename;	
			} else {
		$webURL = 'http://api.redtube.com/?data=redtube.Tags.getTagList&output=json';
		$data = $this->getDataFromUrl($webURL);
		if (!file_put_contents($filename, $data)) {
			return false;
		}
		$feedURL = admin_url().$filename;	
		}
		$content = $this->getDataFromUrl($feedURL);
		$content = json_decode($content,true);			
		return $content;
	}
	
	public function RedSearch($search, $page, $tags =NULL) {
		
		$feedURL = 'http://api.redtube.com/?data=redtube.Videos.searchVideos&output=json';
		$feedURL .= '&search='.$search;
		if(!is_null($tags)) {
		$feedURL .= '&tags[]='.$tags;
		}
		$feedURL .= '&thumbsize=big&page='.$page;
		$content = $this->getDataFromUrl($feedURL);
		$content = json_decode($content,true);
		return $content;
	}
	
		public function RedTags( $tags , $page) {
		
		$feedURL = 'http://api.redtube.com/?data=redtube.Videos.searchVideos&output=json';
		$feedURL .= '&tags[]='.$tags;		
		$feedURL .= '&thumbsize=big&page='.$page;
		$content = $this->getDataFromUrl($feedURL);
		$content = json_decode($content,true);
		return $content;
	}
	
		public function RedCategory($cat, $page, $tags =NULL) {
		
		$feedURL = 'http://api.redtube.com/?data=redtube.Videos.searchVideos&output=json';
		$feedURL .= '&category='.$cat;
		if(!is_null($tags)) {
		$feedURL .= '&tags[]='.$tags;
		}
		$feedURL .= '&thumbsize=big&page='.$page;
		$content = $this->getDataFromUrl($feedURL);
		$content = json_decode($content,true);
		return $content;
	}
	public function RedStar($star, $page, $tags =NULL) {
		
		$feedURL = 'http://api.redtube.com/?data=redtube.Videos.searchVideos&output=json';
		$feedURL .= '&search='.$star;
		$feedURL .= '&stars[]='.$star;
		if(!is_null($tags)) {
		$feedURL .= '&tags[]='.$tags;
		}
		$feedURL .= '&thumbsize=big&page='.$page;
		$content = $this->getDataFromUrl($feedURL);
		$content = json_decode($content,true);
		return $content;
	}
	
	private	function getDataFromUrl($url) {
		$ch = curl_init();
		$timeout = 15;
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
}
?>