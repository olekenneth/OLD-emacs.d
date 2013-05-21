<?php
/**
 * VG Coding Standard
 *
 * @category VG
 * @package CodingStandard
 * @version $Id: ImplementsListInClassDefinitionSniff.php 2390 2011-02-03 14:03:43Z christere $
 * @author Christer Edvartsen <ce@vg.no>
 */

/**
 * Sniff that checks the list of interfaces that a class implements
 *
 * This sniff checks that each comma is followed by a single whitespace in the list of interfaces
 * that a class may implement.
 *
 * @category VG
 * @package CodingStandard
 */
class VG_Sniffs_Classes_ImplementsListInClassDefinitionSniff implements PHP_CodeSniffer_Sniff {
    /**
     * Which tokens this sniff should look for
     *
     * @return array
     */
    public function register() {
        return array(T_IMPLEMENTS);
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

        // Fetch the opening brace of the class
        $openingBrace = (int) $phpcsFile->findNext(T_OPEN_CURLY_BRACKET, $stackPtr);

        // Loop through all tokens from the implements keyword and the opening brace
        for ($i = $stackPtr + 1; $i < $openingBrace; $i++) {
            // When we find a comma, make sure it is followed by a single space, and then a string
            if ($tokens[$i]['code'] === T_COMMA) {
                if ($tokens[$i + 1]['content'] !== ' ' || $tokens[$i + 2]['code'] !== T_STRING) {
                    $phpcsFile->addError('A single space must be placed after every comma in the list of interfaces a class implements', $stackPtr);

                    return;
                }

                $i++;
            }
        }
    }
}