<?php
namespace RealEstate\Core\Support\Letter;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
interface EmailerInterface
{
	public function send(Email $email);
}