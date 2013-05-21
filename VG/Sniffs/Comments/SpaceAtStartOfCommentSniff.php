<?php
/**
 * VG Coding Standard
 *
 * @category VG
 * @package CodingStandard
 * @version $Id: SpaceAtStartOfCommentSniff.php 2390 2011-02-03 14:03:43Z christere $
 * @author Christer Edvartsen <ce@vg.no>
 */

/**
 * Space at start of comment sniff
 *
 * This sniff makes sure we have a space in the start of all one line comments for better
 * readability.
 *
 * @category VG
 * @package CodingStandard
 */
class VG_Sniffs_Comments_SpaceAtStartOfCommentSniff implements PHP_CodeSniffer_Sniff {
    /**
     * Which tokens this sniff should look for
     *
     * @return array
     */
    public function register() {
        return array(T_COMMENT);
    }

    /**
     * Process the sniff
     *
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int $stackPtr
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
        // Fetch all tokens
        $tokens = $phpcsFile->getTokens();

        if (substr($tokens[$stackPtr]['content'], 0, 2) === '//' &&
            $tokens[$stackPtr]['content'][2] !== ' ') {
            $phpcsFile->addError('All one line comments must start with a single whitespace character for improved readability.', $stackPtr);
            return;
        }
    }
}