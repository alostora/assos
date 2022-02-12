//react
import React, { useEffect } from 'react'
import { useTranslation } from "react-i18next";

// redux
import { useDispatch, useSelector } from 'react-redux'
import { getHomePage } from '../../redux/actions/homeActions';

//react router dom
import { Link } from 'react-router-dom';

//icons material-ui
import HomeOutlinedIcon from '@mui/icons-material/HomeOutlined';
import ArrowBackIosOutlinedIcon from '@mui/icons-material/ArrowBackIosOutlined';
import { grey } from '@mui/material/colors';

//component
import PaginatedItems from '../../components/PaginatedItems';
import Loader from '../../components/Loader';


const LastChance = ({ lastChanceItems }) => {

    //translate
    const { t } = useTranslation();

    // fetch from api
    const dispatch = useDispatch()

    const { loading, homePage, error } = useSelector(state => state.homePage)

    useEffect(() => {

        dispatch(getHomePage())

    }, [dispatch, error])

    return (

        <div className='recent-items-page d-flex flex-column my-4'>

            <div className="d-flex align-items-center page-names container mb-4">

                <Link to="/molk" className="text-decoration-none d-flex align-items-center ">
                    <HomeOutlinedIcon style={{ color: grey[500] }} />
                    <span className="page-name mx-1">{t("Home")}</span>
                </Link>

                <ArrowBackIosOutlinedIcon fontSize="medium" style={{ color: grey[300] }} />

                <span className="page-name ">{t("Last Chance")}</span>

            </div>

            {loading ? <Loader /> :

                <div className='d-flex flex-column container items-category mb-5'>
                    <span className="header d-flex mb-4">{t("Offers")}</span>

                    <div className="row mx-0 justify-content-center align-items-center ">

                        {homePage && homePage.offers.map(offer => (

                            <div className='d-flex flex-column col-lg-4 col-6 my-2 item-category' key={offer.id}>
                                <Link to={`/offer-items/${offer.id}`}
                                    className="text-decoration-none d-flex flex-column"
                                >
                                    <img src={offer.offerImage} alt="categoryImage" />
                                    <span className='category-name my-2'>{offer.offerName}</span>
                                </Link>
                            </div>

                        ))}
                    </div>
                </div>
            }

            {lastChanceItems ?

                <div className="recent-items container">

                    <span className="header d-flex mb-4">{t("Products")}</span>

                    {lastChanceItems && lastChanceItems.length > 0 &&

                        <PaginatedItems items={lastChanceItems} itemsPerPage={4} />
                    }

                </div>

                : <Loader />
            }

        </div>
    )
}

export default LastChance;