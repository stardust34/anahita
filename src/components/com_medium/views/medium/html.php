<?php

/**
 * Medium Item View.
 *
 * @category   Anahita
 *
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 *
 * @link       http://www.GetAnahita.com
 */
class ComMediumViewMediumHtml extends ComBaseViewHtml
{
    /**
     * Initializes the options for the object.
     *
     * Called from {@link __construct()} as a first step of object instantiation.
     *
     * @param 	object 	An optional KConfig object with configuration options.
     */
    protected function _initialize(KConfig $config)
    {
        $config->append(array(
            'template_paths' => array(dirname(__FILE__).'/html'),
        ));

        parent::_initialize($config);

        $config->append(array(
            'template_paths' => array(ANPATH_THEMES.'/'.$this->getService('application')->getTemplate().'/html/com_medium/medium'),
        ));
    }
}
