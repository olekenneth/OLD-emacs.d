<?php
/**
 * VG Coding Standard
 *
 * @category VG
 * @package CodingStandard
 * @version $Id: ClassInstantiationSniff.php 2390 2011-02-03 14:03:43Z christere $
 * @author Christer Edvartsen <ce@vg.no>
 */

/**
 * Sniff that covers instantiation of new objects
 *
 * This sniff enforces some rules arond the usage of the "new" keyword. The sniff checks that the
 * new keyword is followed by a single whitespace character, and that parenthesis must always be
 * used when making new objects.
 *
 * @category VG
 * @package CodingStandard
 */
class VG_Sniffs_Classes_ClassInstantiationSniff implements PHP_CodeSniffer_Sniff {
    /**
     * Which tokens this sniff should look for
     *
     * @return array
     */
    public function register() {
        return array(T_NEW);
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

        // Only a single whitespace is allowed behind the new keyword
        if ($tokens[$stackPtr + 1]['content'] !== ' ') {
            $phpcsFile->addError('Only a single space is allowed behind the new keyword', $stackPtr);

            return;
        }

        // Error message
        $error = 'A pair of parenthesis are required after the new keyword';

        // Fetch semi colon
        $semiColon = $phpcsFile->findNext(T_SEMICOLON, $stackPtr);

        // Check that we have parenthesis between the new keyword and the semi colon
        $parenthesisOpener = $phpcsFile->findNext(T_OPEN_PARENTHESIS, $stackPtr, $semiColon);

        if (!$parenthesisOpener) {
            $phpcsFile->addError($error, $stackPtr);

            return;
        }

        // Check that we have a closing parenthesis between the opening one and the semi colon
        $parenthesisCloser = $phpcsFile->findNext(T_CLOSE_PARENTHESIS, $parenthesisOpener, $semiColon);

        if (!$parenthesisCloser) {
            $phpcsFile->addError($error, $stackPtr);

            return;
        }
    }
}