<?php
/**
 * Created by PhpStorm.
 * User: M_A_i
 * Date: 12/25/2018
 * Time: 10:49 AM
 */

namespace Mageplaza\Smtp\Fix;
use Magento\Framework\Registry;
use Magento\Framework\Mail\Template\SenderResolverInterface;

class Message
{
    protected $registry;
    protected $__senderResolver;

    public function __construct(
                                Registry $registry,
                                SenderResolverInterface $senderResolver
)
    {

        $this->registry =$registry;
        $this->_senderResolver =$senderResolver;
    }

    public function beforeSetFromByStore(
        \Magento\Framework\Mail\Template\TransportBuilderByStore $subject,
        $from,
        $store
    ) {

        $storeId = $this->registry->registry('mp_smtp_store_id');
		if(isset($storeId) ==false){
			$storeId =$store;
		}
        $email = $this->_senderResolver->resolve($from, $storeId);
        $this->registry->register("test",$email);
        return [$from, $store];
    }

}