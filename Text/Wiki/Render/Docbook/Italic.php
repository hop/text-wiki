<?php
// vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4:
/**
 * Italic rule end renderer for Docbook
 *
 * PHP versions 4 and 5
 *
 * @category   Text
 * @package    Text_Wiki_Docbook
 * @author     bertrand Gugger <bertrand@toggg.com>
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/Text_Wiki_Docbook
 */

/**
 * This class renders italic text in DocBook.
 *
 * @category   Text
 * @package    Text_Wiki_Docbook
 * @author     bertrand Gugger <bertrand@toggg.com>
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/Text_Wiki_Docbook
 */
class Text_Wiki_Render_Docbook_Italic extends Text_Wiki_Render
{
    public $conf = array(
        'role' => 'italic'
    );

    /**
    *
    * Renders a token into text matching the requested format.
    *
    * @access public
    *
    * @param array $options The "options" portion of the token (second
    * element).
    *
    * @return string The text rendered from the token options.
    *
    */

    public function token($options)
    {
        if ($options['type'] == 'end') {
            return '</emphasis>';
        }
        return '<emphasis' . (($role = $this->getConf('role', 'italic')) ?
            ' role="' . $role . '"' : '') . '>';
    }
}
