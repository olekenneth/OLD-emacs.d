<?php
/**
 * VG Coding Standard
 *
 * @category VG
 * @package CodingStandard
 * @version $Id: DisallowVarSniff.php 2390 2011-02-03 14:03:43Z christere $
 * @author Christer Edvartsen <ce@vg.no>
 */

/**
 * Disallow var sniff
 *
 * This sniff makes sure that no class attributes has the var keyword. Use public instead.
 *
 * @category VG
 * @package CodingStandard
 */
class VG_Sniffs_Classes_DisallowVarSniff implements PHP_CodeSniffer_Sniff {
    /**
     * Which tokens this sniff should look for
     *
     * @return array
     */
    public function register() {
        return array(T_VAR);
    }

    /**
     * Process the sniff
     *
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int $stackPtr
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
        $phpcsFile->addError('Do not use the var keyword. Use public instead', $stackPtr);
    }
}