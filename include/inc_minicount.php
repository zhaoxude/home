<?php
/******************************************************
//�������;������ʵ�ּ򵥵���վ����ͳ��
//����޸����� 2008-11-11 By dedecms �û� ����
******************************************************/
class minicount
{
	var $dataPth;

	function __construct($dataPth = "minidata/")
	{
		$this->dataPath = $dataPth;
	}

	//���PHP4��֧��__construct����
	function minicount($dataPth = "minidata/")
	{
		$this->dataPath = $dataPth;
	}

	function diplay($format="a%t%y%m%l%"){
		//echo $format;

		$this->updateCount($this->dataPath.$this->getMainFileName());		//����������
		$this->updateCount($this->dataPath.$this->getTodayFileName());		//���½�������
		$this->updateCount($this->dataPath.$this->getMonthFileName());		//���½�������

		$search = array("'a%'i",
			"'t%'i",
			"'y%'i",
			"'m%'i",
			"'l%'i",
		);

		$replace = array($this->getCount($this->dataPath.$this->getMainFileName()),
			$this->getCount($this->dataPath.$this->getTodayFileName()),
			$this->getCount($this->dataPath.$this->getYesterdayFileName()),
			$this->getCount($this->dataPath.$this->getMonthFileName()),
			$this->getCount($this->dataPath.$this->getLastMonthFileName())
		);

		echo preg_replace ($search, $replace, $format);
	}

	function updateCount($f)
	{
		//echo $this->dataPath;
		$handle = fopen($f, "a+") or die("�Ҳ����ļ�");
		$counter = fgets($handle,1024);
		$counter = intval($counter);
		$counter++;
		fclose($handle);

		//д��ͳ��
		$handle = fopen($f, "w") or die("�򲻿��ļ�");
		fputs($handle,$counter) or die("д��ʧ��");
		fclose($handle);
	}

	function getCount($f)
	{
		$handle = fopen($f, "a+") or die("�Ҳ����ļ�");
		$counter = fgets($handle,1024);
		$counter = intval($counter);
		fclose($handle);
		return $counter;
	}

	function getMainFileName()
	{
		return "counter.txt";
	}

	function getYesterdayFileName()
	{
		return "day/".date("Ymd",strtotime('-1 day')).".txt";
	}

	function getTodayFileName()
	{
		return "day/".date("Ymd").".txt";
	}

	function getMonthFileName()
	{
		return "month/".date("Ym").".txt";
	}

	function getLastMonthFileName()
	{
		return "month/".date("Ym",strtotime('-1 month')).".txt";
	}
}
?>