import React from 'react'

// import {
//     MFSettings,
//     MFPaymentRequest,
//     MFCustomerAddress,
//     MFExecutePaymentRequest,
//     MFCardInfo,
//     Response,
//     MFSendPaymentRequest,
//     MFLanguage,
//     MFNotificationOption,
//     MFPaymentype,
//     MFMobileCountryCodeISO,
//     MFCurrencyISO,
//     MFPaymentStatusRequest,
//     MFKeyType,
//     MFInitiatePayment

// } from 'myfatoorah-javascript';

const Payment = () => {

    // let baseURL = "https://apitest.myfatoorah.com/";
    // let token = "rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL";
    // // let directPaymentToken = 'fVysyHHk25iQP4clu6_wb9qjV3kEq_DTc1LBVvIwL9kXo9ncZhB8iuAMqUHsw-vRyxr3_jcq5-bFy8IN-C1YlEVCe5TR2iCju75AeO-aSm1ymhs3NQPSQuh6gweBUlm0nhiACCBZT09XIXi1rX30No0T4eHWPMLo8gDfCwhwkbLlqxBHtS26Yb-9sx2WxHH-2imFsVHKXO0axxCNjTbo4xAHNyScC9GyroSnoz9Jm9iueC16ecWPjs4XrEoVROfk335mS33PJh7ZteJv9OXYvHnsGDL58NXM8lT7fqyGpQ8KKnfDIGx-R_t9Q9285_A4yL0J9lWKj_7x3NAhXvBvmrOclWvKaiI0_scPtISDuZLjLGls7x9WWtnpyQPNJSoN7lmQuouqa2uCrZRlveChQYTJmOr0OP4JNd58dtS8ar_8rSqEPChQtukEZGO3urUfMVughCd9kcwx5CtUg2EpeP878SWIUdXPEYDL1eaRDw-xF5yPUz-G0IaLH5oVCTpfC0HKxW-nGhp3XudBf3Tc7FFq4gOeiHDDfS_I8q2vUEqHI1NviZY_ts7M97tN2rdt1yhxwMSQiXRmSQterwZWiICuQ64PQjj3z40uQF-VHZC38QG0BVtl-bkn0P3IjPTsTsl7WBaaOSilp4Qhe12T0SRnv8abXcRwW3_HyVnuxQly_OsZzZry4ElxuXCSfFP2b4D2-Q';

    // useEffect(() => {


    //     MFSettings.sharedInstance.configure(baseURL, token);

    //     console.log(MFSettings.sharedInstance.configure(baseURL, token))

    //     const fatora = require('myfatoorah-javascript')

    //     console.log(fatora)
    // }, [])


    // const executeResquestJson = () => {
    //     let request = new MFExecutePaymentRequest(parseFloat(100), "Meeza");
    //     request.customerEmail = "a@b.com"; // must be email
    //     request.customerMobile = "";
    //     request.customerCivilId = "";
    //     let address = new MFCustomerAddress("ddd", "sss", "sss", "sss", "sss");
    //     request.customerAddress = address;
    //     request.customerReference = "";
    //     request.language = "en";
    //     request.mobileCountryCode = MFMobileCountryCodeISO.KUWAIT;
    //     request.displayCurrencyIso = MFCurrencyISO.KUWAIT_KWD;
    //     // var productList = []
    //     // var product = new MFProduct("ABC", 1.887, 1)
    //     // productList.push(product)
    //     // request.invoiceItems = productList
    //     return request;
    // }
    // const executePayment = () => {
    //     let request = executeResquestJson();
    //     MFPaymentRequest.sharedInstance.executePayment(request, MFLanguage.ENGLISH, (response) => {
    //         if (response.getError()) {
    //             alert('error: ' + response.getError().error);
    //         }
    //         else {
    //             var bodyString = response.getBodyString();
    //             alert('success' + bodyString);
    //         }
    //     });
    // }

    // const getCardInfo = () => {
    //     let cardExpiryMonth = '05'
    //     let cardExpiryYear = '21'
    //     let cardSecureCode = '100'
    //     let paymentType = MFPaymentype.CARD
    //     // let paymentType = MFPaymentype.TOKEN
    //     let saveToken = false
    //     let card = new MFCardInfo('5123450000000008', cardExpiryMonth, cardExpiryYear, cardSecureCode, paymentType, saveToken)
    //     card.bypass = true
    //     return card
    // }
    // const executeDirectPayment = () => {
    //     let request = executeResquestJson();
    //     let cardInfo = getCardInfo()
    //     MFPaymentRequest.sharedInstance.executeDirectPayment(request, cardInfo, MFLanguage.ENGLISH, (response) => {
    //         if (response.getError()) {
    //             alert('error: ' + response.getError().error)
    //         }
    //         else {
    //             var bodyString = response.getBodyString();
    //             alert('success' + bodyString);
    //         }
    //     });
    // }

    // const getPaymentStatus = () => {
    //     var paymentStatusRequest = new MFPaymentStatusRequest('111111', MFKeyType.PAYMENTID);
    //     MFPaymentRequest.sharedInstance.getPaymentStatus(paymentStatusRequest, MFLanguage.ENGLISH, (response) => {
    //         if (response.getError()) {
    //             alert('error: ' + response.getError().error)
    //         }
    //         else {
    //             var bodyString = response.getBodyString();
    //             alert('success' + bodyString);
    //         }
    //     });
    // }

    // //region HANDLERS
    // const onExecutePaymentButtonClickHandler = () => {
    //     executePayment();
    // };

    // const onExecuteDirectPaymentButtonClickHandler = () => {
    //     executeDirectPayment();
    // };

    // const onExecuteRecurringPaymentButtonClickHandler = () => {
    //     executeRecurringPayment();
    // };

    // const onCancelRecurringPaymentButtonClickHandler = () => {
    //     cancelRucrring();
    // };

    // const onSendPaymentButtonClickHandler = () => {
    //     sendPayment();
    // };
    // //endregion

    return (
        <div>
            Payment
            {/* <button
                onClick={onSendPaymentButtonClickHandler}>
                Send Payment
            </button>

            <button
                onClick={onExecutePaymentButtonClickHandler}
            >
                Execute Payment
            </button>

            <button
                onClick={onExecuteDirectPaymentButtonClickHandler}
            >
                Execute Direct Payment
            </button>

            <button
                onClick={onExecuteRecurringPaymentButtonClickHandler}>
                Execute Recurring Payment
            </button>
            <button
                onClick={onCancelRecurringPaymentButtonClickHandler}>
                Cancel Recurring Payment
            </button> */}

        </div>
    )
}

export default Payment;
