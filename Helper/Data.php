<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_Smtp
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\Smtp\Helper;

use Magento\Store\Model\ScopeInterface;
use Mageplaza\Core\Helper\AbstractData;
use Magento\Framework\Encryption\EncryptorInterface;

/**
 * Class Data
 * @package Mageplaza\Smtp\Helper
 */
class Data extends AbstractData
{
    public function __construct(
        EncryptorInterface $encryptor
    )
    {
        $this->encryptor = $encryptor;
    }

    const CONFIG_MODULE_PATH = 'smtp';
    const CONFIG_GROUP_SMTP  = 'configuration_option';
    const DEVELOP_GROUP_SMTP = 'developer';

    /**
     * @param string $code
     * @param null $storeId
     * @return mixed
     */
    public function getSmtpConfig($code = '', $storeId = null)
    {
        $code = ($code !== '') ? '/' . $code : '';

        return $this->getModuleConfig(self::CONFIG_GROUP_SMTP . $code, $storeId);
    }

    /**
     * @param string $code
     * @param null $storeId
     * @return mixed
     */
    public function getDeveloperConfig($code = '', $storeId = null)
    {
        $code = ($code !== '') ? '/' . $code : '';

        return $this->getModuleConfig(self::DEVELOP_GROUP_SMTP . $code, $storeId);
    }

    /**
     * @param null $storeId
     * @param bool $decrypt
     * @return array|mixed|string
     */
    public function getPassword($storeId = null, $decrypt = true){
        if($storeId != null){
            $password = $this->getSmtpConfig('', $storeId);
        }else{
            $password = $this->getSmtpConfig('');
        }

        if ($decrypt) {
            return $this->encryptor->decrypt($password);
        }

        return $password;
    }
}
