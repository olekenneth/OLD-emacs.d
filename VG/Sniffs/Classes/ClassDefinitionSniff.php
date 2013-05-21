<?php
/**
 * VG Coding Standard
 *
 * @category VG
 * @package CodingStandard
 * @version $Id$
 * @author Christer Edvartsen <ce@vg.no>
 */

/**
 * Sniff that covers class definitions
 *
 * @category VG
 * @package CodingStandard
 */
class VG_Sniffs_Classes_ClassDefinitionSniff implements PHP_CodeSniffer_Sniff {
    /**
     * Which tokens this sniff should look for
     *
     * @return array
     */
    public function register() {
        return array(T_CLASS);
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

        // Make sure we have a single whitespace following the class keyword
        if ($tokens[$stackPtr + 1]['content'] !== ' ') {
            $phpcsFile->addError('Use a single whitespace after the class keyword', $stackPtr);
        }

        // Make sure the scope opener is on the same line
        if ($tokens[$stackPtr]['line'] !== $tokens[$tokens[$stackPtr]['scope_opener']]['line']) {
            $phpcsFile->addError('The opening curly bracket must be on the same line as the class keyword', $stackPtr);
        }

        // Make sure the scope opener has a single whitespace in front of it
        if ($tokens[$tokens[$stackPtr]['scope_opener'] - 1]['content'] !== ' ') {
            $phpcsFile->addError('The opening curly bracket must be preceded by a single whitespace', $stackPtr);
        }
    }
}
