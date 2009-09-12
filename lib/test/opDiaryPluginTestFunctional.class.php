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
  protected
    $mobileUserAgent = 'KDDI-CA39 UP.Browser/6.2.0.13.1.5 (FUI) MMP/2.0';

  public function setMobile($userAgent = null)
  {
    if ($userAgent)
    {
      $this->mobileUserAgent = $userAgent;
    }

    $_SERVER['HTTP_USER_AGENT'] = $this->mobileUserAgent;
    opMobileUserAgent::resetInstance();
  }

  public function login($mailAddress, $password)
  {
    $params = array('authMailAddress' => array(
          'mail_address' => $mailAddress,
          'password'     => $password,
          ));

    return $this->post('/member/login/authMode/MailAddress', $params);
  }

  public function setCulture($culture)
  {
    return $this->get('/', array('sf_culture' => $culture));
  }
}
