//translate
import { useTranslation } from "react-i18next";

//react
import React from "react";

import { Link } from "react-router-dom";

const Categories = () => {

    //translate
    const { t } = useTranslation();

    //change filter
    const chooseMainFilter = (filterName) => {

        localStorage.setItem("main-filter", filterName)

        window.location.reload();
    }

    return (

        <div className=" category-header">

            <div className="container">

                <div className="row py-2 mx-0">

                    <Link to='/recent-items'
                        className="text-decoration-none category-name col-xl-2 col-md-3 col-6 d-flex justify-content-center align-items-center"
                    >
                        {t("recently arrived")}
                    </Link>

                    <Link to='/brands'
                        className="text-decoration-none category-name col-xl-2 col-md-3 col-6 d-flex justify-content-center align-items-center"
                    >
                        {t("international brands")}
                    </Link>

                    <button className="category-name d-flex justify-content-center align-items-center col-xl-2 col-md-2 col-4"
                        onClick={() => chooseMainFilter("men")}
                    >{t("Men")}</button>
                    <button className="category-name d-flex justify-content-center align-items-center col-xl-2 col-md-2 col-4"
                        onClick={() => chooseMainFilter("women")}
                    >{t("Woman")}</button>
                    <button className="category-name d-flex justify-content-center align-items-center col-xl-2 col-md-2 col-4"
                        onClick={() => chooseMainFilter("kids")}
                    >{t("Kids")}</button>


                    <Link to='/last-chance'
                        className="text-decoration-none unique-categ col-xl-2 col-md-12 col-12 d-flex justify-content-center align-items-center m-auto"
                    >
                        {t("Last Chance")}
                    </Link>
                </div>
            </div>
        </div>

    )
}

export default Categories