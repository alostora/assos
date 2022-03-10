//icons material-ui
import HomeOutlinedIcon from '@mui/icons-material/HomeOutlined';
import ArrowBackIosOutlinedIcon from '@mui/icons-material/ArrowBackIosOutlined';
import { grey } from '@mui/material/colors';

//react
import React, { useEffect, Fragment, useContext } from 'react'
import { useTranslation } from "react-i18next";
import { Link, useHistory } from 'react-router-dom';

// redux
import { useDispatch, useSelector } from 'react-redux'
import { getOrder } from './../../redux/actions/orderActions'

//components
import CartItem from './CartItem';
import Loader from '../../components/Loader';
import { CountryContext } from '../../App';


const Cart = () => {

    //translate
    const { t } = useTranslation();

    //country for Currency
    const { country, } = useContext(CountryContext)

    // fetch from api
    const dispatch = useDispatch()

    const { loading, order, error } = useSelector(state => state.order)

    const cartItems = order ? order.order_items : [];

    useEffect(() => {

        dispatch(getOrder())

    }, [dispatch, error])

    // for route confirm order page 
    const history = useHistory();

    return (
        <div className='d-flex flex-column container mt-4 cart-page '>

            <div className="d-flex align-items-center page-names mb-4">

                <Link to="/" className="text-decoration-none d-flex align-items-center ">
                    <HomeOutlinedIcon style={{ color: grey[500] }} />
                    <span className="page-name mx-1">{t("Home")}</span>
                </Link>

                <ArrowBackIosOutlinedIcon fontSize="medium" style={{ color: grey[300] }} />

                <span className="page-name ">{t("Cart")}</span>

            </div>

            <Fragment>
                {loading ? <Loader /> :

                    <div className='d-flex flex-column items-cart'>

                        <span className='mb-3 items-num'>{cartItems && cartItems.length} &nbsp; {t("Cart Items")}</span>

                        <div className='row mx-0'>

                            <div className='items col-lg-9 col-12'>
                                {cartItems && cartItems.map(item =>

                                    <div className='mb-3' key={item.id}>

                                        <CartItem item={item} />
                                    </div>
                                )}
                            </div>

                            {order && cartItems && cartItems.length > 0 &&

                                <div className='col-lg-3 col-12 d-flex flex-column confirm-order mt-4 '>

                                    <div className='d-flex justify-content-between total-price mt-2'>
                                        <span>{t("Total")} </span>
                                        <span>
                                            <span className='total-num'>{order && order.total_price}</span>
                                            &nbsp;{country === "sa" ? t("SAR") : t("KWD")}</span>
                                    </div>

                                    <button className='confirm-order-btn mt-4 mb-1'
                                        onClick={(e) => {
                                            e.preventDefault();
                                            if (localStorage.getItem("api-token")) {

                                                return history.push(`/confirm-order/${order.id}`)
                                            } else {
                                                return history.push(`/login`)
                                            }

                                        }}>
                                        {t("Confirm Order")}
                                    </button>

                                </div>
                            }

                        </div>

                    </div>
                }
            </Fragment>
        </div>
    )
}

export default Cart;