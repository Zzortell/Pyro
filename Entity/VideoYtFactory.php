<?php

namespace Zz\PyroBundle\Entity;

use Google_Client;
use Google_Service_YouTube;

class VideoYtFactory
{
	protected $yt;
	
	public function __construct ( $devKey )
	{
		$client = new Google_Client;
		$client->setDeveloperKey($devKey);
		
		$this->yt = new Google_Service_YouTube ($client);
	}
	
	public function hydrateVideo ( $video )
	{
		$response = $this->yt->videos->listVideos('id, snippet, contentDetails', [
			'id' => $video->getId()
		]);
		
		$video
			->setPublishedAt(new \DateTime ($response[0]['snippet']['publishedAt']))
			->setTitle($response[0]['snippet']['title'])
			->setThumbnail($response[0]['snippet']['thumbnails']['default']['url'])
			->setDuration($response[0]['contentDetails']['duration'])
		;
	}
}
