<?php


namespace App\Helpers;


use App\Models\Provider\Provider;

class CompanyProfileUpdate
{
    public static function updateCompanyLanguage(Provider $provider,string $ids = null) : void
    {
        $languageCompanyDB = $provider->languages()
                                        ->get()
                                        ->pluck('id')
                                        ->toArray();
        $languageCompany = explode(',',$ids);

        $conditionEmptyDB = !count($languageCompanyDB) && $languageCompany[0] !== "";
        $conditionEmptyQuery = count($languageCompanyDB) &&  $languageCompany[0] === "";
        $conditionAll = count($languageCompanyDB) &&  $languageCompany[0] !== "";


        if ($conditionEmptyDB){
            foreach ($languageCompany as $item){
                $provider->languages()->attach($item);
            }
        }
        if ($conditionEmptyQuery){
            foreach ($languageCompanyDB as $item){
                $provider->languages()->detach($item);
            }
        }
        if ($conditionAll){
            $deleteLanguage =  array_diff($languageCompanyDB, $languageCompany);
            $attachLanguage =  array_diff($languageCompany,$languageCompanyDB);
            if (count($deleteLanguage)){
                foreach ($deleteLanguage as $item){
                    $provider->languages()->detach($item);
                }
            }
            if (count($attachLanguage)){
                foreach ($attachLanguage as $item){
                    $provider->languages()->attach($item);
                }
            }

        }

    }
}
