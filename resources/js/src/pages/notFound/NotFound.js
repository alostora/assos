import React from 'react'

//translate
import { useTranslation } from "react-i18next";


const NotFound = () => {

    //translate
    const { t } = useTranslation();

    return (
        <div className='d-flex justify-content-center my-5'>
            <h1>{t("Not found page 404")}</h1>
        </div>
    )
}

export default NotFound;
