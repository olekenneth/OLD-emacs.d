<?php
/**
 * VG Coding Standard
 *
 * @category VG
 * @package CodingStandard
 * @version $Id: ClassConstantCommentSniff.php 2390 2011-02-03 14:03:43Z christere $
 * @author Christer Edvartsen <ce@vg.no>
 */

/**
 * Class constant comment sniff
 *
 * This sniff looks for constants defined in classes and makes sure they have sufficient
 * commenting. If the next line also has a constant, the group must be commented using special
 * phpdoc syntax (#@+ ... #@-)
 *
 * @category VG
 * @package CodingStandard
 */
class VG_Sniffs_Comments_ClassConstantCommentSniff implements PHP_CodeSniffer_Sniff {
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

        // The contants in the file
        $constants = array();

        // Fetch all constants
        while ($variableStart = $phpcsFile->findNext(T_CONST, $offset)) {
            // Update offset
            $offset = $variableStart + 1;

            $constants[$variableStart] = $tokens[$variableStart];
        }

        // Initialize variables that will hold the line numbers for the start and end of the group
        $groupStart = null;
        $groupEnd = null;
        $numConstants = count($constants);

        // Since we use the token indexes as keys, fetch the keys here so we can use them in the loop below
        $keys = array_keys($constants);

        // If we have any constants, set the first start position
        if ($numConstants) {
            $groupStart = $keys[0];
        }

        foreach ($keys as $i => $token) {
            // We are currently not in a group. Start a new one
            if ($groupStart === null) {
                $groupStart = $token;
            }

            // If this is the last constant, set the group end to the line number of the current constant
            if (($i + 1) === $numConstants) {
                $groupEnd = $token;
            } else {
                // See if the next constant in the array is directly below the current one
                if ($constants[$keys[$i + 1]]['line'] === ($constants[$token]['line'] + 1)) {
                    // Continue to the next loop
                    continue;
                } else {
                    // This is the last constant in this group
                    $groupEnd = $token;
                }
            }

            // Do we have a start and an end? If so, check the phpdoc for the group
            if ($groupStart !== null && $groupEnd !== null) {
                // Fetch previous comment token
                $commentEnd = $phpcsFile->findPrevious(array(T_COMMENT, T_DOC_COMMENT), $groupStart);

                if (!$commentEnd || $tokens[$commentEnd]['line'] !== ($tokens[$groupStart]['line'] - 1)) {
                    $phpcsFile->addError('Each constant group must have a phpdoc block directly above', $groupStart);
                } else {
                    // Find the start of the comment and parse it to check content
                    $commentStart = $phpcsFile->findPrevious(array(T_COMMENT, T_DOC_COMMENT), $commentEnd, null, true);

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
                    } else if (empty($shortComment)) {
                        $phpcsFile->addError('Each constant must have a short comment in the docblock', $commentStart);
                    } else if (count(explode("\n", $variableType->getWhitespaceBefore())) !== 3) {
                        $phpcsFile->addError('The @var tag must have one empty line above it', $commentStart);
                    }

                    if ($groupStart !== $groupEnd) {
                        // If we have a group with several constants, the start and end of the
                        // docblocks must have a special syntax marking the start and end of a
                        // repeating doc block.
                        if (trim($tokens[$commentStart + 1]['content']) !== '/**#@+') {
                            $phpcsFile->addError('When several constants are grouped together the phpdoc block above the first must start a phpdoc template (/**#@+)', $commentStart);
                        } else {
                            // First, find the first token in the next line
                            $offset = $groupEnd;

                            // Find the next comment after the last constant and make sure it ends
                            // the phpdoc template started before the first constant.
                            while ($commentStart = $phpcsFile->findNext(array(T_COMMENT, T_DOC_COMMENT), $offset)) {
                                if ($tokens[$commentStart]['line'] == $tokens[$groupEnd]['line']) {
                                	// We are on the same line as the constant still. Keep looking
                                	// for the first token in the next line
                                    $offset++;
                                } else {
                                	// Next line, break out of the loop
                                    break;
                                }
                            }

                            if ($tokens[$commentStart]['line'] !== ($tokens[$groupEnd]['line'] + 1) ||
                                $tokens[$commentStart]['content'] !== '/**#@-*/') {
                                $phpcsFile->addError('When several constants are grouped together the phpdoc block below the last one must end the phpdoc template using the /**#@-*/ syntax', $groupEnd);
                            }
                        }
                    }
                }

                // Reset start and end positions
                $groupStart = null;
                $groupEnd = null;
            }
        }
    }
}