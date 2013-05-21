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
 * Arithmetic and concat operators sniff
 *
 * This sniff makes sure that the all arithmetic tokens and the concat token has a single
 * whitespace char before and after for better readability.
 *
 * <code>
 * // Correct
 * $string = 'foo' . $bar;
 * $var = 1 + 1;
 *
 * // Incorrect
 * $string = 'foo'.$bar;
 * $var = 1+1;
 * </code>
 *
 * @category VG
 * @package CodingStandard
 */
class VG_Sniffs_Whitespace_ArithmeticAndConcatOperatorsSniff implements PHP_CodeSniffer_Sniff {
    /**
     * Which tokens this sniff should look for
     *
     * @return array
     */
    public function register() {
        $tokens   = PHP_CodeSniffer_Tokens::$arithmeticTokens;
        $tokens[] = T_STRING_CONCAT;

        return $tokens;
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

        // Do we have a minus sign (that can be used to make numbers negative)?
        if ($tokens[$stackPtr]['code'] === T_MINUS) {
            // Find previous token that is not a whitespace
            $prevNonWhitespace = $phpcsFile->findPrevious(array(T_WHITESPACE), $stackPtr - 1, null, true);

            // If we have an equal sign or a comma, let this one pass
            $legalTokens = array(T_EQUAL, T_COMMA, T_LESS_THAN, T_GREATER_THAN, T_DOUBLE_ARROW);

            if (array_search($tokens[$prevNonWhitespace]['code'], $legalTokens) !== false) {
                return;
            }
        }

        if (
            $tokens[$stackPtr - 1]['content'] !== ' ' ||
            ($tokens[$stackPtr + 1]['content'] !== ' ' && $tokens[$stackPtr + 1]['content'] !== $phpcsFile->eolChar)
        ) {
            $phpcsFile->addError('All arithmetic tokens and the concat operator must have a single whitespace token immediately before and after.', $stackPtr);
        }
    }
}
