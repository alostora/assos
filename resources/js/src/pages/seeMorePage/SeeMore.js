import React, { useCallback, useEffect, useState } from 'react'
import { useTranslation } from "react-i18next";
import { Link, useParams } from 'react-router-dom';

//icons material-ui
import HomeOutlinedIcon from '@mui/icons-material/HomeOutlined';
import ArrowBackIosOutlinedIcon from '@mui/icons-material/ArrowBackIosOutlined';
import { grey } from '@mui/material/colors';

//component
import PaginatedItems from '../../components/PaginatedItems';
import Loader from '../../components/Loader';
import { axiosInstance } from '../../axios/config';

const SeeMore = () => {

    //translate
    const { t } = useTranslation();

    const { category_items } = useParams()

    const [items, setItems] = useState([])

    const getSeeMoreItems = useCallback(async () => {

        await axiosInstance({
            method: "get",
            url: `/seeMore/${category_items}`,
        })
            .then(res => res.data)
            .then(data => setItems(data.items.data))

            .catch((err) => console.error(err));
            
    }, [category_items])

    useEffect(() => {

        getSeeMoreItems();

    }, [getSeeMoreItems])

    return (

        <div className='recent-items-page d-flex flex-column my-4'>

            <div className="d-flex align-items-center page-names container mb-4">

                <Link to="/" className="text-decoration-none d-flex align-items-center ">
                    <HomeOutlinedIcon style={{ color: grey[500] }} />
                    <span className="page-name mx-1">{t("Home")}</span>
                </Link>

                <ArrowBackIosOutlinedIcon fontSize="medium" style={{ color: grey[300] }} />

                <span className="page-name ">{t("recently arrived")}</span>

            </div>

            <div>

                {items ?

                    <div className="recent-items container ">

                        {items && items.length > 0 &&

                            <PaginatedItems items={items} itemsPerPage={4} />
                        }

                    </div>

                    : <Loader />
                }

            </div>

        </div>
    )
}

export default SeeMore;