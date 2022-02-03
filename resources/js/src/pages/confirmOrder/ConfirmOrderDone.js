//react
import React from 'react';

//react router
import { useParams } from 'react-router-dom';

//translate
import { useTranslation } from "react-i18next";

//material ui
import CheckCircleOutlineIcon from '@mui/icons-material/CheckCircleOutline';
import { green } from '@mui/material/colors';


const ConfirmOrderDone = () => {

    //translate
    const { t } = useTranslation();

    //order id
    const { order_id } = useParams();

    console.log(order_id)

    return (
        <div className='d-flex flex-column mt-5 '>

            <div className='d-flex flex-column justify-content-center align-items-center mt-5'>
                <CheckCircleOutlineIcon sx={{ color: green[500] }} fontSize='large' />
                <h3 className='my-2'>{t("Thank you for your order from Molk")}</h3>
            </div>

        </div>
    )

};

export default ConfirmOrderDone;