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
 * Try/catch sniff
 *
 * This sniff enforces a correctly formatted try/catch block.
 *
 * try {
 *     // ...
 * } catch () {
 *     // ...
 * }
 *
 * @category VG
 * @package CodingStandard
 */
class VG_Sniffs_Formatting_TryCatchSniff implements PHP_CodeSniffer_Sniff {
    /**
     * Which tokens this sniff should look for
     *
     * @return array
     */
    public function register() {
        return array(T_TRY, T_CATCH);
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
        $current = $tokens[$stackPtr];

        // Make sure that the opening brachet is on the same line as the try/catch keyword
        if ($current['line'] !== $tokens[$current['scope_opener']]['line']) {
            $phpcsFile->addError('Opening curly bracket must be on the same line as the ' . $current['content'] . ' keyword', $stackPtr);
        }

        // Make sure there is a space preceding the opening bracket
        if ($tokens[$current['scope_opener'] - 1]['content'] !== ' ') {
            $phpcsFile->addError('Make sure to only have a single whitespace preceding the opening curly bracket of the try keyword', $current['scope_opener']);
        }

        // Some rules that only applies to catch
        if ($current['code'] === T_CATCH) {
            // Ensure line number of the parenthesis
            if ($tokens[$current['parenthesis_opener']]['line'] !== $current['line'] ||
                $tokens[$current['parenthesis_closer']]['line'] !== $current['line']) {
                $phpcsFile->addError('Opening and closing parenthesis must be on the same line as the catch keyword', $stackPtr);
            }

            // Ensure whitespace
            if ($tokens[$stackPtr - 1]['content'] !== ' ' || $tokens[$stackPtr + 1]['content'] !== ' ') {
                $phpcsFile->addError('A single whitespace must be prepended and appended to the catch keyword', $stackPtr);
            }

            if ($tokens[$current['parenthesis_opener'] + 1]['code'] === T_WHITESPACE ||
                $tokens[$current['parenthesis_closer'] - 1]['code'] === T_WHITESPACE) {
                $phpcsFile->addError('Remove whitespace appended to the opening parenthesis or prepended to the closing parenthesis of the catch block', $current['parenthesis_opener']);
            }
        }
    }
}
