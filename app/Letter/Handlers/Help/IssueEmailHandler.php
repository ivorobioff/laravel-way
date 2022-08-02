<?php
namespace RealEstate\Letter\Handlers\Help;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class IssueEmailHandler extends HelpEmailHandler
{
	/**
	 * @return string
	 */
	protected function getSubject()
	{
		return 'RealEstate - Issue Reported';
	}
}