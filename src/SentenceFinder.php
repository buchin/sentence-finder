<?php 
namespace Buchin\SentenceFinder;
use GuzzleHttp\Client;
/**
* 
*/
class SentenceFinder
{
	protected $_client = null;
	protected $_stop = '/[.?!]/';

	public function __construct()
	{
		$this->_client = new Client();
	}
	
	public function findSentence($word)
	{
		$sentences = [];

		$rss = $this->getBingRss($word);
		$searchResults = $this->parseBingRss($rss);

		foreach ($searchResults as $result) {
			$sentence = $this->parseResult($result, $word);

			if(!empty($sentence)){
				$sentences[] = $sentence;
			}
		}

		return $sentences;
	}

	public function getBingRss($word)
	{
		$response = $this->_client->get('http://www.bing.com/search', [
			'query' => [
				'format' => 'rss',
				'q' => 'inbody:"' . $word . '"',
				]
			]);

		return ($response->getStatusCode() == 200) ? $response->getBody()->getContents() : false;
	}

	public function parseBingRss($rss)
	{
		$results = [];
		$xml = simplexml_load_string($rss)->xpath('//channel/item');

		foreach ($xml as $node) {
			$results[] = (string) $node->description;
		}

		return $results;
	}

	public function parseResult($result, $word)
	{
		$extracted = preg_split($this->_stop, $result);

		foreach ($extracted as $sentence) {
			$pos = stripos($sentence, $word);
			if($pos !== false){
				return trim($sentence);
			}
		}
	}
}
