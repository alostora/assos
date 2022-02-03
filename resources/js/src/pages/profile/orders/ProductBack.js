//react
import React, { useState, useEffect } from 'react';

//translate
import { useTranslation } from "react-i18next"

//component
import { Form } from 'react-bootstrap';
import { axiosInstance } from '../../../axios/config';

const ProductBack = () => {

    //translate
    const { t } = useTranslation();

    const [reasonsBack, setReasonsBack] = useState([])

    const [itemBackReasonId, setItemBackReasonId] = useState()

    const [itemBackNotes, setItemBackNotes] = useState("")

    const [readPolicy, setReadPolicy] = useState(false)

    const getReasonsBack = () => {

        axiosInstance({
            method: "get",
            url: `/itemBackReasons`,
        })
            .then(res => res.data)
            .then(data => setReasonsBack(data.reasons))
            .catch(err => console.error(err))
    }

    useEffect(() => {
        getReasonsBack();
    }, [])

    const requestBackProduct = () => {

        console.log("back product")
        console.log(itemBackReasonId)
        console.log(itemBackNotes)
    }

    return (
        <div className='d-flex flex-column product-return'>

            <span className='header mb-2'>{t("Product Return")}</span>


            <form className='row mt-4' onSubmit={requestBackProduct}>
                <Form.Group className="mb-3 col-lg-6 col-12" controlId="formPlainDate">

                    <Form.Label className='secondary-header'>{t("Order Date")}</Form.Label>

                    <Form.Control type="text" placeholder="15-11-11" disabled
                        value="15-11-11" className='custom-input'
                    />

                </Form.Group>

                <Form.Group className="mb-3 col-lg-6 col-12" controlId="formPlainOrderNumber">

                    <Form.Label className='secondary-header'>{t("Order Number")}</Form.Label>

                    <Form.Control type="text" placeholder="5631" disabled
                        value="5631" className='custom-input'
                    />

                </Form.Group>

                <Form.Group className="mb-3 col-lg-6 col-12" controlId="formPlainProductCount">

                    <Form.Label className='secondary-header'>{t("Count")}</Form.Label>

                    <Form.Control type="text" placeholder="2" disabled
                        value="2" className='custom-input'
                    />

                </Form.Group>

                <Form.Group className="mb-3 col-lg-6 col-12" controlId="formPlainProductNumber">

                    <Form.Label className='secondary-header'>{t("Product Number")}</Form.Label>

                    <Form.Control type="text" placeholder="5631" disabled
                        value="5631" className='custom-input'
                    />

                </Form.Group>

                <Form.Group className="mb-3 col-12" controlId="formPlainReason">

                    <Form.Label className='secondary-header'>{t("Reason for return")}</Form.Label>

                    <Form.Select aria-label="Default select example" className='px-5' required
                        onChange={e => setItemBackReasonId(e.target.value)} >

                        {reasonsBack && reasonsBack.map(reason => (

                            <option value={reason.id} key={reason.id}>

                                {reason.backReasonName}
                            </option>
                        ))}
                    </Form.Select>
                </Form.Group>

                <Form.Group className="mb-4 col-12" controlId="ControlTextarea">

                    <Form.Label className='secondary-header'>{t("Other Notes")}</Form.Label>
                    <Form.Control as="textarea" rows={4}

                        placeholder={t("Write your notes here, if any")}
                        value={itemBackNotes}
                        onChange={(e) => setItemBackNotes(e.target.value)} />

                </Form.Group>

                <Form.Group className="mb-3 col-lg-6 col-12 secondary-header" controlId="formBasicCheckbox" >
                    <Form.Check type="checkbox" label={t("I have read and agree to the return policy")} required
                        value={readPolicy}
                        onChange={(e) => setReadPolicy(e.target.checked)} />

                </Form.Group>

                {/* {errorMessage && <span className='error-message mb-2'> {errorMessage}</span>} */}

                <div className='d-flex justify-content-center mt-3'>

                    <button
                        type="submit"
                        className="btn-send-request d-flex justify-content-center align-items-center">
                        {t("Send Request")}
                    </button>
                </div>

            </form>
        </div>
    )
};

export default ProductBack;