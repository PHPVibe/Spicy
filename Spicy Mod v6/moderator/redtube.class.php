<?php
class RedVibe {	
	public function getAllRed($page) {		
		$feedURL = 'https://api.redtube.com/?data=redtube.Videos.searchVideos&output=json&thumbsize=big&page='.$page;
		$content = $this->getDataFromUrl($feedURL);
		$content = json_decode($content,true);
			
		$videosList = $content['videos'];
		return $videosList;
	}
	
	
		public function getAllCats() {
		$feedURL = 'https://api.redtube.com/?data=redtube.Categories.getCategoriesList&output=json';
		$content = $this->getDataFromUrl($feedURL);
		$content = json_decode($content,true);			
		return $content;
	}
	
	public function getAllStars() {	
		$feedURL = 'https://api.redtube.com/?data=redtube.Stars.getStarList&output=json';
		$content = $this->getDataFromUrl($feedURL);
		$content = json_decode($content,true);			
		
		return $content;
	}
	
	public function getAllTags() {			
		$feedURL = 'https://api.redtube.com/?data=redtube.Tags.getTagList&output=json';
				$content = $this->getDataFromUrl($feedURL);
				$content = json_decode($content,true);			
		return $content;
	}
	
	public function RedSearch($search, $page, $tags =NULL) {
		
		$feedURL = 'https://api.redtube.com/?data=redtube.Videos.searchVideos&output=json';
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
		
		$feedURL = 'https://api.redtube.com/?data=redtube.Videos.searchVideos&output=json';
		$feedURL .= '&tags[]='.$tags;		
		$feedURL .= '&thumbsize=big&page='.$page;
		$content = $this->getDataFromUrl($feedURL);
		$content = json_decode($content,true);
		return $content;
	}
	
		public function RedCategory($cat, $page, $tags =NULL) {
		
		$feedURL = 'https://api.redtube.com/?data=redtube.Videos.searchVideos&output=json';
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
		
		$feedURL = 'https://api.redtube.com/?data=redtube.Videos.searchVideos&output=json';
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
		$data = file_get_contents($url);
		
		return $data;
	}
}
?>