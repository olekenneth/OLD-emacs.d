<?php
/**
 * VG Coding Standard
 *
 * @category VG
 * @package CodingStandard
 * @version $Id: ControlStructuresSniff.php 2390 2011-02-03 14:03:43Z christere $
 * @author Christer Edvartsen <ce@vg.no>
 */

/**
 * Bitch and moan about unnescessary whitespace
 *
 * @category VG
 * @package CodingStandard
 */
class VG_Sniffs_Whitespace_UnnecessaryWhitespaceSniff implements PHP_CodeSniffer_Sniff {
    /**
     * Which tokens this sniff should look for
     *
     * @return array
     */
    public function register() {
        return array(
            T_CLASS,
            T_FUNCTION,
            T_OPEN_TAG,
            T_CLOSE_CURLY_BRACKET,
        );
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
        $line = $tokens[$stackPtr]['line'];
        $code = $tokens[$stackPtr]['code'];
        $num = count($tokens);
        $bracket = ($code === T_CLOSE_CURLY_BRACKET);

        // Don't allow empty newlines after <?php
        if ($code === T_OPEN_TAG) {
            $nextLine = $tokens[$stackPtr + 1];

            if ($nextLine['code'] === T_WHITESPACE) {
                $phpcsFile->addError('Remove empty line after <?php', $stackPtr + 1);
            }

            return;
        }

        if (($code === T_FUNCTION || $code === T_CLASS) && isset($tokens[$stackPtr]['scope_opener'])) {
            $scopeStart = $tokens[$stackPtr]['scope_opener'] + 1;
            $scopeEnd = $tokens[$stackPtr]['scope_closer'];
            $body = trim($phpcsFile->getTokensAsString($scopeStart, $scopeEnd - $scopeStart));

            if (empty($body)) {
                // Empty class or function
                return;
            }
        }

        if ($code === T_FUNCTION) {
            // If we have an abstract method or a method definition in an interface, exit.
            $properties = $phpcsFile->getMethodProperties($stackPtr);

            if ($properties['is_abstract'] || !isset($tokens[$stackPtr]['scope_opener'])) {
                return;
            }
        }

        if ($bracket) {
            $foundEnd = false;

            for ($i = $stackPtr; $i; $i--) {
                if (!$foundEnd && ($tokens[$i]['line'] === ($line - 1))) {
                    $end = $i;
                    $foundEnd = true;
                }

                if ($tokens[$i]['line'] === ($line - 2)) {
                    $start = $i;
                    break;
                }
            }
        } else {
            $foundStart = false;

            for ($i = $stackPtr; $i < $num; $i++) {
                if (!$foundStart && ($tokens[$i]['line'] === ($line + 1))) {
                    $start = $i;
                    $foundStart = true;
                }

                if ($tokens[$i]['line'] === ($line + 2)) {
                    $end = $i;
                    break;
                }
            }
        }

        $content = trim($phpcsFile->getTokensAsString($start, ($end - $start) + 1));

        if (empty($content)) {
            $phpcsFile->addError('Remove empty line', $bracket ? $end : $start);
        }
    }
}
