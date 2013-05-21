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
 * Lowercase tokens
 *
 * @category VG
 * @package CodingStandard
 */
class VG_Sniffs_PHP_LowerCaseConstantSniff implements PHP_CodeSniffer_Sniff {
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register() {
        return array(T_AS);
    }

    /**
     * Processes this sniff, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token in the
     *                                        stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
        $tokens = $phpcsFile->getTokens();
        $content = $tokens[$stackPtr]['content'];

        if (strtolower($content) !== $content) {
            $phpcsFile->addError(sprintf('Lowercase the token. Expected "%s", got "%s"', strtolower($content), $content), $stackPtr);
        }
    }
}
