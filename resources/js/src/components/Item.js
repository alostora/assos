//react
import React, { useContext } from "react";
import { Link, useHistory } from "react-router-dom";

// country currency
import { CountryContext } from "../App";
import { t } from "i18next";

//component
import FavoriteIcon from "./FavoriteIcon";
//import CartIcon from "./CartIcon";

const Item = ({ item }) => {

    const { country, } = useContext(CountryContext)

    const history = useHistory();

    return (

        <div className="item d-flex flex-column my-2">

            <div className="d-flex item-img">

                <img src={item.itemImage} alt="itemImage"
                    onClick={(event) => {
                        event.preventDefault();
                        return history.push(`/product-details/${item.id}`)
                    }} />

                <div className="hart-icon-btn d-flex justify-content-center align-items-center" >

                    <FavoriteIcon item={item} />
                </div>

            </div>

            <div className="item-details">

                {/* <div className="d-flex justify-content-between align-items-center">

                    <Link
                        to={`/product-details/${item.id}`}
                        className="text-decoration-none d-flex">

                        <span className="item-name">{item.itemName}</span>
                    </Link>

                    <div className="cart-icon-btn d-flex justify-content-center align-items-center">

                        <CartIcon item={item} />
                    </div>
                </div> */}

                <div className="d-flex align-items-center">

                    <Link
                        to={`/product-details/${item.id}`}
                        className="text-decoration-none d-flex">

                        <span className="item-name">{item.itemName}</span>
                    </Link>

                </div>

                <Link
                    to={`/product-details/${item.id}`}
                    className="text-decoration-none ">

                    <div className="d-flex flex-wrap">

                        <span className="item-price">{item.itemPriceAfterDis}
                            &nbsp;{country === "sa" ? t("SAR") : t("KWD")}
                        </span>

                        <span className="item-price-old px-3">{item.itemPrice}
                            &nbsp;{country === "sa" ? t("SAR") : t("KWD")}
                        </span>
                    </div>
                </Link>
            </div>
        </div>
    )
}

export default Item;