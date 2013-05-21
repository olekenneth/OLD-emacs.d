<?php
/**
 * VG Coding Standard
 *
 * @category VG
 * @package CodingStandard
 * @version $Id: DisallowAssignmentsInIfSniff.php 2390 2011-02-03 14:03:43Z christere $
 * @author Christer Edvartsen <ce@vg.no>
 */

/**
 * Don't allow assignments in [else ]if
 *
 * <code>
 * // Correct
 * $foo = $obj->getTitle();
 *
 * if ($foo !== false) {
 *     // Do something
 * }
 *
 * // Incorrect
 * if (($foo = $obj->getTitle()) !== false) {
 *     // Do something
 * }
 * </code>
 *
 * @category VG
 * @package CodingStandard
 */
class VG_Sniffs_ControlStructures_DisallowAssignmentsInIfSniff implements PHP_CodeSniffer_Sniff {
    /**
     * Which tokens this sniff should look for
     *
     * @return array
     */
    public function register() {
        return array(
            T_IF,
            T_ELSEIF
        );
    }

    /**
     * Process the sniff
     *
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int $stackPtr
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
        $tokens = $phpcsFile->getTokens();

        $opener = $tokens[$stackPtr]['parenthesis_opener'];
        $closer = $tokens[$stackPtr]['parenthesis_closer'];

        for ($i = $opener; $i < $closer; $i++) {
            if ($tokens[$i]['code'] === T_EQUAL) {
                $error  = 'Assignments in [else ]if is not allowed';
                $phpcsFile->addError($error, $i);

                return;
            }
        }
    }
}