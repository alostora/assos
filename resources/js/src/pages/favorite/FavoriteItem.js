//react
import React, { useContext } from 'react'
import { Link } from "react-router-dom";
import { axiosInstance } from "../../axios/config";

// redux
import { useDispatch, } from 'react-redux'
import { getFavoriteItems } from './../../redux/actions/favoriteActions'
import { getOrder } from '../../redux/actions/orderActions';

//translate 
import { useTranslation } from "react-i18next";

//material-ui
import DeleteOutlineOutlinedIcon from '@mui/icons-material/DeleteOutlineOutlined';
import { grey } from '@mui/material/colors';

//components
import { CountryContext } from '../../App'


const FavoriteItem = ({ item }) => {

    //translate
    const { t } = useTranslation();

    const { country, } = useContext(CountryContext)

    const dispatch = useDispatch()

    const removeItemFromFav = async (id) => {

        await axiosInstance({
            method: "get",
            url: `/removeItemFromFav/${id}`,
        })
            .then((res) => res.status && dispatch(getFavoriteItems()))

            .catch((err) => console.error(err));

    }

    const addItemToCart = async (id) => {

        await axiosInstance({
            method: "post",
            url: `/makeOrder`,
            data: {
                "item_id": id,
                "count": 1,
                "props": []
            }
        })
            .then((res) => res.status && dispatch(getOrder()))

            .catch((err) => console.error(err));

    }

    return (
        <div className='row item-fav'>

            <img src={item.itemImage} alt='itemImage' className='col-4 col-lg-3' />

            <Link to={`/product-details/${item.id}`}
                className="text-decoration-none d-flex flex-column col-7 col-lg-6">

                <span className='brand-name mt-1'>{item.vendor_info && item.vendor_info.vendor_name}</span>
                <span className='item-name my-2'>{item.itemName}</span>

                <div className='d-flex mt-3'>

                    <span className="item-price ">{item.itemPriceAfterDis}
                        &nbsp;{country === "sa" ? t("SAR") : t("KWD")}
                    </span>

                    <span className="item-price-old mx-4">{item.itemPrice}
                        &nbsp;{country === "sa" ? t("SAR") : t("KWD")}
                    </span>
                </div>

            </Link>

            <div className='d-flex flex-column justify-content-around align-items-center col-12 col-lg-3 py-1'>
                <button className='btn-delete d-flex justify-content-center align-items-center' onClick={() => removeItemFromFav(item.id)}>

                    <DeleteOutlineOutlinedIcon style={{ color: grey[500] }} />
                    <span className='px-1'>{t("Delete")}</span>

                </button>
                <button className='btn-cart d-flex justify-content-center align-items-center p-3'
                    onClick={() => addItemToCart(item.id)}>

                    {t("Add to Cart")}</button>
            </div>

        </div>
    )
}

export default FavoriteItem