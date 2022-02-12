//icons material-ui
import HomeOutlinedIcon from '@mui/icons-material/HomeOutlined';
import ArrowBackIosOutlinedIcon from '@mui/icons-material/ArrowBackIosOutlined';
import { grey } from '@mui/material/colors';

//react
import React, { useEffect, Fragment } from 'react'
import { useTranslation } from "react-i18next";
import { Link } from 'react-router-dom';

// redux
import { useDispatch, useSelector } from 'react-redux'
import { getFavoriteItems } from './../../redux/actions/favoriteActions'

//components
import FavoriteItem from './FavoriteItem';
import Loader from '../../components/Loader';


const Favorite = () => {

    //translate
    const { t } = useTranslation();

    // fetch from api
    const dispatch = useDispatch()

    const { loading, favoriteItems, error } = useSelector(state => state.favoriteItems)

    useEffect(() => {

        dispatch(getFavoriteItems())

    }, [dispatch, error])


    return (
        <div className='d-flex flex-column container mt-4 favorite-page '>

            <div className="d-flex align-items-center page-names  mb-4">

                <Link to="/" className="text-decoration-none d-flex align-items-center ">
                    <HomeOutlinedIcon style={{ color: grey[500] }} />
                    <span className="page-name mx-1">{t("Home")}</span>
                </Link>

                <ArrowBackIosOutlinedIcon fontSize="medium" style={{ color: grey[300] }} />

                <span className="page-name ">{t("Favorite")}</span>

            </div>

            <Fragment>
                {loading ? <Loader /> :

                    <div className='d-flex flex-column items-fav'>
                        <span className='mb-3 items-num'>{favoriteItems && favoriteItems.length} &nbsp; {t("Favorite Items")}</span>
                        <div className='row items'>

                            {favoriteItems && favoriteItems.map(item =>

                                <div className='col-12 mb-3' key={item.id}>

                                    <FavoriteItem item={item} />
                                </div>
                            )}

                        </div>
                    </div>
                }
            </Fragment>
        </div>
    )
}

export default Favorite;