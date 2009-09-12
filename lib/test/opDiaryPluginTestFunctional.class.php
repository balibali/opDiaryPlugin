<?php

/**
 * functional test class for the opDiaryPlugin.
 *
 * @package    OpenPNE
 * @subpackage diary
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opDiaryPluginTestFunctional extends sfTestFunctional
{
  function login($mailAddress, $password)
  {
    $params = array('authMailAddress' => array(
          'mail_address' => $mailAddress,
          'password'     => $password,
          ));

    return $this->post('/member/login/authMode/MailAddress', $params);
  }

  function setCulture($culture)
  {
    $params = array('language' => array('culture' => $culture));

    return $this->post('/member/changeLanguage', $params);
  }
}
