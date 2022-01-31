//react
import React, { useState } from 'react'
import { axiosInstance } from "../axios/config";

// redux
import { useDispatch, } from 'react-redux'
import { getFavoriteItems } from './../redux/actions/favoriteActions'

//icons material-ui
import FavoriteBorderOutlinedIcon from '@mui/icons-material/FavoriteBorderOutlined';
import FavoriteOutlinedIcon from '@mui/icons-material/FavoriteOutlined';
import { red } from '@mui/material/colors';


const FavoriteIcon = ({ item }) => {

    const [itemFav, setItemFav] = useState(item.fav)

    const dispatch = useDispatch()

    const addItemToFav = (id) => {

        axiosInstance({
            method: "get",
            url: `/addItemToFav/${id}`,
        })
            .then((res) => res.status && dispatch(getFavoriteItems()))

            .catch((err) => console.error(err));

        setItemFav(true)
    }

    const removeItemFromFav = (id) => {

        axiosInstance({
            method: "get",
            url: `/removeItemFromFav/${id}`,
        })
            .then((res) => res.status && dispatch(getFavoriteItems()))

            .catch((err) => console.error(err));

        setItemFav(false)

    }

    const toggleFav = (id) => {

        itemFav ? removeItemFromFav(id) : addItemToFav(id)
    }

    return (
        <button className='btn-fav-toggle' onClick={() => toggleFav(item.id)}>

            {itemFav ?
                <FavoriteOutlinedIcon fontSize="small" style={{ color: red[800] }} />

                : <FavoriteBorderOutlinedIcon fontSize="small" />
            }
        </button>
    )
}

export default FavoriteIcon;
