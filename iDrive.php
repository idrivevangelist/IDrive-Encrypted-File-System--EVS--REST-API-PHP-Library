<?php
	class iDrive{

		private $data = Array();

		public function __construct($uid, $pwd, $crtpath){
		
			$this->data['uid'] = $uid;
			$this->data['pwd'] = $pwd;
			$this->data['crtpath'] = $crtpath;

			$url = "https://evs.idrive.com/evs";

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url.'/getServerAddress');

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);

			$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'];

			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8'));
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($ch,CURLOPT_CAINFO,$this->data['crtpath']);

			$output = curl_exec($ch);
			
			$ServerInfo = new SimpleXMLElement($output);
			$Message = $ServerInfo['message'];
			$cmdUtilityServer = $ServerInfo['cmdUtilityServer'];
			$cmdUtilityServerIP = $ServerInfo['cmdUtilityServerIP'];
			$webApiServer = $ServerInfo['webApiServer'];
			$webApiServerIP = $ServerInfo['webApiServerIP'];

			$this->data['weburl'] = $webApiServer;
			$this->data['webip'] = $webApiServerIP;
			$this->data['cmdurl'] = $cmdUtilityServer;
			$this->data['cmdip'] = $cmdUtilityServerIP;

			curl_close($ch);
			
		}
		public function execute($page, $params){
			$params['uid'] = $this->data['uid'];
			$params['pwd'] = $this->data['pwd'];

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->data['weburl']."/evs/".$page);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POST, true);

			$body = "";
			foreach ($params as $key => $value) {
				$body .= $key.'='.$value.'&';
			}
			$body = trim($body, '&');
			echo $body;
			if($page == 'uploadFile' || $page == 'downloadFile'){
				$header = 'multipart/form-data';
			}else{
				$header = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
			}
			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header));
                        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
                        curl_setopt($ch,CURLOPT_CAINFO,$this->data['crtpath']);

			$output = curl_exec($ch);
			curl_close($ch);
			return $output;
		}
		public function  getServerAddress(){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://evs.idrive.com/evs/getServerAddress');

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);

			$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'];

			//echo $body;

			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8'));
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($ch,CURLOPT_CAINFO,$this->data['crtpath']);

			$output = curl_exec($ch);
			curl_close($ch);
			return $output;
		}
		public function  validateAccount(){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->data['weburl'].'/evs/validateAccount');

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);

			$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'];


			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8'));
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($ch,CURLOPT_CAINFO,$this->data['crtpath']);

			$output = curl_exec($ch);
			


			curl_close($ch);
			return $output;			
		}
		public function  configureAccount($parameters){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->data['weburl'].'/evs/configureAccount');

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);

			$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'].'&enctype='.$parameters['enctype'].'&pvtkey='.$parameters['pvtkey'];

			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8'));
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($ch,CURLOPT_CAINFO,$this->data['crtpath']);

			$output = curl_exec($ch);

			curl_close($ch);		
			return $output;
		}
		public function  validatePvtKey($parameters){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->data['weburl'].'/evs/validatePvtKey');

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);

			$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'].'&pvtkey='.$parameters['pvtkey'];

			//echo $body;

			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8'));
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($ch,CURLOPT_CAINFO,$this->data['crtpath']);

			$output = curl_exec($ch);
			


			curl_close($ch);	
			return $output;			
		}
		public function  uploadFile($parameters){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->data['weburl'].'/evs/uploadFile');

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);

			$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'].'&p='.$parameters['p'].'&pvtkey='.$parameters['pvtkey'];

			//echo $body;

			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('multipart/form-data'));
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($ch,CURLOPT_CAINFO,$this->data['crtpath']);

			$output = curl_exec($ch);
			


			curl_close($ch);		
			return $output;
		}
		public function  downloadFile(){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->data['weburl'].'/evs/downloadFile');

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);

			$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'].'&p='.$parameters['p'].'&pvtkey='.$parameters['pvtkey'].'&version='.$parameters['version'].'&thumbnail_type='.$parameters['thumbnail_type'].'&trash='.$parameters['trash'];

			//echo $body;

			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('multipart/form-data'));
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($ch,CURLOPT_CAINFO,$this->data['crtpath']);

			$output = curl_exec($ch);
			


			curl_close($ch);
			return $output;
		}
		public function  searchFiles($parameters){
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL, $this->data['weburl'].'/evs/searchFiles');

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);

			$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'].'&p='.urlencode($parameters['p']).'&searchKey='.$parameters['searchKey'].'&trash='.$parameters['trash'];

			//echo $body;

			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8'));
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($ch,CURLOPT_CAINFO,$this->data['crtpath']);

			$output = curl_exec($ch);			


			curl_close($ch);
			return $output;
		}
		public function  getVersions($parameters){
			//consistantly returns invalid path despite the inputed parameter
			//accepts p as the path to the file being requested
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->data['weburl'].'/evs/getVersions');

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);

			$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'].'&p='.urlencode($parameters['p']);

			//echo $body;

			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8'));
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($ch,CURLOPT_CAINFO,$this->data['crtpath']);

			$output = curl_exec($ch);
			


			curl_close($ch);
			return $output;
		}
		public function  getProperties($parameters){
			//consistantly returns invalid path despite the inputed parameter
			//accepts p as the path to the file being requested		
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->data['weburl'].'/evs/getProperties');

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);

			$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'].'&p='.urlencode($parameters['p']);

			//echo $body;

			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8'));
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($ch,CURLOPT_CAINFO,$this->data['crtpath']);

			$output = curl_exec($ch);
			
			curl_close($ch);
			return $output;
		}
		public function  isFileFolderExists($parameters) {
			//after deleting all file folders in my account and running this function I got a message back of true
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->data['weburl'].'/evs/isFileFolderExists');

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);

			$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'].'&p='.urlencode($parameters['p']);

			//echo $body;

			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8'));
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($ch,CURLOPT_CAINFO,$this->data['crtpath']);

			$output = curl_exec($ch);
			


			curl_close($ch);
			return $output;
		}
		public function  createFolder($parameters){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->data['weburl'].'/evs/createFolder');

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);

			if($parameters['pvtkey'] == ''){
				$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'].'&p='.urlencode($parameters['p']).'&foldername='.urlencode($parameters['foldername']);
			}else{
				$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'].'&p='.urlencode($parameters['p']).'&pvtkey='.$parameters['pvtkey'].'&foldername='.urlencode($parameters['foldername']);
			}

			//echo $body;

			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8'));
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($ch,CURLOPT_CAINFO,$this->data['crtpath']);

			$output = curl_exec($ch);
			


			curl_close($ch);
			return $output;
		}
		public function  renameFileFolder($parameters){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->data['weburl'].'/evs/renameFileFolder');

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);

			if($parameters['pvtkey'] == ''){
				$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'].'&oldpath='.urlencode($parameters['oldpath']).'&newpath='.urlencode($parameters['newpath']);
			}else{
				$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'].'&oldpath='.urlencode($parameters['oldpath']).'&pvtkey='.$parameters['pvtkey'].'&newpath='.urlencode($parameters['newpath']);
			}

			//echo $body;

			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8'));
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($ch,CURLOPT_CAINFO,$this->data['crtpath']);

			$output = curl_exec($ch);
			


			curl_close($ch);
			return $output;
		}
		public function  copyPasteFileFolder($parameters){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->data['weburl'].'/evs/copyPasteFileFolder');

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);

			if($parameters['pvtkey'] == ''){
				$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'].'&p='.urlencode($parameters['p']).'&fileFolderPaths='.urlencode($parameters['fileFolderPaths']);
			}else{
				$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'].'&p='.urlencode($parameters['p']).'&pvtkey='.$parameters['pvtkey'].'&fileFolderPaths='.urlencode($parameters['fileFolderPaths']);
			}

			//echo $body;

			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8'));
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($ch,CURLOPT_CAINFO,$this->data['crtpath']);

			$output = curl_exec($ch);
			


			curl_close($ch);
			return $output;
		}
		public function  putBackFromTrash($parameters){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->data['weburl'].'/evs/putBackFromTrash');

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);

			if($parameters['pvtkey'] == ''){
				$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'].'&p='.urlencode($parameters['p']);
			}else{
				$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'].'&p='.urlencode($parameters['p']).'&pvtkey='.$parameters['pvtkey'];
			}

			//echo $body;

			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8'));
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($ch,CURLOPT_CAINFO,$this->data['crtpath']);

			$output = curl_exec($ch);
			


			curl_close($ch);
			return $output;
		}
		public function  emptyTrash($parameters){
			//generates ERROR - INVALID PATH which is undocumented in the API docs
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->data['weburl'].'/evs/emptyTrash');

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);

			if($parameters['pvtkey'] == ''){
				$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'];
			}else{
				$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'].'&pvtkey='.$parameters['pvtkey'];
			}

			//echo $body;

			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8'));
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($ch,CURLOPT_CAINFO,$this->data['crtpath']);

			$output = curl_exec($ch);
			


			curl_close($ch);
			return $output;
		}
		public function  deleteFile($parameters){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->data['weburl'].'/evs/deleteFile');

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			if($parameters['pvtkey'] == ''){
				$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'].'&p='.urlencode($parameters['p']).'&trash='.$parameters['trash'];
			}else{
				$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'].'&p='.urlencode($parameters['p']).'&trash='.$parameters['trash'].'&pvtkey='.$parameters['pvtkey'];
			}

			//echo $body;

			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8'));
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($ch,CURLOPT_CAINFO,$this->data['crtpath']);

			$output = curl_exec($ch);
			


			curl_close($ch);	
			return $output;
		}
		public function  browseFolder($parameters){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->data['weburl'].'/evs/browseFolder');

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);

			$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'].'&p='.$parameters['p'];

			//echo $body;

			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8'));
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($ch,CURLOPT_CAINFO,$this->data['crtpath']);

			$output = curl_exec($ch);
			


			curl_close($ch);
			return $output;
		}
		public function  getEvents($parameters){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->data['weburl'].'/evs/getEvents');

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);

			$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'].'&month='.$parameters['month'].'&year='.$parameters['year'];

			//echo $body;

			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8'));
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($ch,CURLOPT_CAINFO,$this->data['crtpath']);

			$output = curl_exec($ch);
			


			curl_close($ch);
			return $output;
		}
		public function  downloadEvent($parameters){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->data['weburl'].'/evs/downloadEvent');

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);

			$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'].'&month='.$parameters['month'].'&year='.$parameters['year'].'&eventid='.$parameters['eventid'];

			//echo $body;

			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8'));
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($ch,CURLOPT_CAINFO,$this->data['crtpath']);

			$output = curl_exec($ch);
			


			curl_close($ch);
			return $output;
		}
		public function  getAccountQuota(){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->data['weburl'].'/evs/getAccountQuota');

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);

			$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'];

			//echo $body;

			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8'));
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($ch,CURLOPT_CAINFO,$this->data['crtpath']);

			$output = curl_exec($ch);
			


			curl_close($ch);
			return $output;
		}		
		public function getFolderDetails($parameters){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->data['weburl'].'/evs/getFolderDetails');

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);

			$body = 'uid=' . $this->data['uid']. '&pwd=' . $this->data['pwd'].'&p='.urlencode($parameters['p']);

			//echo $body;

			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8'));
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($ch,CURLOPT_CAINFO,$this->data['crtpath']);

			$output = curl_exec($ch);
			

			curl_close($ch);
			return $output;
		}
		
	}
?>
