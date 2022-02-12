//react
import React, { useEffect, useState, useContext } from "react";

//icons material-ui
import LanguageRoundedIcon from '@mui/icons-material/LanguageRounded';
import DarkModeOutlinedIcon from '@mui/icons-material/DarkModeOutlined';
import WbSunnyIcon from '@mui/icons-material/WbSunny';

//icons
import Kuwait_flag from "./../assets/icons/Home/Kuwait_flag.svg"
import Saudi_Arabia_flag from "./../assets/icons/Home/Saudi_Arabia_flag.svg"

// translate
import { useTranslation } from "react-i18next";
import i18next from "i18next";

//mode
import { ThemeContext } from "../App";

//country
import { CountryContext } from "../App";


const Header = () => {
  //translate
  const { t } = useTranslation();

  const nameLang = i18next.language === "ar" ? "Arabic" : "English";

  const [langName, setLangName] = useState(nameLang);

  const dirLang = i18next.dir()

  const changeLang = () => {
    i18next.language === "ar"
      ? i18next.changeLanguage("en")
      : i18next.changeLanguage("ar");
    setLangName(i18next.language === "ar" ? "English" : "Arabic");

    window.location.reload();
  };

  ///////////////////////////////////////////////////
  //Dark mode

  const { mode, setMode } = useContext(ThemeContext)

  const nameMode = mode === "light" ? "Dark Mode" : "Light Mode";

  const [modeName, setModeName] = useState(nameMode);

  const changeMode = () => {
    const currentMode = mode === "light" ? "dark" : "light";

    setMode(currentMode);

    localStorage.setItem("modeColor", currentMode);

    setModeName(localStorage.getItem("modeColor") === "light" ? "Dark Mode" : "Light Mode");
  };

  /////////////////////////////////////////////////////
  // country

  const { country, setCountry } = useContext(CountryContext)

  const nameCountry = country === "sa" ? "Kuwait" : "Saudi Arabia";

  const [countryName, setCountryName] = useState(nameCountry);

  const changeCountry = () => {
    const currentCountry = country === "sa" ? "kw" : "sa";

    setCountry(currentCountry)
    localStorage.setItem("country", currentCountry);

    setCountryName(localStorage.getItem("country") === "sa" ? "Saudi Arabia" : "Kuwait")

    window.location.reload();
  };
  //////////////////////////////////////////////////

  useEffect(() => {
    document.body.dir = dirLang;
    document.title = t("app_title");
  }, [dirLang, t]);

  return (

    <header className={`app-header app-header-${mode} py-2 `}>

      <div className="container p-0">
        <div className="row mx-0">

          <button className="btn-header col-4 col-xl-2" onClick={changeCountry}>
            <span>{t(countryName)}</span>
            <img
              src={country === "kw" ? Saudi_Arabia_flag : Kuwait_flag}
              alt="country Flag"
              width="28px" height="auto"
            />
          </button>

          <button className="btn-header col-4 col-xl-2" onClick={changeMode}>
            <span>{t(modeName)}</span>
            {mode === "light" ? <DarkModeOutlinedIcon /> : <WbSunnyIcon />}
          </button>

          <button className="btn-header col-4  col-xl-2" onClick={changeLang}>
            <span>{t(langName)}</span>
            <LanguageRoundedIcon />
          </button>
        </div>
      </div>
    </header>

  );
};

export default Header;
