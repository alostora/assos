//react
import React, { useContext } from 'react'
import { Link } from "react-router-dom";
import { axiosInstance } from "../../axios/config";

// redux
import { useDispatch, } from 'react-redux'
import { getOrder } from './../../redux/actions/orderActions'
import { getFavoriteItems } from '../../redux/actions/favoriteActions';

//translate 
import { useTranslation } from "react-i18next";

//material-ui
import DeleteOutlineOutlinedIcon from '@mui/icons-material/DeleteOutlineOutlined';
import { grey } from '@mui/material/colors';

//components
import { CountryContext } from '../../App'


const CartItem = ({ item }) => {

    //translate
    const { t } = useTranslation();

    const { country, } = useContext(CountryContext)

    const dispatch = useDispatch()

    const deleteItemFromOrder = async (id) => {

        await axiosInstance({
            method: "get",
            url: `/deleteOrderItem/${id}`,
        })
            .then((res) => res.status && dispatch(getOrder()))

            .catch((err) => console.error(err));

    }

    const addItemToFav = async (id) => {

        await axiosInstance({
            method: "get",
            url: `/addItemToFav/${id}`,
        })
            .then((res) => res.status && dispatch(getFavoriteItems()) && dispatch(getOrder()))

            .catch((err) => console.error(err));

    }

    //product counter
    const incrementCount = async (id) => {

        await axiosInstance({
            method: "get",
            url: `/itemCountPlus/${id}`,
        })
            .then((res) => res.status && dispatch(getOrder()))

            .catch((err) => console.error(err));

    }

    const decrementCount = async (id) => {

        await axiosInstance({
            method: "get",
            url: `/itemCountMinus/${id}`,
        })
            .then((res) => res.status && dispatch(getOrder()))

            .catch((err) => console.error(err));

    }

    return (

        <div className='item-cart row'>

            <img src={item.itemImage} alt='itemImage' className='col-4 col-lg-3' />

            <div className='d-flex flex-column col-7 col-lg-6'>
                <Link to={`/product-details/${item.item_id}`}
                    className="text-decoration-none d-flex flex-column">

                    <span className='brand-name mt-1'>{item.vendor_info && item.vendor_info.vendor_name}</span>
                    <span className='item-name my-1'>{item.itemName}</span>

                    <div className='d-flex mt-1'>

                        <span className="item-price ">{item.itemPriceAfterDis}
                            &nbsp;{country === "sa" ? t("SAR") : t("KWD")}
                        </span>

                        <span className="item-price-old mx-4">{item.itemPrice}
                            &nbsp;{country === "sa" ? t("SAR") : t("KWD")}
                        </span>
                    </div>

                </Link>

                <div className='mt-2'>

                    <div className="d-flex justify-content-between align-items-center count-num">
                        <button className="btn-minus" onClick={() => decrementCount(item.id)}>-</button>
                        <span>{item.item_count}</span>
                        <button className="btn-add" onClick={() => incrementCount(item.id)}>+</button>
                    </div>
                </div>
            </div>
            <div className=' d-flex flex-column justify-content-around align-items-center col-12 col-lg-3 py-1'>
                <button className='btn-delete d-flex justify-content-center align-items-center'
                    onClick={() => deleteItemFromOrder(item.id)}>

                    <DeleteOutlineOutlinedIcon style={{ color: grey[500] }} />
                    <span className='px-1'>{t("Delete")}</span>

                </button>

                {!item.fav &&

                    <button className='btn-cart d-flex justify-content-center align-items-center p-3'

                        onClick={() => addItemToFav(item.item_id)}

                    >{t("Add to Favorite")}</button>
                }

            </div>

        </div>

    )
}

export default CartItem;