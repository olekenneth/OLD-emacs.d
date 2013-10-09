<?php
/**
 * VG Coding Standard
 *
 * @category VG
 * @package CodingStandard
 * @version $Id: ControlStructuresSniff.php 3119 2012-06-06 12:02:02Z christere $
 * @author Christer Edvartsen <ce@vg.no>
 */

/**
 * Make sure control structures has correct spacing
 *
 * @category VG
 * @package CodingStandard
 */
class VG_Sniffs_Whitespace_ControlStructuresSniff implements PHP_CodeSniffer_Sniff {
    /**
     * Which tokens this sniff should look for
     *
     * @return array
     */
    public function register() {
        return array(
            T_IF,
            T_ELSE,
            T_SWITCH,
            T_FOR,
            T_FOREACH,
            T_DO,
            T_WHILE,
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

        $stmt = $tokens[$stackPtr];

        // All statements (with the excepton of the else statement) should look like this:
        // <statement> (<expr>) {
        //     <code>
        // }
        if ($stmt['code'] === T_ELSE) {
            // The else token must have a closing brace followed by a single whitespace in front
            // and appended by a single space and a opening brace unless it is a part of an else if
            // statement. Possible values are:
            // } else {
            // } else if
            if ($tokens[$stackPtr - 1]['content'] !== ' ' || $tokens[$stackPtr - 2]['content'] !== '}') {
                $phpcsFile->addError('An else statement must be preceded with a closing brace and a single whitespace', $stackPtr);
            } else if ($tokens[$stackPtr + 1]['content'] !== ' ' || ($tokens[$stackPtr + 2]['content'] !== '{' && $tokens[$stackPtr + 2]['code'] !== T_IF)) {
                $phpcsFile->addError('An else statement must be followed by a single space and an opening brace or an if-statement', $stackPtr);
            }
        } else {
        	if ($tokens[$stackPtr + 1]['content'] !== ' ') {
                // Make sure there is always an empty space after the token
                $phpcsFile->addError('Missing single empty space after the ' . $stmt['content'] . ' statement', $stackPtr);
            } else if (
                isset($stmt['parenthesis_opener']) &&
                ($stmt['parenthesis_opener'] !== ($stackPtr + 2) ||
                $tokens[$stmt['parenthesis_opener']]['line'] !== $stmt['line'])
            ) {
                // The next token should be an opening parenthesis and be on the same line as the
                // statement
                $phpcsFile->addError('The opening parenthesis should be placed directly after the whitespace following the ' . $stmt['content'] . ' statement. It must also be on the same line as the ' . $stmt['content'] . ' statement', $stackPtr);
            } else if ($tokens[$stackPtr + 3]['code'] === T_WHITESPACE && $tokens[$stackPtr + 3]['content'] !== $phpcsFile->eolChar) {
                // After the opening parenthesis there should not be a whitespace character unless
                // the character is a newline
                $phpcsFile->addError('Whitespace after the opening parenthesis is not allowed unless it is a newline character', $stackPtr);
            } else if (isset($stmt['parenthesis_closer']) && $tokens[$stmt['parenthesis_closer'] + 1]['content'] !== ' ') {
                // Make sure the closing parenthesis is followed by a single whitespace character
                $phpcsFile->addError('The opening brace should be followed by a single whitespace character', $stackPtr);
            } else if (
                isset($stmt['scope_opener']) && isset($stmt['parenthesis_closer']) &&
                (($stmt['parenthesis_closer'] + 2) !== $stmt['scope_opener'] ||
                $tokens[$stmt['parenthesis_closer']]['line'] !== $tokens[$stmt['scope_opener']]['line'])
            ) {
                // Make sure there is only a single token between the parenthesis closer and the
                // opening brace and that they are on the same line
                $phpcsFile->addError('The closing parenthesis should be followed by a single space character and then the opening brace. The closing parenthesis and the opening brace must be placed on the same line', $stackPtr);
            }
        }
    }
}