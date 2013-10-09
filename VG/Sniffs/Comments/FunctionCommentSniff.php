<?php
/**
 * VG Coding Standard
 *
 * @category VG
 * @package CodingStandard
 * @version $Id: FunctionCommentSniff.php 3148 2012-07-20 08:04:43Z christere $
 * @author Christer Edvartsen <ce@vg.no>
 */

/**
 * Sniff that looks for phpdoc blocks above functions
 *
 * All functions must have a phpdoc block that describes the function with a short comment. The
 * sniff also makes sure the @param definitions are correct according to the variables in the
 * function definition. It also requires a @throws keyword if the function throws an exception. If
 * the function returns data, a @return keyword is required.
 *
 * @category VG
 * @package CodingStandard
 */
class VG_Sniffs_Comments_FunctionCommentSniff implements PHP_CodeSniffer_Sniff {
    /**
     * Which tokens this sniff should look for
     *
     * @return array
     */
    public function register() {
        return array(T_FUNCTION);
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

        // If this is a closure, ignore it
        $nextString = $phpcsFile->findNext(T_STRING, $stackPtr);

        if ($nextString > $tokens[$stackPtr]['parenthesis_opener']) {
            return;
        }

        // Find previos phpdoc
        $commentEnd = $phpcsFile->findPrevious(T_DOC_COMMENT, $stackPtr);

        if (!$commentEnd || $tokens[$commentEnd]['line'] !== $tokens[$stackPtr]['line'] - 1) {
            $phpcsFile->addError('All functions must have a preceding phpdoc block', $stackPtr);
            return;
        }

        $commentStart = $phpcsFile->findPrevious(T_DOC_COMMENT, $commentEnd, null, true);
        $commentString = $phpcsFile->getTokensAsString($commentStart, ($commentEnd - $commentStart) + 1);

        // Create a parser and parse the comment
        $parser = new PHP_CodeSniffer_CommentParser_FunctionCommentParser($commentString, $phpcsFile);
        $parser->parse();

        $comment = $parser->getComment();

        if (empty($comment)) {
            $phpcsFile->addError('Invalid phpdoc block', $commentStart);
            return;
        }

        // If the function is deprecated, it does not need to follow the rest of the rules
        if ($parser->getDeprecated() !== null) {
            return;
        }

        // Fetch short description
        $shortDescription = trim($parser->getComment()->getShortComment());
        $longDescription  = trim($parser->getComment()->getLongComment());

        // Make sure that we have a short description
        if (empty($shortDescription) && empty($longDescription)) {
            $phpcsFile->addWarning('The phpdoc block is missing a short description', $commentStart);
            return;
        }

        // Initialize offset
        $offset = $stackPtr + 1;

        // Initialize function params
        $functionDefinition = array();

        // Function params (from the function definition
        while ($variable = $phpcsFile->findNext(T_VARIABLE, $offset, $tokens[$stackPtr]['parenthesis_closer'])) {
            $functionDefinition[] = $tokens[$variable]['content'];

            $offset = $variable + 1;
        }

        // Fetch params and make sure that they are correct according to the function definition
        $params = $parser->getParams();

        // Initialize phpdoc variables
        $phpdocVars = array();

        foreach ($params as $param) {
            $type    = $param->getType();
            $var     = $param->getVarName();
            $comment = $param->getComment();

            // If $var is empty, the params is most likely to miss a type definition
            if (empty($var)) {
                $phpcsFile->addWarning('The ' . $type . ' param is missing a type definition', $commentStart);
            } else if (empty($comment)) {
                $phpcsFile->addWarning('The ' . $var . ' param is missing a comment', $commentStart);
            }

            $phpdocVars[] = $var;
        }

        if (!strstr($commentString, "inheritdoc") && ($functionDefinition !== $phpdocVars)) {
            $phpcsFile->addError('The variables listed in the phpdoc block does not match the function definition', $commentStart);
            return;
        }

        // Make sure that the phpdoc block has a @return tag if the function includes a return
        // statement. Also make sure that the phpdoc block has a @throws tag if the function throws
        // an exception. But only when not is using inheritdoc from the interface.
        if (!strstr($commentString, "inheritdoc") && (!empty($tokens[$stackPtr]['scope_opener']))) {
            $return = $phpcsFile->findNext(T_RETURN, $tokens[$stackPtr]['scope_opener'], $tokens[$stackPtr]['scope_closer']);

            // Fetch return from the phpdoc element
            $phpdocReturn = $parser->getReturn();

            if ($return && empty($phpdocReturn)) {
                $phpcsFile->addWarning('The phpdoc block is missing a @return tag', $commentStart);
                return;
            }

            // Initialize offset
            $offset = $tokens[$stackPtr]['scope_opener'] + 1;

            $throw = $phpcsFile->findNext(T_THROW, $offset, $tokens[$stackPtr]['scope_closer']);

            if (!$throw) {
                // The function does not throw anything, return
                return;
            }

            $throws = $parser->getThrows();

            if (empty($throws)) {
                $phpcsFile->addWarning('The function docblock is missing a @throws tag', $commentStart);
                return;
            }
        }
    }
}