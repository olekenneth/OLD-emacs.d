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
 * Double colon sniff
 *
 * This sniff will look for :: and make sure there are no spaces on either side of it
 *
 * <code>
 * // Correct
 * Class::method();
 * self::$var;
 *
 * // Incorrect
 * Class :: method();
 * self :: $var;
 * </code>
 *
 * @category VG
 * @package CodingStandard
 */
class VG_Sniffs_Whitespace_DoubleColonSniff implements PHP_CodeSniffer_Sniff {
    /**
     * Which tokens this sniff should look for
     *
     * @return array
     */
    public function register() {
        return array(T_DOUBLE_COLON);
    }

    /**
     * Process the sniff
     *
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int $stackPtr
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
        $tokens = $phpcsFile->getTokens();

        if ($tokens[$stackPtr - 1]['type'] === T_WHITESPACE || $tokens[$stackPtr + 1]['type'] === T_WHITESPACE) {
            $phpcsFile->addError('Do not put whitespace in front of or after the double colon (::)', $stackPtr);
        }
    }
}