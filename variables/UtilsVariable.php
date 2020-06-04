<?php namespace Craft;

class UtilsVariable
{
  public function releasePath()
  {
    return str_replace('craft/app', '', craft()->path->appPath);
  }

  public function includeCss($asset)
  {
    $mtime = $this->assetModificationTime($asset);
    $url = $this->assetUrl($asset, ['mtime' => $mtime]);
    craft()->templates->includeCssFile(UrlHelper::getUrl($url));
  }

  public function includeJs($asset)
  {
    $mtime = $this->assetModificationTime($asset);
    $url = $this->assetUrl($asset, ['mtime' => $mtime]);
    craft()->templates->includeJsFile(UrlHelper::getUrl($url));
  }

  public function assetModificationTime($asset)
  {
    $file = $this->releasePath() . '/public/' . $asset;
    return IOHelper::getLastTimeModified($file)->getTimestamp();
  }

  public function assetUrl($asset, $params = [])
  {
    return UrlHelper::getSiteUrl($asset, $params);
  }

  public function assetPath(AssetFileModel $asset)
  {
    $source = $asset->getSource();
    if  ($source->type != 'Local' )
    {
      throw new Exception(Craft::t('Paths not available for non-local asset sources'));
    }

    $sourcePath = $source->settings['path'];
    $folderPath = $asset->getFolder()->path;

    return $sourcePath . $folderPath . $asset->filename;
  }

  public function inlineAsset($asset)
  {
    $file = $this->releasePath() . 'public/' . $asset;
    return IOHelper::getFileContents($file);
  }

  public function getDataGroup($dataGroupName)
  {
    return craft()->utils->getDataGroup($dataGroupName);
  }
}
