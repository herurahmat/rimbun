<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Updater
{
	private $repo_name='rimbun';
	private $user_name='herurahmat';
	
	
	private function get_repo_tag()
	{
		$url="https://api.github.com/repos/".$this->user_name."/".$this->repo_name."/tags";
		return $url;
	}
	
	function get_repo_download($version)
	{
		$url="https://github.com/".$this->user_name."/".$this->repo_name."/archive/".$version.".zip";
		return $url;
	}
	
	function is_update()
	{
		$new_version=$this->current_tag();
		$system_version=$this->system_version();
		if(version_compare($new_version,$system_version,'>'))
		{
			return true;
		}else{
			return false;
		}
	}
	
	function system_version()
	{
		$rimbunInfo=rimbun_info();
		$version=$rimbunInfo['version'];
		return $version;
	}
	
	function current_tag()
	{
		$version='';
		$tagURL=$this->get_tag();
		$tagDecode=json_decode($tagURL,TRUE);
		if(!empty($tagDecode))
		{
			foreach($tagDecode as $r){
				$version=$r['name'];
				break;
			}			
		}
		return $version;
	}
	
	function get_tag()
	{
		$curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->get_repo_tag());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Awesome-Octocat-App');
        $request = curl_exec($curl);
        $return = ($request === FALSE) ? curl_error($curl) : $request;
        curl_close($curl);
        return $return;
	}
}