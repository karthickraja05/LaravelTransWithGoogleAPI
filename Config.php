<?php 


class Config 
{
	public static $envArr;

	public function __construct()
	{
		
	}

	public static function readEnv(){
		$data = file_get_contents('.env');
		$dataArr = explode(PHP_EOL, $data);
		$newDataForm = [];
		if(count($dataArr)){
			foreach ($dataArr as $value) {
				$tempArr = explode('=', $value);
				if(count($tempArr) == 2){
					$newDataForm[$tempArr[0]] = $tempArr[1];
				}
			}
		}
		
		self::$envArr = $newDataForm;
	}


}