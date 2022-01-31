
import i18n from 'i18next';
import { initReactI18next } from 'react-i18next';
import LanguageDetector from 'i18next-browser-languagedetector';

import Backend from 'i18next-http-backend';
//To load the translation files

i18n
  .use(Backend)
  .use(LanguageDetector)
  .use(initReactI18next)
  .init({
    //debug: process.env.NODE_ENV === 'production' ? false : true,
    fallbackLng: 'en',
    whitelist: ['en', 'ar'], //Array of abbrevations of the languages
    interpolation: {
      escapeValue: false,
    },
    ns: ['Translation'], //Names of the translation files
    // backend: {
    //   loadPath: `./locales/{{lng}}/{{ns}}.json`, //Path to the translation files
    //   //addPath: `${process.env.PUBLIC_URL}/locales/add/{{lng}}/{{ns}}`,
    // },
    detection: {
      order: ['localStorage', 'cookie'],
      caches: ['localStorage', 'cookie'],
    },
    saveMissing: true,
    saveMissingTo: 'all',
  });

export default i18n;