<?php

/*
 * This file is part of the Liquid package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package Liquid
 */

namespace Liquid;

use Liquid\Tag\TagInclude;
use Liquid\Tag\TagExtends;

/**
 * This class represents the entire template document.
 */
class Document extends AbstractBlock
{
	/**
	 * Constructor.
	 *
	 * @param array $tokens
	 * @param FileSystem $fileSystem
	 */
	public function __construct(array &$tokens, FileSystem $fileSystem = null)
	{
		$this->fileSystem = $fileSystem;
		$this->parse($tokens);
	}

	/**
	 * Check for cached includes; if there are - do not use cache
	 *
	 * @see \Liquid\Tag\TagInclude::hasIncludes()
	 * @see \Liquid\Tag\TagExtends::hasIncludes()
	 * @return string
	 */
	public function hasIncludes()
	{
		foreach ($this->nodelist as $token) {
			// check any of the tokens for includes
			if ($token instanceof TagInclude && $token->hasIncludes()) {
				return true;
			}

			if ($token instanceof TagExtends && $token->hasIncludes()) {
				return true;
			}
		}

		return false;
	}

	/**
	 * There isn't a real delimiter
	 *
	 * @return string
	 */
	protected function blockDelimiter()
	{
		return '';
	}

	/**
	 * Document blocks don't need to be terminated since they are not actually opened
	 */
	protected function assertMissingDelimitation()
	{
	}
}
