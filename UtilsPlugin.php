<? namespace Craft;

class UtilsPlugin extends BasePlugin
{
  public function getName()
  {
    return Craft::t('Craft Utilities');
  }

  public function getVersion()
  {
    return '1.0';
  }

  public function getDeveloper()
  {
    return 'oof. Studio';
  }

  public function getDeveloperUrl()
  {
    return 'http://oof.studio/';
  }

  public function hasCpSection()
  {
    return false;
  }

  public function addTwigExtension()
  {
    Craft::import('plugins.utils.twigextensions.UtilsTwigExtension');
    return new UtilsTwigExtension();
  }

  public function init()
  {
    if (craft()->request->isCpRequest() && craft()->userSession->isLoggedIn())
    {
      craft()->templates->includeCssResource('utils/css/utils-cp.css');
    }
  }
}
