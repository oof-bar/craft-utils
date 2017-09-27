<? namespace Craft;

class Utils_CountryFieldType extends BaseFieldType
{
  public function getName()
  {
    return Craft::t('Country Select');
  }

  public function getInputHtml($name, $value)
  {
    return craft()->templates->render('utils/fields/country-select', [
      'name'  => $name,
      'value' => $value,
      'countries' => craft()->utils->getDataGroup('countries')
    ]);
  }
}
