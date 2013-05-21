<?php
/**
 * VG Coding Standard
 *
 * @category VG
 * @package CodingStandard
 * @version $Id: ForLoopSniff.php 2390 2011-02-03 14:03:43Z christere $
 * @author Christer Edvartsen <ce@vg.no>
 */

/**
 * Make sure there is correct spacing in a for loop
 *
 * <code>
 * // Corrent
 * for ($i = 0; $i < 10; $i++) {
 *
 * }
 *
 * // Incorrect
 * for ($i = 0;$i < 10;$i++) {
 *
 * }
 * </code>
 *
 * @category VG
 * @package CodingStandard
 */
class VG_Sniffs_Whitespace_ForLoopSniff implements PHP_CodeSniffer_Sniff {
    /**
     * Which tokens this sniff should look for
     *
     * @return array
     */
    public function register() {
        return array(T_FOR);
    }

    /**
     * Process the sniff
     *
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int $stackPtr
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
        $tokens = $phpcsFile->getTokens();

        $pOpener = $tokens[$stackPtr]['parenthesis_opener'];
        $pCloser = $tokens[$stackPtr]['parenthesis_closer'];

        for ($i = $pOpener + 1; $i < $pCloser; $i++) {
            $next = $phpcsFile->findNext(T_SEMICOLON, $i, $pCloser);

            if ($next !== false && ($tokens[$next + 1]['content'] !== ' ')) {
                $error = 'A single space must be placed after each semicolon i the for loop';
                $phpcsFile->addError($error, $stackPtr);

                return;
            }
        }
    }
}