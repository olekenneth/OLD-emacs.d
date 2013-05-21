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
 * Semi colon sniff
 *
 * Make sure there is no whitespace in front of a semi colon
 *
 * <code>
 * // Correct
 * $var = 1 + 1;
 *
 * // Incorrect
 * $var = 1 + 1 ;
 * </code>
 *
 * @category VG
 * @package CodingStandard
 */
class VG_Sniffs_Whitespace_SemiColonSniff implements PHP_CodeSniffer_Sniff {
    /**
     * Which tokens this sniff should look for
     *
     * @return array
     */
    public function register() {
        return array(T_SEMICOLON);
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

        if ($tokens[$stackPtr - 1]['code'] === T_WHITESPACE) {
            $phpcsFile->addError('Do not put whitespace in front of the semi colon token', $stackPtr);
        }
    }
}