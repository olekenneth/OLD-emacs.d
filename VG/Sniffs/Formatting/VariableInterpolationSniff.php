<?php
/**
 * VG Coding Standard
 *
 * @category VG
 * @package CodingStandard
 * @version $Id: VariableInterpolationSniff.php 2390 2011-02-03 14:03:43Z christere $
 * @author Christer Edvartsen <ce@vg.no>
 */

/**
 * Variable interpolation sniff
 *
 * This sniff will throw warnings when it finds strings with variables inside
 *
 * <code>
 * // Correct
 * $string = "Hello " . $name;
 *
 * // Incorrect
 * $string = "Hello $name";
 * </code>
 *
 * @category VG
 * @package CodingStandard
 */
class VG_Sniffs_Formatting_VariableInterpolationSniff implements PHP_CodeSniffer_Sniff {
    /**
     * Which tokens this sniff should look for
     *
     * @return array
     */
    public function register() {
        return array(T_DOUBLE_QUOTED_STRING);
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

        // See if the content includes some dollar signs that is not escaped (using negative look-behind)
        if (preg_match('/(?!\\\)\$/', $tokens[$stackPtr]['content'])) {
            $phpcsFile->addError('Do not use variable interpolation. Use the string concatenation operator instead', $stackPtr);
        }
    }
}