<?php
include_once('iDrive.php');

$username = "[your IDrive user name]";
$userpwd = "[your IDrive password]";
$localcertpath = "[path to a local cert to make ssl call with curl]";

$IDObject = new iDrive($username,$userpwd,$localcertpath);

echo "getServerAddress<br />";
$ServerInfo21 = new SimpleXMLElement($IDObject->getServerAddress());
echo $ServerInfo21['message'];

echo "<br /><br />";

echo "configureAccount<br />";
$parameters = array('enctype'=>'private', 'pvtkey'=>'delraydavis');
$ServerInfo19 = new SimpleXMLElement($IDObject->configureAccount($parameters));
echo $ServerInfo19['message']." - ".$ServerInfo19['desc'];

echo "<br /><br />";

echo "getProperties1<br />";
$parameters = array('p'=>'/OWNER-PC/C');
$ServerInfo11 = new SimpleXMLElement($IDObject->execute('getProperties',$parameters));
echo $ServerInfo11['message'].' - '.$ServerInfo11['path'].' - '.$ServerInfo11['size'].' - '.$ServerInfo11['lmd'].' - '.$ServerInfo11['filecount'].'<br />';

echo "<br /><br />";

echo "validatePvtKey<br />";
$parameters = array('pvtkey'=>'delraydavis');
$ServerInfo20 = new SimpleXMLElement($IDObject->validatePvtKey($parameters));
echo $ServerInfo20['message']." - ".$ServerInfo20['desc'];

echo "<br /><br />";

echo "getProperties<br />";
$parameters = array('p'=>'/OWNER-PC/C');
$ServerInfo11 = new SimpleXMLElement($IDObject->getProperties($parameters));
echo $ServerInfo11['message'].' - '.$ServerInfo11['path'].' - '.$ServerInfo11['size'].' - '.$ServerInfo11['lmd'].' - '.$ServerInfo11['filecount'].'<br />';

echo "<br /><br />";

echo "getAccountQuota<br />";
$ServerInfo2 = new SimpleXMLElement($IDObject->getAccountQuota($parameters));
echo $ServerInfo2['message']." - ".$ServerInfo2['totalquota']." - ".$ServerInfo2['usedquota']." - ".$ServerInfo2['filecount'];

echo "<br /><br />";

echo "getEvents<br />";
$parameters = array('month'=>'1','year'=>'2011');
$ServerInfo3 = new SimpleXMLElement($IDObject->getEvents($parameters));
echo $ServerInfo3['message']." - ".$ServerInfo3['eventcount'];

echo "<br /><br />";

echo "browseFolder<br />";
$parameters = array('p'=>'/OWNER-PC/C');
$ServerInfo4 = new SimpleXMLElement($IDObject->browseFolder($parameters));
echo $ServerInfo4['message']." - ".$ServerInfo4['path'].'<br />';
foreach($ServerInfo4->children() as $c){
	echo $c['resname']." - ".$c['size']." - ".$c['lmd']."<br />";
}

echo "<br /><br />";

echo "deleteFile<br />";
$parameters = array('p'=>'/OWNER-PC/C/Chrysanthemum.jpg','trash'=>'no','pvtkey'=>'');
$ServerInfo5 = new SimpleXMLElement($IDObject->deleteFile($parameters));
echo $ServerInfo5['message']." - ";
foreach($ServerInfo5->children() as $c){
	echo $c['result']." - ".$c['path']."<br />";
}

echo "<br /><br />";

echo "putBackFromTrash<br />";
$parameters = array('p'=>'/OWNER-PC/C/Chrysanthemum.jpg','pvtkey'=>'');
$ServerInfo6 = new SimpleXMLElement($IDObject->putBackFromTrash($parameters));
echo $ServerInfo6['message']." - ";
foreach($ServerInfo6->children() as $c){
	echo $c['result']." - ".$c['path']."<br />";
}

echo "<br /><br />";

echo "emptyTrash<br />";
$parameters = array('pvtkey'=>'');
$ServerInfo7 = new SimpleXMLElement($IDObject->emptyTrash($parameters));
echo $ServerInfo7['message']." - ".$ServerInfo7['desc'];

echo "<br /><br />";

echo "copyPasteFileFolder<br />";
$parameters = array('pvtkey'=>'', 'p'=>'/OWNER-PC','fileFolderPaths'=>'/OWNER-PC/C/Chrysanthemum.jpg');
$ServerInfo8 = new SimpleXMLElement($IDObject->copyPasteFileFolder($parameters));
echo $ServerInfo8['message'].'<br />';
foreach($ServerInfo8->children() as $c){
	echo $c['result']." - ".$c['path']."<br />";
}

echo "<br /><br />";

echo "searchFiles<br />";
$parameters = array('p'=>'/OWNER-PC','searchKey'=>'Chrysanthemum.jpg','trash'=>'yes');
$ServerInfo9 = new SimpleXMLElement($IDObject->searchFiles($parameters));
echo $ServerInfo9['message'].' - '.$ServerInfo9['desc'].'<br />';
foreach($ServerInfo9->children() as $c){
	echo $c['respath']." - ".$c['size']."<br />";
}

echo "<br /><br />";

echo "getVersions<br />";
$parameters = array('p'=>'/OWNER-PC/C/delray.txt');
$ServerInfo10 = new SimpleXMLElement($IDObject->getVersions($parameters));
echo $ServerInfo10['message'].' - '.$ServerInfo10['desc'].'<br />';
foreach($ServerInfo10->children() as $c){
	echo $c['lmd']." - ".$c['size']." - ".$c['ver']."<br />";
}

echo "<br /><br />";

echo "getProperties<br />";
$parameters = array('p'=>'/OWNER-PC/C');
$ServerInfo11 = new SimpleXMLElement($IDObject->getProperties($parameters));
echo $ServerInfo11['message'].' - '.$ServerInfo11['path'].' - '.$ServerInfo11['size'].' - '.$ServerInfo11['lmd'].' - '.$ServerInfo11['filecount'].'<br />';

echo "<br /><br />";

echo "isFileFolderExists <br />";
$parameters = array('p'=>'/OWNER-PC/C/delray.txt');
$ServerInfo12 = new SimpleXMLElement($IDObject->isFileFolderExists ($parameters));
echo $ServerInfo12['message'].'<br />';
foreach($ServerInfo12->children() as $c){
	echo $c['result']." - ".$c['path']."<br />";
}

echo "<br /><br />";

echo "createFolder<br />";
$parameters = array('p'=>'/OWNER-PC/C', 'foldername'=>'delrayfolder','pvtkey'=>'');
$ServerInfo22 = new SimpleXMLElement($IDObject->createFolder($parameters));
echo $ServerInfo22['message'].' = '.$ServerInfo22['desc'].'<br />';

echo "<br /><br />";

echo "renameFileFolder<br />";
$parameters = array('oldpath'=>'/OWNER-PC/C/delrayfolder', 'newpath'=>'/OWNER-PC/C/delrayfolder1','pvtkey'=>'');
$ServerInfo23 = new SimpleXMLElement($IDObject->renameFileFolder($parameters));
echo $ServerInfo23['message'].' = '.$ServerInfo23['desc'].'<br />';
?>