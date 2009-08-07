<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Pdf
 * @subpackage Actions
 * @copyright  Copyright (c) 2005-2009 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

/** Zend_Pdf_ElementFactory */
require_once 'Zend/Pdf/ElementFactory.php';


/**
 * PDF target (action or destination)
 *
 * @package    Zend_Pdf
 * @subpackage Actions
 * @copyright  Copyright (c) 2005-2009 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
abstract class Zend_Pdf_Target
{
    /**
     * Parse resource and return it as an Action or Explicit Destination
     *
     * $param Zend_Pdf_Element $resource
     * @return Zend_Pdf_Destination|
     * @throws Zend_Pdf_Exception
     */
    public static function load(Zend_Pdf_Element $resource) {
        if ($resource->getType() == Zend_Pdf_Element::TYPE_DICTIONARY) {
            if (($resource->Type === null  ||  $resource->Type->value =='Action')  &&  $resource->S !== null) {
                // It's a well-formed action, load it
                return Zend_Pdf_Action::load($resource);
            } else if ($resource->D !== null) {
                // It's a destination
                $resource = $resource->D;
            } else {
                require_once 'Zend/Pdf/Exception.php';
                throw new Zend_Pdf_Exception('Wrong resource type.');
            }
        }

        if ($resource->getType() == Zend_Pdf_Element::TYPE_DICTIONARY) {
            // Load destination as appropriate action
            return Zend_Pdf_Action::load($resource);
        } else if ($resource->getType() == Zend_Pdf_Element::TYPE_ARRAY  ||
                   $resource->getType() == Zend_Pdf_Element::TYPE_NAME   ||
                   $resource->getType() == Zend_Pdf_Element::TYPE_STRING) {
            // Resource is an array, just treat it as an explicit destination array
            return Zend_Pdf_Destination::load($resource);
        } else {
            require_once 'Zend/Pdf/Exception.php';
            throw new Zend_Pdf_Exception( 'Wrong resource type.' );
        }
    }

    /**
     * Get resource
     *
     * @internal
     * @return Zend_Pdf_Element
     */
    abstract public function getResource();
}
