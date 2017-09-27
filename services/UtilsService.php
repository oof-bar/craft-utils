<? namespace Craft;

class UtilsService extends BaseApplicationComponent
{
  public function getDataGroup($groupName)
  {
    $path = craft()->resources->getResourcePath("utils/json/$groupName.json");

    if ($path)
    {
      return json_decode(IOHelper::getFileContents($path));
    }
    else
    {
      return false;
    }
  }
}
