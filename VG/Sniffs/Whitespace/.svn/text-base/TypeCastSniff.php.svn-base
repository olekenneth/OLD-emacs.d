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
 * Type cast sniff
 *
 * This sniff makes sure there is a single whitespace between the typecast and the variable. The
 * sniff also makes sure that there is no space inside the parenthesis.
 *
 * <code>
 * // Correct
 * $var = (int) $otherVar;
 *
 * // Incorrect
 * $var = (int)$otherVar;
 * $var = ( int ) $otherVar;
 * </code>
 *
 * @category VG
 * @package CodingStandard
 */
class VG_Sniffs_Whitespace_TypeCastSniff implements PHP_CodeSniffer_Sniff {
    /**
     * Which tokens this sniff should look for
     *
     * @return array
     */
    public function register() {
        return PHP_CodeSniffer_Tokens::$castTokens;
    }

    /**
     * Process the sniff
     *
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int $stackPtr
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
        $tokens = $phpcsFile->getTokens();
        $cast   = $tokens[$stackPtr];

        if (strlen(trim($cast['content'], '() ')) !== (strlen($cast['content']) - 2)) {
            $phpcsFile->addError('Do not use spaces inside the type cast keyword', $stackPtr);
        }

        if ($tokens[$stackPtr + 1]['content'] !== ' ') {
            $phpcsFile->addError('A single whitespace character must be placed after the type cast keyword', $stackPtr);
        }
    }
}