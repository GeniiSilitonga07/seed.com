<?php
	namespace web;
	class Status
	{
 		// attributes
 		protected $jsonPath;
 		protected $statuses;

 		// constructor
 		public function __construct($jsonPath)
 	{
 		$this->jsonPath = $jsonPath;
 		$this->loadStatus();
	}
 	// to load the existing statuses
 	private function loadStatus()
 	{
		$this->statuses = json_decode(\file_get_contents($this->jsonPath));
	}
 	// to retrieve text of the latest published status
 	public function getLatestText()
 	{
 		$lastIndex = sizeof($this->statuses) - 1;
 		return ($this->statuses[$lastIndex]->text);
 	}
 	// to retrieve text of the latest published status
 	public function getLatestText2()
 	{
 		$lastIndex = sizeof($this->statuses) - 2;
 		return ($this->statuses[$lastIndex]->text);
 	}
 	// to retrieve text of the latest published status
 	public function getLatestText3()
 	{
 		$lastIndex = sizeof($this->statuses) - 3;
 		return ($this->statuses[$lastIndex]->text);
 	}
 	// to retrieve text of the latest published status
 	public function getLatestText4()
 	{
 		$lastIndex = sizeof($this->statuses) - 4;
 		return ($this->statuses[$lastIndex]->text);
 	}
 	// to retrieve date of the latest published status
 	public function getLatestDate()
 	{
 		$lastIndex = sizeof($this->statuses) - 1;
 		return ($this->statuses[$lastIndex]->date);
 	}
 	// to retrieve all the published statuses
 	public function allStatuses()
 	{
 		return ($this->statuses);
 	}
 	// to add a new status
 	public function addStatus($text)
 	{
 		$time = time();
 		$date = date("d m Y H:i:s", $time);
 		$this->statuses[] = [
 			"time" => $time,
 			"date" => $date,
 			"text" => $text,
 		];
		// write the new list of statuses into a persistent file
 		file_put_contents(
 			$this->jsonPath, json_encode($this->statuses, JSON_PRETTY_PRINT)
		);
 	return (true);
 	}
 }