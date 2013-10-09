<?php
/**
 * VG Coding Standard
 *
 * @category VG
 * @package CodingStandard
 * @version $Id: DisallowTabSniff.php 2390 2011-02-03 14:03:43Z christere $
 * @author Christer Edvartsen <ce@vg.no>
 */

/**
 * Disallow tab sniff
 *
 * This sniff makes sure that the tab character does not exist in the code base
 *
 * @category VG
 * @package CodingStandard
 */
class VG_Sniffs_Whitespace_DisallowTabSniff implements PHP_CodeSniffer_Sniff {
    /**
     * Which tokens this sniff should look for
     *
     * @return array
     */
    public function register() {
        return array(T_WHITESPACE);
    }

    /**
     * Process the sniff
     *
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int $stackPtr
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
        $tokens = $phpcsFile->getTokens();

        // If a tab is somewhere in the whitespace, throw an error
        if (strpos($tokens[$stackPtr]['content'], "\t") !== false) {
            $phpcsFile->addError('Tabs are not allowed anywhere in the code', $stackPtr);
        }
    }
}