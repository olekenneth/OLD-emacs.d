<?php
/**
 * VG Coding Standard
 *
 * @category VG
 * @package CodingStandard
 * @version $Id: ControlStructuresSniff.php 2390 2011-02-03 14:03:43Z christere $
 * @author Christer Edvartsen <ce@vg.no>
 */

/**
 * Don't allow any whitespace in "empty" bodies
 *
 * @category VG
 * @package CodingStandard
 */
class VG_Sniffs_Whitespace_EmptyBodySniff implements PHP_CodeSniffer_Sniff {
    /**
     * Which tokens this sniff should look for
     *
     * @return array
     */
    public function register() {
        return array(
            T_OPEN_CURLY_BRACKET,
        );
    }

    /**
     * Process the sniff
     *
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int $stackPtr
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
        $tokens = $phpcsFile->getTokens();
        $start = @$tokens[$stackPtr]['scope_opener'];
        $end = @$tokens[$stackPtr]['scope_closer'];
        $content = $phpcsFile->getTokensAsString($stackPtr + 1, ($end - $start) - 1);
        $trimmedContent = trim($content);

        if (empty($trimmedContent) && !empty($content)) {
            $phpcsFile->addError('Empty body is not empty. Remove all whitespace', $stackPtr);
        }
    }
}
