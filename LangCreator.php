<?php

ini_set('max_execution_time', 0);

class LangCreator
{	
	public $folder;
	public $from;
	public $to;

	public function __construct($folder,$to,$from='en')
	{	

		// Get Google Trans API Key For API Call
		Config::readEnv();
		$configData = Config::$envArr;
		$this->google_key = $configData['GOOGLE_TRANS_KEY'] ?? '';


		$this->folder = $folder;
		$this->from = $folder;
		$this->to = 'final_result/'.$to;
		$this->original_to = $to;
		
		$this->count = 0;
	}	

	public function getFolderFiles()
	{
		$folderFiles = scandir($this->folder);
		unset($folderFiles[0]);
		unset($folderFiles[1]);
		return $folderFiles;
	}

	public function readFileGetValue($file){
		$temp = $this->folder.'/'.$file;
		$fileData = file_get_contents($temp);
		$content = eval("?>$fileData");
		return $content;
	}

	public function creator(){
		$this->folderMk();
		exec('chmod -R 777 *');
		$filesArr = $this->getFolderFiles();
		foreach($filesArr as $file){
			$newFile = $this->to.'/'.$file;
			$fileDataArr = $this->readFileGetValue($file);
			//Write Initial
			$this->mainWriteFile($newFile);
			
			$transArr = $this->transArr($fileDataArr,$newFile);

			//Write End
			$this->mainWriteFile($newFile,'stop');

		}
		exec('chmod -R 777 *');
	}

	private function folderMk(){
		if (!file_exists($this->to)) {
		    mkdir($this->to, 0777, true);
		}
	}


	public function writeTransFile($value){
		$fp = fopen('result2.txt',"wb");
		$temp = '';
		foreach($value as $key => $data){
			$temp .= '"'.$key.'"'.' => "'.$data.'"'.PHP_EOL;
		}
		fwrite($fp,$temp);
		fclose($fp);
	}


	public function transArr($arr,$filename){
		foreach($arr as $key => $value){
			$type = gettype($value);
			if($type == 'array'){
				$this->writeFile($key,'[','1',$filename);
				$transArr = $this->transArr($value,$filename);
				$arr[$key] = $transArr;
				$this->writeFile('','],','2',$filename);
			}else{
				//sleep(1);
				//$value = $this->transWord($value);
				// $this->createLog($value);
				$value = $this->transLate($value);
				$this->writeFile($key,$value,'4',$filename);

			}
		}
		return $arr;
	}


	public function writeFile($key ,$value,$type = '4',$filename){
		$fp = fopen($filename,"a");
		if($type == '1'){
			$temp = '"'.$key.'"'.' => ['.''.PHP_EOL;
		}else if($type == '2'){
			$temp = '],'.PHP_EOL;
		}else{
			$temp = '"'.$key.'"'.' => "'.$value.'",'.PHP_EOL;
		}
		fwrite($fp,$temp);
		fclose($fp);
	}

	public function mainWriteFile($filename,$position = 'start'){
		$fp = fopen($filename,"a");
		if($position == 'start'){
			$temp = '<?php'.PHP_EOL.'return'.PHP_EOL.'['.PHP_EOL;
		}else{
			$temp = PHP_EOL.'];';
		}
		fwrite($fp,$temp);
		fclose($fp);
	}


	public function transWord($word){
		return $this->transObj->translate($word);
	}


	public function transLate($word){
		if(!$this->google_key){
			return $word;
		}
		$word = urlencode($word);
		try {
			$curl = curl_init();
			$url = 'https://www.googleapis.com/language/translate/v2?key='.$this->google_key.'&source='.$this->from.'&target='.$this->original_to.'&q='.$word;
			curl_setopt_array($curl, array(
			  CURLOPT_URL => $url,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'GET',
			));
			$response = curl_exec($curl);
			curl_close($curl);
			$response = json_decode($response);
			
			if(isset($test->data)){
				$response = $response->data->translations[0];
				return $response->translatedText;
			}else{
				return urldecode($word);
			}
		} catch (Exception $e) {
			return $e->getMessges();
		}
		
	}

	public function createLog($value)
	{	
		$this->count++;
		$fp = fopen('log.txt',"a");
		$temp = 'Request Number: '.$this->count." ".date('Y-m-d H:i:s').' Txt:'.$value.PHP_EOL;
		fwrite($fp,$temp);
		fclose($fp);
	}

}

