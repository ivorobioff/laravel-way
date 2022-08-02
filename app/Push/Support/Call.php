<?php
namespace RealEstate\Push\Support;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Call
{
	/**
	 * @var string
	 */
	private $url;

	/**
	 * @var string
	 */
	private $secret1;

	/**
	 * @var string
	 */
	private $secret2;

	/**
	 * @param string $url
	 */
	public function setUrl($url)
	{
		$this->url = $url;
	}

	/**
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * @param string $secret
	 */
	public function setSecret1($secret)
	{
		$this->secret1 = $secret;
	}

	/**
	 * @return string
	 */
	public function getSecret1()
	{
		return $this->secret1;
	}

	/**
	 * @param string $secret
	 */
	public function setSecret2($secret)
	{
		$this->secret2 = $secret;
	}

	/**
	 * @return string
	 */
	public function getSecret2()
	{
		return $this->secret2;
	}
}