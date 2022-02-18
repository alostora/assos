//react
import React, { useState, useEffect, Fragment } from "react";

//translate
import { useTranslation } from "react-i18next"

//material ui
import FiberManualRecordIcon from '@mui/icons-material/FiberManualRecord';
import { green, red } from '@mui/material/colors';

//component
import Loader from "../../../components/Loader";
import { axiosInstance } from "../../../axios/config";
import Moment from 'react-moment';


const Notifications = () => {

    //translate
    const { t } = useTranslation();

    // get notifications
    const [notifications, setNotifications] = useState([])

    const [loading, setLoading] = useState(true)

    const getNotifications = async () => {

        await axiosInstance({
            method: "get",
            url: `/userNotifi`,
        })
            .then(res => res.data)
            .then(data => {
                setLoading(!data.status);
                setNotifications(data.notifiis);
            })

            .catch((err) => console.error(err));
    }

    useEffect(() => {

        getNotifications()

    }, [])


    return (

        <Fragment>
            {loading ? <Loader /> :

                <div className="d-flex flex-column notification-page ">

                    <span className="section-header mb-4">{t("Notifications")}</span>

                    {notifications && notifications.length > 0 ?

                        <Fragment>

                            {notifications && notifications.map(notifi => (

                                <div className="d-flex flex-column notifi-body mb-3" key={notifi.id}>

                                    <div className='d-flex justify-content-between align-items-center'>

                                        <Moment format="D MMM YYYY" className="notifi-date">{notifi.created_at}</Moment>

                                        <FiberManualRecordIcon fontSize="small" sx={{ color: notifi.read ? green[800] : red[800] }} />

                                    </div>

                                    <span className='header'>{notifi.title}</span>

                                    <span className="notifi-content pb-2">{notifi.body} </span>
                                </div>
                            ))}
                        </Fragment>

                        :
                        <div className='d-flex flex-column justify-content-center align-items-center my-5'>

                            <h4 className='d-flex my-3'>{t("There are no Notifications at the moment")}</h4>
                        </div>
                    }
                </div>
            }
        </Fragment >
    )
}

export default Notifications