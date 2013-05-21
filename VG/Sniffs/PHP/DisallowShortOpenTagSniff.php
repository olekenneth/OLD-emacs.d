<?php
/**
 * VG Coding Standard
 *
 * @category VG
 * @package CodingStandard
 * @version $Id: DisallowShortOpenTagSniff.php 2390 2011-02-03 14:03:43Z christere $
 * @author Christer Edvartsen <ce@vg.no>
 */

/**
 * Disallow short open tag
 *
 * This sniff finds occurences of "<?" and throws an error about it. It does not complain about
 * "<?=".
 *
 * @category VG
 * @package CodingStandard
 */
class VG_Sniffs_PHP_DisallowShortOpenTagSniff extends Generic_Sniffs_PHP_DisallowShortOpenTagSniff {
    /**
     * Which tokens this sniff should look for
     *
     * @return array
     */
    public function register() {
        return array(T_OPEN_TAG);
    }
}