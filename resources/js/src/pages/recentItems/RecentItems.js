import React from 'react'
import { useTranslation } from "react-i18next";
import { Link } from 'react-router-dom';

//icons material-ui
import HomeOutlinedIcon from '@mui/icons-material/HomeOutlined';
import ArrowBackIosOutlinedIcon from '@mui/icons-material/ArrowBackIosOutlined';
import { grey } from '@mui/material/colors';

//component
import PaginatedItems from '../../components/PaginatedItems';
import Loader from '../../components/Loader';


const RecentItems = ({ recentItems }) => {

    //translate
    const { t } = useTranslation();

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

                {recentItems ?

                    <div className="recent-items container ">

                        {recentItems && recentItems.length > 0 &&

                            <PaginatedItems items={recentItems} itemsPerPage={4} />
                        }

                    </div>

                    : <Loader />
                }

            </div>

        </div>
    )
}

export default RecentItems;