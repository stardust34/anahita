<?php
/** 
 * LICENSE: ##LICENSE##
 * 
 * @category   Anahita
 * @package    Com_Invites
 * @subpackage Controller
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @version    SVN: $Id$
 * @link       http://www.anahitapolis.com
 */

/**
 * Invite Default Contorller
 *
 * @category   Anahita
 * @package    Com_Invites
 * @subpackage Controller
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @link       http://www.anahitapolis.com
 */

class ComInvitesControllerEmail extends ComInvitesControllerDefault
{		
    /** 
     * Constructor.
     *
     * @param KConfig $config An optional KConfig object with configuration options.
     * 
     * @return void
     */ 
    public function __construct(KConfig $config)
    {
        parent::__construct($config);;
    }
        
    /**
     * Initializes the default configuration for the object
     *
     * Called from {@link __construct()} as a first step of object instantiation.
     *
     * @param KConfig $config An optional KConfig object with configuration options.
     *
     * @return void
     */
    protected function _initialize(KConfig $config)
    {
        $config->append(array(
            'behaviors' => array('com://site/mailer.controller.behavior.mailer')
        ));
    
        parent::_initialize($config);
    } 
    
	/**
	 * Read
	 * 
	 * @param KCommandContext $contxt
	 * 
	 * @return void
	 */	
	protected function _actionInvite($context)
	{	
		$data = $context->data;		
		$siteConfig	= JFactory::getConfig();
		
		$emails = KConfig::unbox($data['email']);
		settype($emails, 'array');
		
		foreach($emails as $email) 
		{
			if($email)
			{
				$token = $this->getService('repos://site/invites.token')->getEntity(array(
					'data'=> array(
						'inviter' => get_viewer(),
						'serviceName' => 'email' 
					)
				));

				if ( $token->save() ) 
				{
				    $this->mail(array(
				            'subject'  => JText::sprintf('COM-INVITES-MESSAGE-SUBJECT', $siteConfig->getValue('sitename')),
				            'to'       => $email,
				            'layout'   => false,
				            'template' => 'invite',
				            'data'     => array(
				                    'invite_url' => $token->getURL(),
				                    'site_name'  => $siteConfig->getValue('sitename'),
				                    'sender'     => $this->viewer
				            )
				    ));				    
				}							
			}
		}
		$this->setMessage('COM-INVITES-EMAIL-INVITES-SENT','info', false);
	}
	
	/**
	 * Return the email adapter
	 * 
	 * @return mixed
	 */	
	protected function getAdapter()
	{
		if ( !isset($this->_adapter) ) {
			$this->_adapter = $this->getService('com://site/invites.adapter.email');			
		}
		
		return $this->_adapter;
	}	
}