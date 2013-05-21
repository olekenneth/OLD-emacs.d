<?php
/**
 * VG Coding Standard
 *
 * @category VG
 * @package CodingStandard
 * @version $Id: DisallowElseifSniff.php 2390 2011-02-03 14:03:43Z christere $
 * @author Christer Edvartsen <ce@vg.no>
 */

/**
 * Don't use elseif, use else if
 *
 * <code>
 * // Corrent
 * if ($foo) {
 *
 * } else if ($bar) {
 *
 * } else {
 *
 * }
 *
 * // Incorrect
 * if ($foo) {
 *
 * } elseif ($bar) {
 *
 * } else {
 *
 * }
 * </code>
 *
 * @category VG
 * @package CodingStandard
 */
class VG_Sniffs_ControlStructures_DisallowElseifSniff implements PHP_CodeSniffer_Sniff {
    /**
     * Which tokens this sniff should look for
     *
     * @return array
     */
    public function register() {
        return array(T_ELSEIF);
    }

    /**
     * Process the sniff
     *
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int $stackPtr
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
        $tokens = $phpcsFile->getTokens();

        if ($tokens[$stackPtr]['content'] === 'elseif') {
            $error = '"elseif" is not allowed. Use "else if"';
            $phpcsFile->addError($error, $stackPtr);

            return;
        }
    }
}