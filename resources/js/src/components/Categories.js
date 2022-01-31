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
                        className="text-decoration-none category-name col-6 col-lg-2 d-flex justify-content-center align-items-center"
                    >
                        {t("recently arrived")}
                    </Link>

                    <Link to='/brands'
                        className="text-decoration-none category-name col-6 col-lg-2 d-flex justify-content-center align-items-center"
                    >
                        {t("international brands")}
                    </Link>

                    <button className="category-name d-flex justify-content-center align-items-center col-4 col-lg-2 "
                        onClick={() => chooseMainFilter("men")}
                    >{t("Men")}</button>
                    <button className="category-name d-flex justify-content-center align-items-center col-4 col-lg-2 "
                        onClick={() => chooseMainFilter("women")}
                    >{t("Woman")}</button>
                    <button className="category-name d-flex justify-content-center align-items-center col-4 col-lg-2 "
                        onClick={() => chooseMainFilter("kids")}
                    >{t("Kids")}</button>


                    <button className="unique-categ-btn d-flex justify-content-center align-items-center col-6 col-lg-2 ">
                        {t("Last Chance")}
                    </button>

                </div>
            </div>
        </div>

    )
}

export default Categories