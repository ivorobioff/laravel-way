<?php
namespace RealEstate\Letter\Handlers\Help;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class RequestFeatureEmailHandler extends HelpEmailHandler
{
	/**
	 * @return string
	 */
	protected function getSubject()
	{
		return ' RealEstate - Feature Requested';
	}
}