<?php

/**
* 
* Parses for interwiki links.
* 
* @category Text
* 
* @package Text_Wiki
* 
* @author Paul M. Jones <pmjones@php.net>
* 
* @author Moritz Venn <moritz.venn@freaque.net>
* 
* @license LGPL
* 
* @version $Id$
* 
*/

/**
* 
* Parses for interwiki links.
* 
* This class implements a Text_Wiki_Parse to find source text marked as
* an Interwiki link.  See the regex for a detailed explanation of the
* text matching procedure; e.g., "InterWikiName:PageName".
*
* @category Text
* 
* @package Text_Wiki
* 
* @author Paul M. Jones <pmjones@php.net>
* 
* @author Moritz Venn <moritz.venn@freaque.net>
* 
*/

class Text_Wiki_Parse_Interwiki extends Text_Wiki_Parse {
    
    var $regex = '([A-Za-z0-9_ ]+|\:[A-Za-z0-9_ \/=&~#.:;-]+)';
    
    /**
    * 
    * Parser.  We override the standard parser so we can
    * find both described interwiki links and standalone links.
    * 
    * @access public
    * 
    * @return void
    * 
    */
    
    function parse()
    {
    	/* We currently check for Word-Bounding */
        // described interwiki links
        $tmp_regex = '/\[\[' . $this->regex . '\|([A-Za-z0-9_ ]+)\]\]\B/';
        $this->wiki->source = preg_replace_callback(
            $tmp_regex,
            array(&$this, 'processDescr'),
            $this->wiki->source
        );

        // standalone interwiki links
        $tmp_regex =  '/\[\[' . $this->regex . '\]\]\B/';
        $this->wiki->source = preg_replace_callback(
            $tmp_regex,
            array(&$this, 'process'),
            $this->wiki->source
        );

    }
    
    
    /**
    * 
    * Generates a replacement for the matched standalone interwiki text.
    * Token options are:
    * 
    * 'site' => The key name for the Text_Wiki interwiki array map,
    * usually the name of the interwiki site.
    * 
    * 'page' => The page on the target interwiki to link to.
    * 
    * 'text' => The text to display as the link.
    * 
    * @access public
    *
    * @param array &$matches The array of matches from parse().
    *
    * @return A delimited token to be used as a placeholder in
    * the source text, plus any text priot to the match.
    *
    */
    
    function process(&$matches)
    {
        $sitearr = explode(":", $matches[1]);
    	$sitec = count($sitearr);
        $options = array(
            'site' => ($sitec > 1) ? $sitearr[1] : "local",
            'page' => ($sitec > 1) ? $sitearr[2] : $matches[1],
            'text' => ($sitec > 1) ? $sitearr[2] : $matches[1],
        );

        return $this->wiki->addToken($this->rule, $options);
    }
    
    
    /**
    * 
    * Generates a replacement for described interwiki links. Token
    * options are:
    * 
    * 'site' => The key name for the Text_Wiki interwiki array map,
    * usually the name of the interwiki site.
    * 
    * 'page' => The page on the target interwiki to link to.
    * 
    * 'text' => The text to display as the link.
    * 
    * @access public
    *
    * @param array &$matches The array of matches from parse().
    *
    * @return A delimited token to be used as a placeholder in
    * the source text, plus any text priot to the match.
    *
    */
    
    function processDescr(&$matches)
    {
    	/*
Array (
    [0] => [[Interwiki Test]]
    [1] => Interwiki
    [2] => Test
)
Array (
    [0] => [[Interwiki|Test]]
    [1] => Interwiki
    [2] => Test
)
Array (
    [0] => [[:en:Interwiki|Test]]
    [1] => :en:Interwiki
    [2] => Test
) 
    	 */
    	$sitearr = explode(":", $matches[1]);
    	$sitec = count($sitearr);
        $options = array(
            'site' => ($sitec > 1) ? $sitearr[1] : "local",
            'page' => ($sitec > 1) ? $sitearr[2] : $matches[1],
            'text' => $matches[2],
        );
        
        return $this->wiki->addToken($this->rule, $options);
    }
}
?>