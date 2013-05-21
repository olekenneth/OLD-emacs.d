<?php
/**
 * VG Coding Standard
 *
 * @category VG
 * @package CodingStandard
 * @version $Id: ClassAttributeCommentSniff.php 2390 2011-02-03 14:03:43Z christere $
 * @author Christer Edvartsen <ce@vg.no>
 */

/**
 * Class attribute comment sniff
 *
 * This sniff checks for valid phpdoc blocks on all class attributes. A valid phpdoc block must
 * contain a @var keyword and a short description.
 *
 * @category VG
 * @package CodingStandard
 */
class VG_Sniffs_Comments_ClassAttributeCommentSniff implements PHP_CodeSniffer_Sniff {
    /**
     * Which tokens this sniff should look for
     *
     * @return array
     */
    public function register() {
        return array(T_CLASS, T_INTERFACE);
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

        // Start looking for variables at this offset (after class/interface keyword)
        $offset = $stackPtr + 1;

        // Loop through all variables found in the current class
        while ($variableStart = $phpcsFile->findNext(T_VARIABLE, $offset)) {
            // Update offset
            $offset = $variableStart + 1;

            // Extract variable
            $variable = $tokens[$variableStart];

            // Only fetch variables on level 1 that is not enclosed in parenthesis (which means
            // variables not inside a function definition)
            if ($variable['level'] !== 1 || isset($variable['nested_parenthesis'])) {
                continue;
            }

            // Now, get the previous phpdoc block relative to the found variable
            $commentEnd = $phpcsFile->findPrevious(T_DOC_COMMENT, $variableStart);

            // Is the block on the line above the variable?
            if ($variable['line'] !== ($tokens[$commentEnd]['line'] + 1)) {
                $phpcsFile->addError('Each class attribute must have a phpdoc block on the line above the attribute', $variableStart);
            } else {
                // Find the start of the comment
                $commentStart = $phpcsFile->findPrevious(T_DOC_COMMENT, $commentEnd, null, true);

                // Fetch the complete comment
                $comment = $phpcsFile->getTokensAsString($commentStart, ($commentEnd - $commentStart + 1));

                // Create a comment parser
                $parser = new PHP_CodeSniffer_CommentParser_MemberCommentParser($comment, $phpcsFile);

                // Parse the comment
                $parser->parse();

                // Fetch the varaible type keyword
                $variableType = $parser->getVar();

                // Fetch the short comment
                $shortComment = trim($parser->getComment()->getShortComment());

                if (!$variableType) {
                    $phpcsFile->addError('phpdoc block missing @var', $commentStart);
                } else if (count(explode("\n", $variableType->getWhitespaceBefore())) !== 3) {
                    $phpcsFile->addError('The @var tag must have one empty line above it', $commentStart);
                } else if (empty($shortComment)) {
                    $phpcsFile->addError('Each attribute must have a short comment in the docblock', $commentStart);
                }
            }
        }
    }
}