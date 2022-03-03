//react
import React, { useState } from 'react'
import { axiosInstance } from "../axios/config";

// redux
import { useDispatch, useSelector } from 'react-redux'
import { getOrder } from './../redux/actions/orderActions'

//icons material-ui
import ShoppingCartOutlinedIcon from '@mui/icons-material/ShoppingCartOutlined';
import ShoppingCartIcon from '@mui/icons-material/ShoppingCart';
import { green } from '@mui/material/colors';


const CartIcon = ({ item }) => {

    const [itemCart, setItemCart] = useState(item.cart)

    const { order } = useSelector(state => state.order)

    const cartItems = order ? order.order_items : [];

    const dispatch = useDispatch()

    const addItemToCart = (id) => {

        axiosInstance({
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

        setItemCart(true)
    }

    const removeItemFromCart = (id) => {

        const itemSelect = cartItems.find(it => it.item_id === id)

        axiosInstance({
            method: "get",
            url: `/deleteOrderItem/${itemSelect.id}`,
        })
            .then((res) => res.status && dispatch(getOrder()))

            .catch((err) => console.error(err));

        setItemCart(false)

    }

    const toggleCart = (id) => {

        itemCart ? removeItemFromCart(id) : addItemToCart(id)
    }

    return (
        <button className="btn-cart-toggle" onClick={() => toggleCart(item.id)}>

            {itemCart ?
                <ShoppingCartIcon sx={{ color: green[800] }} />

                : <ShoppingCartOutlinedIcon sx={{ color: localStorage.getItem("modeColor") === "light" ? "" : "white" }} />
            }
        </button>
    )
}

export default CartIcon;
